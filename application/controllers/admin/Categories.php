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
			'data' => $prod
		];

		$this->M_app->admin_template($data, 'categories/admin_category');
	}

	public function detail($id)
	{
		$id = $this->input->get('id');
	}

	public function edit($id)
	{
		$category = $this->db->select('*')
			->from('product_category')
			->where(['id' => $id])
			->get()->row_object();

		$data = [
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
			'foto_product' => '',
			'submit_url' => 'categories/save',
			'categories' => $categories
		];
		$this->M_app->admin_template($data, 'categories/admin_form_category');
	}

	public function update()
	{
		$id = $this->input->post('id');
		$product = $this->M_category->update_category('foto_default', 'product_category', 'update');

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

		redirect('admin/categories/edit/' . $id);
	}

	public function save()
	{
		$product = $this->M_category->save_product(1, 'products', 'insert');

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

		redirect('admin/categories/create');
	}

	public function promo()
	{
		$data = [];
		// $this->M_app->admin_template($data, 'products/index');
		// $this->load->view('products/promo');
	}
}
