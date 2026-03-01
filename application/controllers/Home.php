<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_app');
		$this->load->model('M_cart');
		$this->load->model('M_product');
		$this->load->model('M_orders'); // needed for rating popup lookup
		$is_nologin = false;

		// if (empty($this->session->userdata('id_akun'))) {
		// 	$is_nologin = true;
		// } elseif ($this->session->userdata('role') != 2) {
		// 	$is_nologin = true;
		// }

		// if ($is_nologin) {
		// 	redirect(base_url('auth'));
		// }

		// Allowed load home withoud login because need to show products for buyers
	}

	public function index()
	{
		$user_id = $this->session->userdata('id_akun');
		$categories = $this->db->select('*')
			->from('product_category')
			->get()
			->result_object();
		$products = $this->M_product->get_all_products(false, false, 1);
		
		if (count($products) <= 5) {
			$products = $this->M_product->get_all_products(false, false, 0);
		}

		// products user can rate (from completed orders)
		$to_rate = [];
		if (!empty($user_id)) {
			$to_rate = $this->M_orders->get_completed_products_for_user($user_id);
		}

		$data = [
			'categories' => $categories,
			'total_my_cart' => $this->M_cart->get_total_user_cart($user_id),
			'products' => $products,
			'to_rate' => $to_rate,
		];
		$this->M_app->template($data, 'home');
		// $this->load->view('home');
	}
}
