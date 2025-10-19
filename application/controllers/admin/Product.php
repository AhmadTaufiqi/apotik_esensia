<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Product extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_app');
		$this->load->model('M_product');
		if (empty($this->session->userdata('id_akun'))) {
			redirect(base_url('admin/auth'));
		}
	}

	public function index()
	{
		// $this->load->view('index');
		$select_category = 'SELECT pc.category FROM product_category pc WHERE pc.id = p.category';
		$prod = $this->db->query("SELECT p.*,($select_category) t_category FROM products p ORDER BY p.created_at DESC")->result();
		$data = [
			'data' => $prod
		];

		$this->M_app->admin_template($data, 'products/admin_product');
	}

	public function detail($id)
	{
		$id = $this->input->get('id');
	}

	public function create()
	{
		$categories = $this->db->query('SELECT * FROM product_category')->result();

		$data = [
			'foto_product' => '',
			'submit_url' => 'product/save',
			'categories' => $categories
		];
		$this->M_app->admin_template($data, 'products/admin_form_product');
	}

	public function edit($id)
	{
		$categories = $this->db->query('SELECT * FROM product_category')->result();

		$product = $this->db->select('*')
			->from('products')
			->where(['id' => $id])
			->get()->row_object();

		$data = [
			'categories' => $categories,
			'submit_url' => 'product/update',
			'id' => $product->id,
			'sku' => $product->sku,
			'image' => $product->image,
			'name' => $product->name,
			'price' => $product->price,
			'discount' => $product->discount,
			'description' => $product->description,
			'category' => $product->category,
		];
		$this->M_app->admin_template($data, 'products/admin_form_product');	
	}

	public function save()
	{
		$product = $this->M_product->save_product(1, 'products', 'insert');

		if ($product) {
			$data = [
				'status' => 200,
				'msg_akun' => $this->session->userdata('id_akun'),
			];
		} else {
			$data = [
				'status' => 400,
				'msg_akun' => $this->session->userdata('id_akun'),
			];
		}
		$this->session->set_userdata($data);

		redirect('admin/product/create');
	}

	public function update()
	{
		$id = $this->input->post('id');
		$product = $this->M_product->update_product('foto_default', 'products', 'update');

		if ($product) {
			$data = [
				'status' => 200,
				'msg_akun' => $this->session->userdata('id_akun'),
			];
		} else {
			$data = [
				'status' => 400,
				'msg_akun' => $this->session->userdata('id_akun'),
			];
		}
		$this->session->set_userdata($data);

		redirect('admin/product/edit/'.$id);
	}

	public function promo()
	{
		$data = [];
		// $this->M_app->admin_template($data, 'products/index');
		// $this->load->view('products/promo');
	}
}
