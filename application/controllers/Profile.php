<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Profile extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_app');

		$is_nologin = false;

		if (empty($this->session->userdata('id_akun'))) {
			$is_nologin = true;
		} elseif ($this->session->userdata('role') != 2) {
			$is_nologin = true;
		}

		if ($is_nologin) {
			redirect(base_url('auth'));
		}
	}

	public function index()
	{
		$data = [
			'title' => 'Profile Saya',
			'name' => $this->session->userdata('nama_akun')
		];
		$this->M_app->templateCart($data, 'profile/index');
		// $this->load->view('cart/index');
	}

	public function edit()
	{
		$user_id = $this->session->userdata('id_akun');
		$address = $this->db->get_where('address', ['user_id' => $user_id])->row_array();
		if (empty($address)) {
			$address = [
				'kota' => '',
				'kecamatan' => '',
				'kelurahan' => '',
				'kode_pos' => '',
				'long' => '',
				'lat' => '',
				'catatan' => '',
			];
		}

		// var_dump($address->kota);
		// exit;

		$data = [
			'title' => 'Edit Profile',
			'user_id' => $user_id,
			'address' => $address,
			'email' => $this->session->userdata('user_akun'),
			'name' => $this->session->userdata('nama_akun'),
			'foto_akun' => $this->session->userdata('foto_akun'),
			'hp_akun' => $this->session->userdata('hp_akun'),
		];

		$this->M_app->templateCart($data, 'profile/edit');
	}

	public function edit_address()
	{
		$user_id = $this->session->userdata('id_akun');
		$address = $this->db->get_where('address', ['user_id' => $user_id])->row_array();
		if (empty($address)) {
			$address = [
				'kota' => '',
				'kecamatan' => '',
				'kelurahan' => '',
				'kode_pos' => '',
				'long' => '',
				'lat' => '',
				'catatan' => '',
			];
		}

		// var_dump($address->kota);
		// exit;

		$data = [
			'title' => 'Edit Profile',
			'user_id' => $user_id,
			'address' => $address,
		];

		$this->M_app->templateCart($data, 'profile/edit_address');
	}

	public function save()
	{
		$input_address = $this->input->post('address');

		$data = [
			'name' => $this->input->post('name'),
			'telp' => $this->input->post('telp'),
			'foto' => $this->M_app->uploadBase64('users', 'jpg|jpeg|png', 'foto_base64', 'default.png'),
		];

		//update session userdata
		$this->session->set_userdata([
			'nama_akun' => $data['name'],
			'hp_akun' => $data['telp'],
			'foto_akun' => $data['foto']
		]);

		$this->db->update('users', $data, ['id' => $input_address['user_id']]);

		$address = $this->db->get_where('address', ['user_id' => $input_address['user_id']])->row_array();

		$data_addres = [
			'negara' => $input_address['negara'],
			'provinsi' => $input_address['provinsi'],
			'kota' => $input_address['kota'],
			'kecamatan' => $input_address['kecamatan'],
			'kelurahan' => $input_address['kelurahan'],
			'kode_pos' => $input_address['kode_pos'],
			'catatan' => $input_address['catatan'],
			'long' => $input_address['long'],
			'lat' => $input_address['lat'],
		];

		if ($address) {
			$this->db->update('address', $data_addres, ['id' => $address['id']]);
		} else {
			$data_addres['user_id'] = $input_address['user_id'];

			$this->db->insert('address', $data_addres);
		}

		redirect('Profile/edit');
	}
}
