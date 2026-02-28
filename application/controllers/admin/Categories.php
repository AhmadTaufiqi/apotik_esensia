<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Categories extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_app');
		$this->load->model('M_category');

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
		$prod = $this->db->query("SELECT * FROM product_category ORDER BY created_at DESC")->result();
		$data = [
			'title' => 'Kategori Produk',
			'active_menu' => 'admin_cat',
			'data' => $prod
		];

		$this->M_app->admin_template($data, 'categories/admin_category');
	}

	public function detail($id)
	{
		// accept id from URL segment or GET as fallback
		if (empty($id)) {
			$id = $this->input->get('id');
		}

		if (empty($id)) {
			show_404();
		}

		$category = $this->db->select('*')
			->from('product_category')
			->where(['id' => $id])
			->get()->row();

		if (empty($category)) {
			show_404();
		}

		$data = [
			'title' => 'Detail Kategori',
			'active_menu' => 'admin_cat',
			'category' => $category,
		];

		$this->M_app->admin_template($data, 'categories/admin_view_category');
	}

	public function edit($id)
	{
		$category = $this->db->select('*')
			->from('product_category')
			->where(['id' => $id])
			->get()->row_object();

		$data = [
			'title' => 'Edit Kategori',
			'active_menu' => 'admin_cat',
			'submit_url' => 'categories/update',
			'id' => $category->id,
			'category' => $category->category,
			'icon' => $category->icon,
		];
		$this->M_app->admin_template($data, 'categories/admin_form_category');
	}

	public function create()
	{
		$categories = $this->db->query('SELECT * FROM product_category')->result();

		$data = [
			'title' => 'Tambah Kategori',
			'active_menu' => 'admin_cat',
			'foto_product' => '',
			'submit_url' => 'categories/save',
			'categories' => $categories,
			'icon' => '',
		];
		$this->M_app->admin_template($data, 'categories/admin_form_category');
	}

	public function update()
	{
		$id = $this->input->post('id');
		$product = $this->M_category->update_category('default_image.png', 'product_category', 'update');

		if ($product) {
			$alert = '<div class="alert alert-success" role="alert">
	Berhasil mengubah data kategori produk
</div>';
		} else {
			$alert = '<div class="alert alert-danger" role="alert">
	Gagal mengubah data kategori produk
</div>';
		}

		$this->session->set_flashdata('message', $alert);

		redirect('admin/categories/edit/' . $id);
	}

	public function save()
	{
		$product = $this->M_category->add_category('default_image.png', 'product_category', 'insert');

		if ($product) {
			$alert = '<div class="alert alert-success" role="alert">
	Berhasil menambah data kategori produk
</div>';
		} else {
			$alert = '<div class="alert alert-danger" role="alert">
	Gagal menambah data kategori produk
</div>';
		}
		$this->session->set_flashdata('message', $alert);

		redirect('admin/categories');
	}

	public function delete()
	{
		$id = $this->input->post('id');
		// $this->db->where(['id' => $id]);
		// $delete = $this->db->delete($id, 'product_category', 'delete');
		$delete = $this->M_category->delete($id, 'product_category', 'delete');
		if ($delete) {
			$alert = '<div class="alert alert-success" role="alert">
	Berhasil menghapus data produk
</div>';
		} else {
			$alert = '<div class="alert alert-danger" role="alert">
	Gagal menghapus data produk
</div>';
		}

		$this->session->set_flashdata('message', $alert);
		redirect('admin/categories');
	}

	public function promo()
	{
		$data = [];
		// $this->M_app->admin_template($data, 'products/index');
		// $this->load->view('products/promo');
	}
}
