<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Cart extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_app');
		$this->load->model('M_cart');
		// if (empty($this->session->userdata('id_akun'))) {
		// 	redirect(base_url('login'));
		// }
	}

	public function index()
	{
    // $user_id = $this->session->userdata('id_akun');
    $user_id = 1;
		$cart = $this->M_cart->get_user_cart($user_id);

		$data = [
			'title' => 'Keranjang Saya',
			'product_cart' => $cart,
		];
		$this->M_app->templateCart($data, 'cart/index');
	}

	public function checkout()
	{
		$data = [
			'title' => 'Buat Pesanan'
		];
		$this->M_app->templateCart($data, 'cart/checkout');
	}
}
