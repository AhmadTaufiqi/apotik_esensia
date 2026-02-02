<?php
defined('BASEPATH') or exit('No direct script access allowed');


use Google\Client;

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

	public function register()
	{
		$data = [
			'title' => 'Daftar Akun Baru'
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
			$this->M_app->login_template($data, 'auth/register');
		} else {
			$this->_register();
		}
	}

	private function _login()
	{
		$email = $this->input->post('email');
		// $password = md5($this->input->post('password'));
		$password = $this->input->post('password');

		$user = $this->db->get_where('users', ['email' => $email, 'role' => 2, 'deleted_at' => NULL])->row_array();

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
						redirect(base_url('home'));
					}
				} else {
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

	private function _register()
	{
		$name = $this->input->post('name');
		$email = $this->input->post('email');
		$password = $this->input->post('password');
		$confirm_password = $this->input->post('confirm_password');

		// Validation
		if (empty($name)) {
			$this->session->set_flashdata('msg_name', '<small class="text-danger pl-2">Nama tidak boleh kosong</small>');
			redirect(base_url('auth/register'));
		}

		if (empty($email)) {
			$this->session->set_flashdata('msg_email', '<small class="text-danger pl-2">Email tidak boleh kosong</small>');
			redirect(base_url('auth/register'));
		}

		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$this->session->set_flashdata('msg_email', '<small class="text-danger pl-2">Format email tidak valid</small>');
			redirect(base_url('auth/register'));
		}

		if (empty($password)) {
			$this->session->set_flashdata('msg_pass', '<small class="text-danger pl-2">Password tidak boleh kosong</small>');
			redirect(base_url('auth/register'));
		}

		if ($password != $confirm_password) {
			$this->session->set_flashdata('msg_confirm', '<small class="text-danger pl-2">Konfirmasi password tidak cocok</small>');
			redirect(base_url('auth/register'));
		}

		// Check if email exists
		$user = $this->db->get_where('users', ['email' => $email, 'deleted_at' => NULL])->row_array();
		if ($user) {
			$this->session->set_flashdata('msg_email', '<small class="text-danger pl-2">Email sudah terdaftar</small>');
			redirect(base_url('auth/register'));
		}

		// Insert new user
		$data = [
			// 'id' => $this->uuid->v4(),
			'name' => $name,
			'email' => $email,
			'password' => $password, // plain text as in login
			'role' => 2,
			'foto' => 'default.png',
			'created_at' => date('Y-m-d H:i:s'),
			'updated_at' => date('Y-m-d H:i:s')
		];

		$address = [
			// 'kecamatan' => '',
			'long' => '',
			'lat' => '',
			'kota' => '',
			'kelurahan' => '',
			'kecamatan' => '',
			'provinsi' => '',
			'kode_pos' => '',
			'created_at' => date('Y-m-d H:i:s'),
			'updated_at' => date('Y-m-d H:i:s')
		];

		$this->db->trans_start();
		$this->db->insert('users', $data);

		$user_id = $this->db->insert_id();
		$address['user_id'] = $user_id;
		$this->db->insert('address', $address);

		$this->db->trans_complete();

		// Set session
		$user_foto = 'default.png';
		$data_session = [
			'id_akun' => $this->db->insert_id(),
			'user_akun' => $data['email'],
			'nama_akun' => $data['name'],
			'foto_akun' => $user_foto,
			'role' => $data['role']
		];

		$this->session->set_userdata($data_session);

		$this->session->set_flashdata('msg', '<small class="text-danger pl-2">Akun berhasil didaftarkan. Silahkan masuk</small>');

		redirect(base_url('auth'));
	}


	public function login_google()
	{
		$client_id = '567532871184-c6uv0j8bjsl4374g0ks2qqvupbenrag5.apps.googleusercontent.com';
		$client_secret = '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';
		$redirect_uri = base_url('auth/login_google');

		$client = new Client();

		$client->setClientId($client_id);
		$client->setClientSecret($client_secret);
		$client->setRedirectUri($redirect_uri);

		$client->addScope("email");
		$client->addScope("profile");

		$code = $this->input->get('code');

		if (isset($code)) {
			$token = $client->fetchAccessTokenWithAuthCode($code);

			if (!isset($token["error"])) {
				$client->setAccessToken($token['access_token']);

				$google_oauth = new \Google\Service\Oauth2($client);
				$google_account_info = $google_oauth->userinfo->get();

				$g_email =  $google_account_info->email;
				$g_name =  $google_account_info->name;
				$g_id =  $google_account_info->id;

				$user = $this->db->get_where('users', ['oauth_id' => $g_id, 'deleted_at' => NULL])->row_array();

				if ($user) {
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

					redirect(base_url('home'));
				} else {
					// User already exists, redirect to login
					$this->session->set_flashdata('msg', '<small class="text-danger pl-2">Email tidak terdaftar, silahkan daftar terlebih dahulu</small>');
					redirect(base_url('auth'));
				}
			} else {
				$this->session->set_flashdata('msg', '<small class="text-danger pl-2">Gagal login dengan akun Google</small>');
				redirect(base_url('auth'));
			}
		} else {
			redirect($client->createAuthUrl());
		}
	}

	public function register_google()
	{
		$client_id = '567532871184-c6uv0j8bjsl4374g0ks2qqvupbenrag5.apps.googleusercontent.com';
		$client_secret = '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';
		$redirect_uri = base_url('auth/register_google');

		$client = new Client();

		$client->setClientId($client_id);
		$client->setClientSecret($client_secret);
		$client->setRedirectUri($redirect_uri);

		$client->addScope("email");
		$client->addScope("profile");

		$code = $this->input->get('code');
		if (isset($code)) {
			$token = $client->fetchAccessTokenWithAuthCode($code);
			if (!isset($token["error"])) {
				$client->setAccessToken($token['access_token']);

				$google_oauth = new \Google\Service\Oauth2($client);
				$google_account_info = $google_oauth->userinfo->get();
				var_dump($google_account_info);

				$g_email = $google_account_info->email;
				$g_name = $google_account_info->name;
				$g_id = $google_account_info->id;

				// Check if user exists
				$user = $this->db->get_where('users', ['oauth_id' => $g_id, 'deleted_at' => NULL])->row_array();

				if (!$user) {
					// Register new user
					$data = [
						// 'id' => $this->uuid->v4(),
						'name' => $g_name,
						'email' => $g_email,
						'oauth_id' => $g_id,
						'password' => '',
						'role' => 2,
						'foto' => 'default.png',
						'created_at' => date('Y-m-d H:i:s'),
						'updated_at' => date('Y-m-d H:i:s')
					];

					$address = [
						// 'kecamatan' => '',
						'long' => '',
						'lat' => '',
						'kota' => '',
						'kelurahan' => '',
						'kecamatan' => '',
						'provinsi' => '',
						'kode_pos' => '',
						'created_at' => date('Y-m-d H:i:s'),
						'updated_at' => date('Y-m-d H:i:s')
					];

					$this->db->trans_start();
					$this->db->insert('users', $data);

					$user_id = $this->db->insert_id();
					$address['user_id'] = $user_id;
					$this->db->insert('address', $address);

					$this->db->trans_complete();
					if (!$this->db->trans_status()) {
						$this->session->set_flashdata('msg', '<small class="text-danger pl-2">Registrasi Gagal!</small>');
						redirect(base_url('auth'));
					}

					$this->session->set_flashdata('msg', '<small class="text-success pl-2">Email berhasil didaftarkan, silakan login</small>');
					redirect(base_url('auth'));
				} else {
					// User already exists, redirect to login
					$this->session->set_flashdata('msg', '<small class="text-danger pl-2">Email sudah terdaftar, silakan login</small>');
					redirect(base_url('auth'));
				}
			} else {
				$this->session->set_flashdata('msg', '<small class="text-danger pl-2">Gagal mendaftar dengan Google</small>');
				redirect(base_url('auth'));
			}
		} else {
			redirect($client->createAuthUrl());
		}
	}

	public function logout()
	{
		$this->session->sess_destroy();
		redirect(base_url('auth'));
	}
}
