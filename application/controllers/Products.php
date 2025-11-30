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
		} elseif ($this->session->userdata('role') != 2) {
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
		// Read filters from GET
		$filter_category = $this->input->get('category');
		$sort = $this->input->get('sort');

		// fetch all products
		$products = $this->M_product->get_all_products(null, null, false);

		// fetch categories for filter list (if table exists)
		$categories = [];
		if ($this->db->table_exists('categories')) {
			$categories = $this->db->select('id, category')->from('categories')->order_by('category', 'ASC')->get()->result();
		}

		// apply category filter (accept id or category name)
		if (!empty($filter_category)) {
			$filtered = [];
			foreach ($products as $p) {
				$cat_field = isset($p->category) ? $p->category : '';

				// if product stores comma separated categories, normalize to array
				$prodCats = array_map('trim', explode(',', $cat_field));

				if (is_numeric($filter_category)) {
					// match by id or exact value
					if (in_array((string)$filter_category, $prodCats, true) || in_array((int)$filter_category, $prodCats, true)) {
						$filtered[] = $p;
					}
				} else {
					// match by name (case-insensitive)
					foreach ($prodCats as $pc) {
						if (strcasecmp($pc, $filter_category) === 0) {
							$filtered[] = $p;
							break;
						}
					}
				}
			}
			$products = $filtered;
		}

		// apply simple sorting
		if (!empty($sort) && is_array($products)) {
			switch ($sort) {
				case 'price_asc':
					usort($products, function($a, $b){ return ($a->price ?? 0) - ($b->price ?? 0); });
					break;
				case 'price_desc':
					usort($products, function($a, $b){ return ($b->price ?? 0) - ($a->price ?? 0); });
					break;
				case 'name_asc':
					usort($products, function($a, $b){ return strcasecmp($a->name ?? '', $b->name ?? ''); });
					break;
				case 'name_desc':
					usort($products, function($a, $b){ return strcasecmp($b->name ?? '', $a->name ?? ''); });
					break;
			}
		}

		$data = [
			'title' => 'Produk',
			'products' => $products,
			'categories' => $categories,
			'total_my_cart' => $this->M_cart->get_total_user_cart($this->session->userdata('id_akun')),
		];

		$this->M_app->template($data, 'products/index');
	}
}
