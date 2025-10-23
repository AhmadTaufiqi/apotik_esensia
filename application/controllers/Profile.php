<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Profile extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_app');
		// if (empty($this->session->userdata('id_akun'))) {
		// 	redirect(base_url('login'));
		// }
	}

	public function index()
	{
		$data = [
			'title' => 'Profile Saya'
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
			'name' => $this->session->userdata('nama_akun'),
			'foto_akun' => $this->session->userdata('foto_akun'),
			'hp_akun' => $this->session->userdata('hp_akun'),
		];

		$this->M_app->templateCart($data, 'profile/edit');
	}
}
