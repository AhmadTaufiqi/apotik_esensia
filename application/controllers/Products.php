<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Products extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_app');
		$this->load->model('M_product');
		$this->load->model('M_category');
		$this->load->model('M_cart');

		$is_nologin = false;

		if (empty($this->session->userdata('id_akun'))) {
			$is_nologin = true;
		} elseif ($this->session->userdata('role') != 2) {
			// it's optional. could be open for non registered user
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
		} else {
			$product = $product[0];
		}

		$category = $this->M_category->get_category_by_id($product->category);

		$data = [
			'title' => 'Detail Produk',
			'total_my_cart' => $this->M_cart->get_total_user_cart($user_id),
			'product' => $product, // get first result
			'category' => $category
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
		// Read filter parameters from GET
		$filter_category = $this->input->get('category');
		$sort = $this->input->get('sort');
		$search = $this->input->get('search');

		// fetch products using a query builder in the model (applies search/category/sort)
		$products = $this->M_product->get_products($filter_category, $search, $sort, false);

		// fetch product_category for filter list (if table exists)
		$categories = [];
		if ($this->db->table_exists('product_category')) {
			$categories = $this->db->select('id, category')->from('product_category')->order_by('category', 'ASC')->get()->result();
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
