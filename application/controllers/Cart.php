<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Cart extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_app');
		$this->load->model('M_cart');

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
		// $user_id = $this->session->userdata('id_akun');
		$user_id = 1;
		$cart = $this->M_cart->get_user_cart($user_id, 1);

		$data = [
			'title' => 'Keranjang Saya',
			'product_cart' => $cart,
		];
		$this->M_app->templateCart($data, 'cart/index');
	}

	public function addToCart()
	{
		// belum btul karena ditambah status
		$user_id = $this->session->userdata('id_akun');
		$product_id = $this->input->post('product_id');
		$cart = $this->M_cart->get_user_cart_by_prod_id($product_id, $user_id, 1);


		if (!$cart) {
			$this->M_cart->save_to_cart('1', 'cart_products', $user_id);
		} else {
			$cart_prod_id = $cart['id'];

			$this->M_cart->add_cart_prod_qty($cart_prod_id);
		}

		$data = [
			'success' => true,
			'message' => '',
			'product_id' => $product_id
		];

		echo json_encode($data);
	}

	public function checkout()
	{
		// echo json_encode($_POST);
		$products = [];
		$arr_product_id = $this->input->post('product_id');
		$arr_product_cart_id = $this->input->post('product_cart_id');
		$arr_product_qty = $this->input->post('product_qty');
		$arr_product_cb = $this->input->post('product_cb');

		if (!$arr_product_cb) {
			$arr_product_cb = [];
		}

		foreach ($arr_product_cart_id as $i => $id) {

			if (!key_exists($i, $arr_product_cb)) {
				continue;
			} elseif ($arr_product_cb[$i] == 0) {
				continue;
			}

			$cart_product = $this->M_cart->get_cart_product($id);
			$dataset = [
				'product_qty' => $arr_product_qty[$i],
				'product_cart_id' => $arr_product_cart_id[$i],
				'prod_dataset' => $this->getDataProduct($arr_product_id[$i]),
				'total_price' => ($cart_product['price'] - ($cart_product['price'] * ($cart_product['discount'] / 100))) * $cart_product['qty'],
				'raw_total_price' => $cart_product['price'] * $cart_product['qty']
			];

			array_push($products, $dataset);
		}

		$data = [
			'title' => 'Buat Pesanan',
			'cart_products' => $products,
		];

		$this->M_app->templateCart($data, 'cart/checkout');
	}

	public function deleteProductCart()
	{
		$cart_id = $this->input->post('cart_product_id');

		$delete = $this->M_cart->delete_cart_product($cart_id);

		if ($delete) {
		}
		var_dump($cart_id);
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
