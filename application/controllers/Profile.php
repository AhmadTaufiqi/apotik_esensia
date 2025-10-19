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
		$data = [];
		$this->M_app->templateCart($data, 'profile/edit');
	}
}
