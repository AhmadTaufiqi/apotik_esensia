<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_user extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
		$this->load->model('M_app');
    }

    public function getId($table) {
        $q = $this->db->query("SELECT MAX(id) AS kd_max FROM $table")->row_array();
        $tmp = ((int) $q['kd_max']) + 1;
        return sprintf("%04s", $tmp);
    }

    public function get_users(){
        // Basic fetch: return all non-deleted users
        $this->db->trans_start();
        $q = $this->db->select('*')
            ->from('users')
            ->where('deleted_at IS NULL', null, false)
            ->get();
        $this->db->trans_complete();

        if ($this->db->trans_status()) {
            return $q->result_array();
        }

        return [];
    }

    /**
     * Flexible users fetch with options
     * $opts = [ 'where' => [...], 'order_by' => 'created_at DESC', 'limit' => 10, 'offset' => 0 ]
     */
    public function fetch_users($opts = [])
    {
        $this->db->trans_start();
        $this->db->select('*')->from('users');

        // exclude deleted by default
        if (empty($opts['include_deleted'])) {
            $this->db->where('deleted_at IS NULL', null, false);
        }

        if (!empty($opts['where']) && is_array($opts['where'])) {
            $this->db->where($opts['where']);
        }

        if (!empty($opts['order_by'])) {
            $this->db->order_by($opts['order_by']);
        }

        if (!empty($opts['limit'])) {
            $offset = isset($opts['offset']) ? (int)$opts['offset'] : 0;
            $this->db->limit((int)$opts['limit'], $offset);
        }

        $q = $this->db->get();
        $this->db->trans_complete();

        if ($this->db->trans_status()) {
            return $q->result_array();
        }

        return [];
    }

    public function get_user_by_id($id) {
        $this->db->trans_start();
        $user = $this->db->select('*')
            ->from('users')
            ->where(['id' => $id])
            ->get()->row_array();
        $this->db->trans_complete();

        if ($this->db->trans_status()) {
            return $user;
        } else {
            return false;
        }
    }

    public function get_user_address_by_id($id) {
        $this->db->trans_start();
        $address = $this->db->select('*')      
            ->from('address')
            ->where(['user_id' => $id])
            ->get()->row_array();
        $this->db->trans_complete();

        if ($this->db->trans_status()) {
            return $address;
        } else {
            return false;
        }
    }

    public function save_user($role)
    {
        $data = [
			// 'id' => $this->uuid->v4(),
			'nama' => ucwords($this->input->post('nama')),
			'username' => $this->input->post('username'),
			'password' => md5($this->input->post('password')),
			'email' => $this->input->post('email'),
			'telp' => $this->input->post('telp'),
			'foto' => $this->M_app->uploadFile('users', 'jpg|jpeg|png', 'foto', 'default.png'),
			'role' => $role,
            'created_at' => $this->M_app->datetime(),
            'updated_at' => $this->M_app->datetime(),
		];

        return $data;
    }

    public function update_user($foto) {
        $user = [
            'nama' => ucwords($this->input->post('nama')),
			'username' => $this->input->post('username'),
			'email' => $this->input->post('email'),
			'telp' => $this->input->post('telp'),
			'foto' => $this->M_app->updateFile('users', $foto, 'jpg|jpeg|png', 'foto', 'default.png'),
            'updated_at' => $this->M_app->datetime(),
        ];

        $password = $this->input->post('password');
        if ($password != '') {
            $user['password'] = md5($password);
        }

        return $user;
    }

    public function save_identitas($role, $table, $activity) {
        $user = $this->save_user($role);

        $identitas = [
            // 'id' => $this->uuid->v4(),
            'user_id' => $user['id'],
            'jenis_identitas' => $this->input->post('jenis_identitas'),
            'nomor_identitas' => $this->input->post('nomor_identitas'),
            'kartu_identitas' => $this->M_app->uploadFile('users/identitas', 'jpg|jpeg|png', 'file', 'default.jpg'),
            'created_at' => $user['created_at'],
            'updated_at' => $user['updated_at'],
        ];

        $data = [
            'id' => $this->getId($table),
            'user_id' => $user['id'],
            'created_at' => $user['created_at'],
            'updated_at' => $user['updated_at'],
        ];
        
        if ($role == 3) {
            $jukirs = [];
            $item = $this->input->post('jukir');
            foreach($item as $val) {
                $jukir = [
                    'id' => $val,
                    'juru_pungut' => $data['id'],
                ];
                array_push($jukirs, $jukir);
            }

            $data['jukir'] = implode(",", $item);
        }

        $this->db->trans_start();
        $this->db->insert('users', $user);
        $this->db->insert('user_identitas', $identitas);
        $this->db->insert($table, $data);

        if ($role == 3) {
            $this->db->update_batch('juru_parkir', $jukirs, 'id');
        }
        $this->db->trans_complete();

        if ($this->db->trans_status()) {
            $this->M_app->log_activity(' menambahkan data baru '.$activity.' ['.$user['id'].']');
            return true;
        } else {
            return false;
        }
    }

    
    /**
     * Ambil daftar nomor telepon (`telp`) dari table `users` berdasarkan role.
     * Parameter $role bisa berupa integer (mis. 1) atau array (mis. [1,3]).
     * Mengabaikan entri kosong atau NULL pada kolom `telp`.
     * Mengembalikan array string nomor telepon.
     *
     * @param int|array $role
     * @return array
     */
    public function getPhoneNumbersByRole($role)
    {
        $this->db->select('telp')
            ->from('users');

        if (is_array($role)) {
            $this->db->where_in('role', $role);
        } else {
            $this->db->where('role', $role);
        }

        // Exclude empty or NULL phone values
        $this->db->where('telp IS NOT NULL', null, false);
        $this->db->where('telp <>', '');

        $query = $this->db->get();
        $rows = $query->result_array();

        return $rows[0]['telp'];
    }

    public function update_identitas($table, $activity, $role = null) {
        $id = $this->input->post('id');

        $foto = $this->input->post('profile');
        $user = $this->update_user($foto);

        $foto_kartu = $this->input->post('foto_kartu');
        $identitas = [
            'jenis_identitas' => $this->input->post('jenis_identitas'),
            'nomor_identitas' => $this->input->post('nomor_identitas'),
            'kartu_identitas' => $this->M_app->updateFile('users/identitas', $foto_kartu, 'jpg|jpeg|png', 'file', 'default.png'),
            'updated_at' => $user['updated_at'],
        ];

        if ($role == 3) {
            $pungut = $this->M_app->select_where('id', 'juru_pungut', ['user_id' => $id])->row_array();
            $jukirs = [];
            $item = $this->input->post('jukir');
            foreach($item as $val) {
                $jukir = [
                    'id' => $val,
                    'juru_pungut' => $pungut['id'],
                ];
                array_push($jukirs, $jukir);
            }

            $data['jukir'] = implode(",", $item);
        }

        $this->db->trans_start();
        $this->db->where(['id' => $id]);
        $this->db->update('users', $user);

        $this->db->where(['user_id' => $id]);
        $this->db->update('user_identitas', $identitas);

        if ($role == 3) {
            $this->db->update_batch('juru_parkir', $jukirs, 'id');
        }
        $this->db->trans_complete();

        if ($this->db->trans_status()) {
            $this->M_app->log_activity(' mengubah data '.$activity.' ['.$id.']');
            return true;
        } else {
            return false;
        }
    }

    public function insert_batch($users, $identities, $datas, $table, $activity) {
        $this->db->trans_start();
        $this->db->insert_batch('users', $users);
        $this->db->insert_batch('user_identitas', $identities);
        $this->db->insert_batch($table, $datas);
        $this->db->trans_complete();

        if ($this->db->trans_status()) {
            $this->M_app->log_activity(' import data baru '.$activity);
            return true;
        } else {
            return false;
        }
    }

    public function hapus($id, $table, $activity) {
        $where = ['user_id' => $id];
        $data = [
            'deleted_at' => $this->M_app->datetime(),
        ];

        $this->db->trans_start();
        $this->db->where(['id' => $id]);
        $this->db->update('users', $data);

        $this->db->where($where);
        $this->db->update('user_identitas', $data);

        $this->db->where($where);
        $this->db->update($table, $data);
        $this->db->trans_complete();

        if ($this->db->trans_status()) {
            $this->M_app->log_activity($activity);
            return true;
        } else {
            return false;
        }
    }

    public function hapus_bulk($table, $users, $data, $activity) {
        $this->db->trans_start();
        $this->db->update_batch('users', $users, 'id');
        $this->db->update_batch('user_identitas', $data, 'user_id');
        $this->db->update_batch($table, $data, 'user_id');
        $this->db->trans_complete();

        if ($this->db->trans_status()) {
            $this->M_app->log_activity($activity);
            return true;
        } else {
            return false;
        }
    }

}