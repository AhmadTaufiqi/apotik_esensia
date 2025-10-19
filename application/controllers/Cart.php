<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Cart extends CI_Controller
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
			'title' => 'Keranjang Saya'
		];
		$this->M_app->templateCart($data, 'cart/index');
		// $this->load->view('cart/index');
	}

	public function checkout()
	{
		$data = [
			'title' => 'Buat Pesanan'
		];
		$this->M_app->templateCart($data, 'cart/checkout');
	}
}
