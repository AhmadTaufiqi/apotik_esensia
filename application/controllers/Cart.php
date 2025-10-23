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

		foreach ($arr_product_cart_id as $i => $id) {
			// if($arr_product_checked[$i] == 0){
			// continue;
			// }

			$cart_product = $this->M_cart->get_cart_product($id);
			$dataset = [
				'product_qty' => $arr_product_qty[$i],
				'prod_dataset' => $this->getDataProduct($arr_product_id[$i]),
			];

			array_push($products, $dataset);
		}

		$data = [
			'title' => 'Buat Pesanan',
			'cart_products' => $products,
		];
		$this->M_app->templateCart($data, 'cart/checkout');
	}

	public function getDataProduct($product_id)
	{
		$product = $this->db->get_where('products', ['id' => $product_id])->row_array();

		return $product;
	}

	public function updateProdQty()
	{
		$qty = $this->input->post('qty');
		$cart_id = $this->input->post('cart_id');

		$update = $this->M_cart->update_cart_qty($cart_id, $qty);

		if ($update) {
			echo 'success';
		} else {
			echo 'failed';
		}
	}
}
