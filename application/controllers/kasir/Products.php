<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Products extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_app');
		$this->load->model('M_product');
		$this->load->model('M_cart');

		$is_nologin = false;

		if (empty($this->session->userdata('id_akun'))) {
			$is_nologin = true;
		} elseif ($this->session->userdata('role') != 3) {
			$is_nologin = true;
		}

		if ($is_nologin) {
			redirect(base_url('auth'));
		}
	}

	public function detail($id = null)
	{		
		if (empty($id)) {
			redirect(base_url('home'));
		}
		$user_id = $this->session->userdata('id_akun');

		// Fetch product by ID
		$product = $this->M_product->get_all_products($id, false, false);
		
		if (empty($product)) {
			show_404();
		}

		$data = [
			'title' => 'Detail Produk',
			'total_my_cart' => $this->M_cart->get_total_user_cart($user_id),
			'product' => $product[0] // get first result
		];

		$this->M_app->template($data, 'products/detail');
	}

	public function form()
	{
		$data = [];
		$this->M_app->template($data, 'products/admin_form_product');
		// $this->load->view('products/promo');
	}

	public function index()
	{
		// Read filter params from GET
		$filter_category = $this->input->get('category');
		$sort = $this->input->get('sort');
		$search = $this->input->get('search');

		// use new query-based helper to fetch products
		$products = $this->M_product->get_products($filter_category, $search, $sort, false);

		// fetch categories for filter list (if table exists)
		$categories = [];
		if ($this->db->table_exists('categories')) {
			$categories = $this->db->select('id, category')->from('categories')->order_by('category', 'ASC')->get()->result();
		}

		$data = [
			'title' => 'Produk',
			'products' => $products,
			'categories' => $categories,
			'total_my_cart' => $this->M_cart->get_total_user_cart($this->session->userdata('id_akun')),
			'search' => $search,
		];

		$this->M_app->template($data, 'products/index');
	}
}
