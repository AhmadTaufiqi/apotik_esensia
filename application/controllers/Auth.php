<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('M_app');
	}

	public function index()
	{
		$data = [
			'title' => 'Masuk Dengan Akun Anda'
		];

		$is_nologin = false;
		if (empty($this->session->userdata('id_akun'))) {
			$is_nologin = true;
		} elseif ($this->session->userdata('role') != 2) {
			$is_nologin = true;
		}

		if (!$is_nologin) {
			redirect(base_url('home'));
		}

		if (!$this->input->post('email')) {
			$this->M_app->login_template($data, 'auth/login');
		} else {
			$this->_login();
		}
	}

	private function _login()
	{
		$email = $this->input->post('email');
		// $password = md5($this->input->post('password'));
		$password = $this->input->post('password');

		$user = $this->db->get_where('users', ['email' => $email, 'role' => 2, 'deleted_at' => NULL])->row_array();

// 		var_dump($user);
// exit;
		//if usser ada
		if ($user) {
			
			if ($user['role'] == 1 || $user['role'] == 2 || $user['role'] == 6 || $user['role'] == 8) {
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
						'role' => $user['role']
					];

					$this->session->set_userdata($data);

					if ($user['role'] == 8) {
						redirect(base_url('komplain'));
					} else {
						// redirect(base_url('admin/dashboard'));
						redirect(base_url('home'));
					}
				} else {
					var_dump("password salah");
					$this->session->set_flashdata('msg_pass', '<small class="text-danger pl-2">password salah</small>');
					redirect(base_url('auth'));
				}
			} else {
				$this->session->set_flashdata('msg_login', '<div class="alert alert-warning">User tidak memiliki akses panel admin</div>');
				redirect(base_url('auth'));
			}
		} else {
			$this->session->set_flashdata('msg', '<small class="text-danger pl-2">username tidak terdaftar</small>');
			redirect(base_url('auth'));
		}
	}

	public function logout()
	{
		$this->session->sess_destroy();
		redirect(base_url('auth'));
	}
}
