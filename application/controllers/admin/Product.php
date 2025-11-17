<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Product extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_app');
		$this->load->model('M_product');

		$is_nologin = false;

		if (empty($this->session->userdata('id_akun'))) {
			$is_nologin = true;
		} elseif ($this->session->userdata('role') != 1) {
			$is_nologin = true;
		}

		if ($is_nologin) {
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
			'stock' => $product->stock,
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
			$alert = '<div class="alert alert-success" role="alert">
  Berhasil menyimpan data produk
</div>';
		} else {
			$alert = '<div class="alert alert-danger" role="alert">
  Gagal menyimpan data produk
</div>';
		}
		var_dump($alert);
		exit;
		$this->session->set_flashdata('message', $alert);

		redirect('admin/product/create');
	}

	public function update()
	{
		$id = $this->input->post('id');
		$product = $this->M_product->update_product('foto_default', 'products', 'update');

		if ($product) {
			$alert = '<div class="alert alert-success" role="alert">
	Berhasil mengubah data produk
</div>';
		} else {
			$alert = '<div class="alert alert-danger" role="alert">
	Gagal mengubah data produk
</div>';
		}

		$this->session->set_flashdata('message', $alert);

		redirect('admin/product/edit/' . $id);
	}

	public function promo()
	{
		$data = [];
		// $this->M_app->admin_template($data, 'products/index');
		// $this->load->view('products/promo');
	}
}
