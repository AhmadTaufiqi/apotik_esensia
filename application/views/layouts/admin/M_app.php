<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_app extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function admin_template($data, $content)
    {
        $this->load->view('layouts/admin/head', $data);
        // $this->load->view('layouts/topbar-search', $data);
        // $this->load->view("layouts/navbars/" . $data['navbar']);
        // $this->load->view('layouts/menu');
        $this->load->view($content);
        $this->load->view('layouts/admin/foot');
    }

    public function template($data, $content)
    {
        $this->load->view('layouts/head', $data);
        $this->load->view('layouts/topbar-search', $data);
        // $this->load->view("layouts/navbars/" . $data['navbar']);
        // $this->load->view('layouts/menu');
        $this->load->view($content);
        $this->load->view('layouts/foot');
    }

    public function templateCart($data, $content)
    {
        $this->load->view('layouts/head', $data);
        $this->load->view('layouts/topbar-cart', $data);
        // $this->load->view("layouts/navbars/" . $data['navbar']);
        // $this->load->view('layouts/menu');
        $this->load->view($content);
        $this->load->view('layouts/foot-cart');
    }

    public function uploadFile($dir, $types, $name, $default)
    {
        $config['upload_path']   = './src/uploads/' . $dir;
        $config['allowed_types'] = $types;
        $config['encrypt_name'] = true;

        $this->load->library('upload');
        $this->upload->initialize($config);
        if ($this->upload->do_upload($name)) {
            return $this->upload->data("file_name");
        }
        return $default;
    }

    public function updateFile($dir, $file, $types, $name, $default)
    {
        if (empty($_FILES[$name]['name'])) {
            return $file;
        } else {
            if ($file != $default) {
                unlink('./src/uploads/'.$dir.'/'.$file); }
            return $this->uploadFile($dir, $types, $name, $default);
        }
    }

    public function date()
    {
        date_default_timezone_set('Asia/Jakarta');
        return date('Y-m-d');
    }

    public function datetime()
    {
        date_default_timezone_set('Asia/Jakarta');
        return date('Y-m-d H:m:s');
    }

    public function formatTanggalIndonesia() {
        $dateTime = new DateTime();

        $formatter = new IntlDateFormatter(
            'id_ID',
            IntlDateFormatter::LONG,
            IntlDateFormatter::NONE,
            'Asia/Jakarta',
            IntlDateFormatter::GREGORIAN,
            'd MMMM yyyy'
        );

        return $formatter->format($dateTime);
    }

    public function upload_config($path) {
		if (!is_dir($path)) 
		mkdir($path, 0777, TRUE);		
		$config['upload_path'] 	= './'.$path;		
		$config['allowed_types'] = 'csv|CSV|xlsx|XLSX|xls|XLS';
		$config['max_filename']	 = '255';
		$config['encrypt_name'] = TRUE;
		$config['max_size']  = 4096; 
		$this->load->library('upload');
		$this->upload->initialize($config);
	}

    public function select($select, $table, $by = 'created_at', $order = 'DESC')
    {
        return $this->db->select($select)
            ->from($table)
            ->order_by($by, $order)
            ->get();
    }

    public function select_join_2table($select, $table, $table2, $on, $by = 'created_at', $order = 'DESC')
    {
        return $this->db->select($select)
            ->from($table)
            ->join($table2, $on)
            ->order_by($by, $order)
            ->get();
    }

    public function select_join_3table($select, $table, $table2, $table3, $on, $on2, $by = 'created_at', $order = 'DESC')
    {
        return $this->db->select($select)
            ->from($table)
            ->join($table2, $on)
            ->join($table3, $on2)
            ->order_by($by, $order)
            ->get();
    }

    public function select_where($select, $table, $where, $by = 'created_at', $order = 'DESC')
    {
        return $this->db->select($select)
            ->from($table)
            ->where($where)
            ->order_by($by, $order)
            ->get();
    }

    public function select_where_join_2table($select, $table, $table2, $on, $where, $by = 'created_at', $order = 'DESC')
    {
        return $this->db->select($select)
            ->from($table)
            ->join($table2, $on)
            ->where($where)
            ->order_by($by, $order)
            ->get();
    }

    public function select_where_join_2table_type($select, $table, $table2, $on, $type, $where, $by = 'created_at', $order = 'DESC')
    {
        return $this->db->select($select)
            ->from($table)
            ->join($table2, $on, $type)
            ->where($where)
            ->order_by($by, $order)
            ->get();
    }

    public function select_where_join_3table($select, $table, $table2, $table3, $on, $on2, $where, $by = 'created_at', $order = 'DESC')
    {
        return $this->db->select($select)
            ->from($table)
            ->join($table2, $on,)
            ->join($table3, $on2,)
            ->where($where)
            ->order_by($by, $order)
            ->get();
    }

    public function select_where_join_3table_type($select, $table, $table2, $table3, $on, $on2, $type, $where, $by = 'created_at', $order = 'DESC')
    {
        return $this->db->select($select)
            ->from($table)
            ->join($table2, $on, $type)
            ->join($table3, $on2, $type)
            ->where($where)
            ->order_by($by, $order)
            ->get();
    }

    public function log_activity($activity)
    {
        $data['id'] = $this->uuid->v4();
        $data['user_id'] = $this->session->userdata('id_akun');
        $data['activity'] = $this->session->userdata('nama_akun').$activity;
        $this->db->insert('log_activity', $data);
    }

    public function insert($table, $data, $activity)
    {
        $data['created_at'] = $this->datetime();
        $data['updated_at'] = $this->datetime();
        $this->db->insert($table, $data);
        if ($this->db->affected_rows() > 0) {
            $this->log_activity(' menambahkan data baru '.$activity);
            return true;
        } else {
            return false;
        }
    }

    public function update($table, $where, $data, $activity)
    {
        $data['updated_at'] = $this->datetime();
        $this->db->where($where);
        $this->db->update($table, $data);
        if ($this->db->affected_rows() > 0) {
            $this->log_activity(' mengubah data '.$activity);
            return true;
        } else {
            return false;
        }
    }

    public function delete($table, $where, $activity)
    {
        $data['deleted_at'] = $this->datetime();
        $this->db->where($where);
        $this->db->update($table, $data);
        if ($this->db->affected_rows() > 0) {
            $this->log_activity(' menghapus data '.$activity);
            return true;
        } else {
            return false;
        }
    }

    public function rollback($table, $where, $activity) {
        $this->log_activity(' gagal menyimpan data '.$activity);
        $this->db->where($where);
        $this->db->delete($table);
    }

    public function insert_batch($table, $data, $activity)
    {
        $this->db->insert_batch($table, $data);
        if ($this->db->affected_rows() > 0) {
            $this->log_activity(' import data baru '.$activity);
            return true;
        } else {
            return false;
        }
    }

    public function update_batch($table, $data, $where, $activity) 
    {        
        $this->db->update_batch($table, $data, $where);
        if ($this->db->affected_rows() > 0) {
            $this->log_activity($activity);
            return true;
        } else {
            return false;
        }
    }

    public function dashboard_activity() {
        $dateNow = $this->date();
        $q = $this->db->query("SELECT a.*, b.nama, b.foto FROM log_activity as a JOIN users as b ON a.user_id = b.id
            WHERE a.created_at >= '".$dateNow."' AND a.created_at <= '".$dateNow." 23:59:00' ORDER BY created_at DESC LIMIT 5")->result_array();
        return $q;
    }

}