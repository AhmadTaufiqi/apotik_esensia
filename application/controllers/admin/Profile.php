<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_app');
		if (empty($this->session->userdata('id_akun'))) {
			redirect(base_url('admin/auth'));
		}
	}

	public function index() {
		$user_id = $this->session->userdata('id_akun');
		$user = $this->db
      ->select('*')
      ->from('users')
      ->where(['id' => $user_id])
      ->get()
      ->row_array();

		$data = [
			'title' => 'Profile',
			'name' => $user['name'],
			'email' => $user['email'],
			'telp' => $user['telp'],
			'foto' => $user['foto'],
			'role' => $user['role']
		];

		$this->M_app->admin_template($data, 'profile/admin_profile');
  }

	public function save() {
		$id = $this->session->userdata('id_akun');
		$foto = $this->input->post('foto');
		$activity = 'users ['.$id.']';

		$data = [
			'name' => $this->input->post('name'),
			'telp' => $this->input->post('telp'),
			// 'foto' => $this->M_app->updateFile('users', $foto, 'jpg|jpeg|png', 'file', 'default.png')
			'foto' => $this->M_app->uploadBase64('users', 'jpg|jpeg|png', 'foto_base64', 'default.png'),
		];

		$update = $this->M_app->update('users', ['id' => $id], $data, $activity);
		if ($update) {
			$msg = [
				'status' => 200,
				'msg_akun' => $this->session->userdata('id_akun'),
			];

			$foto = [
				'foto_akun' => $data['foto']
			];
			$this->session->set_userdata($foto);
		} else {
			$msg = [
				'status' => 400,
				'msg_akun' => $this->session->userdata('id_akun'),
			];
		}
		$this->session->set_userdata($msg);

		$data = $this->session->userdata();
		// print_r($data);
		redirect(base_url('admin/profile'));
	}

	public function save_pass() {
		$id = $this->session->userdata('id_akun');
		$activity = 'users ['.$id.']';

		$q = $this->M_app->select_where('users.password', 'users', ['id' => $id])->row_array();
		$dataPass = $q['password'];
		$oldPass = md5($this->input->post('old_pass'));

		if ($dataPass == $oldPass) {
			$data = [
				'passwordk' => md5($this->input->post('new_pass'))
			];
			$update = $this->M_app->update('users', ['id' => $id], $data, $activity);
			if ($update) {
				$msg = [
				'status' => 200,
				'msg_akun' => $this->session->userdata('id_akun'),
			];;
			} else {
				$msg = [
				'status' => 400,
				'msg_akun' => $this->session->userdata('id_akun'),
			];;
			}
		} else {
			$msg = [
				'status' => 400,
				'msg_akun' => $this->session->userdata('id_akun'),
			];;
		}		
		
		$this->session->set_userdata($msg);

		redirect(base_url('profile'));
	}
}
