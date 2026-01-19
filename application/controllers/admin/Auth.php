<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('M_app');

		// admin role = 1
		// user role = 2
		// kasir role = 3
		// kurir role = 4
	}

	public function index()
	{
		if (!$this->input->post('email')) {
			$this->load->view('auth/admin/login');
		} else {
			$this->_login();
		}
	}

	private function _login()
	{
		$email = $this->input->post('email');
		// $password = md5($this->input->post('password'));
		$password = $this->input->post('password');

		$user = $this->db->get_where('users', ['email' => $email, 'role !=' => 2, 'deleted_at' => NULL])->row_array();

		//if usser ada
		if ($user) {
			if ($user['role'] != 2) {
				//cek password
				if ($password == $user['password']) {
					$user_foto = 'default.png';
					if (strlen($user['foto']) > 0 && file_exists(FCPATH . 'dist/img/uploads/users/' . $user['foto'])) {
						$user_foto = $user['foto'];
					}
					$data = [
						'id_akun' => $user['id'],
						'user_akun' => $user['email'],
						'nama_akun' => $user['name'],
						'foto_akun' => $user_foto,
						'hp_akun' => $user['telp'],
						'role' => $user['role']
					];

					$this->session->set_userdata($data);

					if ($user['role'] == 1) {
						// redirect(base_url('admin/dashboard'));
						redirect(base_url('admin/product'));
					} elseif ($user['role'] == 3) {
						// menampilan orders status 
						redirect(base_url('kasir/Orders'));
					} elseif ($user['role'] == 4) {
						// hanya order yang sudah terbayar dan perlu di kirim
						redirect(base_url('kurir/Orders'));
					}
				} else {
					// var_dump("password salah");
					$this->session->set_flashdata('msg_pass', '<small class="text-danger pl-2">password salah</small>');
					redirect(base_url('admin/auth'));
				}
			} else {
				$this->session->set_flashdata('msg_login', '<div class="alert alert-warning">User tidak memiliki akses panel admin</div>');
				redirect(base_url('admin/auth'));
			}
		} else {
			$this->session->set_flashdata('msg', '<small class="text-danger pl-2">email tidak terdaftar</small>');
			redirect(base_url('admin/auth'));
		}
	}

	public function logout()
	{
		$this->session->sess_destroy();
		redirect(base_url('admin/auth'));
	}
}
