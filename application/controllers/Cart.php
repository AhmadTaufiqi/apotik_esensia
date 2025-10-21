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
		// echo json_encode($_POST);
		$products = [];
		$arr_product_id = $this->input->post('product_id');
		$arr_product_cart_id = $this->input->post('product_cart_id');
		$arr_product_qty = $this->input->post('product_qty');

		foreach($arr_product_cart_id as $i => $id){
			// if($arr_product_checked[$i] == 0){
				// continue;
			// }

			$cart_product = $this->M_cart->get_cart_product($id);
			$data = [
				'product_id' => $arr_product_id[$i],
				'product_qty' => $arr_product_qty[$i]
			];
			array_push($products, $data);
			echo '<br>';
		}

		$data = [
			'title' => 'Buat Pesanan',
			'products' => $products,
			'datatest' => $this->datatest()
		];
		$this->M_app->templateCart($data, 'cart/checkout');
	}

	public function datatest(){
		return 'tes123';
	}
}
