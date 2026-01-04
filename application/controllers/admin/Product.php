<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\IOFactory;
use PHPUnit\Framework\MockObject\DuplicateMethodException;

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
		// filters: search (name/sku), category, date_from/date_to (created_at)
		$select_category = 'SELECT pc.category FROM product_category pc WHERE pc.id = p.category';

		$search = $this->input->get('search');
		$category = $this->input->get('category');
		$date_from = $this->input->get('date_from');
		$date_to = $this->input->get('date_to');

		$where = " WHERE p.deleted_at IS NULL ";

		if (!empty($search)) {
			$s = $this->db->escape_like_str($search);
			$where .= " AND (p.name LIKE '%" . $s . "%' OR p.sku LIKE '%" . $s . "%') ";
		}

		if (!empty($category)) {
			$where .= " AND p.category = " . $this->db->escape($category) . " ";
		}

		if (!empty($date_from) && !empty($date_to)) {
			$where .= " AND p.created_at >= " . $this->db->escape($date_from) . " AND p.created_at <= " . $this->db->escape($date_to . ' 23:59:59') . " ";
		}

		$sql = "SELECT p.*,($select_category) t_category FROM products p " . $where . " ORDER BY p.created_at DESC";
		$prod = $this->db->query($sql)->result();

		$categories = $this->db->query('SELECT * FROM product_category')->result();

		$data = [
			'title' => 'Produk',
			'data' => $prod,
			'categories' => $categories,
			'filters' => [
				'search' => $search,
				'category' => $category,
				'date_from' => $date_from,
				'date_to' => $date_to,
			]
		];

		$this->M_app->admin_template($data, 'products/admin_product');
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

		$select_category = 'SELECT pc.category FROM product_category pc WHERE pc.id = p.category';
		$product = $this->db->query("SELECT p.*,($select_category) t_category FROM products p WHERE p.id = " . $this->db->escape($id))->row();

		if (empty($product)) {
			show_404();
		}

		// load categories for sidebar/display if needed
		$categories = $this->db->query('SELECT * FROM product_category')->result();

		$data = [
			'title' => 'Detail Produk',
			'product' => $product,
			'categories' => $categories,
		];

		$this->M_app->admin_template($data, 'products/admin_view_product');
	}

	public function create()
	{
		$categories = $this->db->query('SELECT * FROM product_category')->result();

		$data = [
			'title' => 'Tambah Produk',
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
			'title' => 'Edit Produk',
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
			'category' => explode(',', $product->categories == '' ? '' : $product->categories),
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

		$this->session->set_flashdata('message', $alert);

		redirect('admin/product/create');
	}

	public function update()
	{
		$id = $this->input->post('id');
		$product = $this->M_product->update_product('default_image.png', 'products', 'update');

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

	public function delete()
	{
		$id = $this->input->post('id');
		$this->db->where(['id' => $id]);
		$delete = $this->db->delete('products');
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

		redirect('admin/product');
	}

	public function importExcel()
	{
		$data = [];

		$action = $this->input->post('action');

		// if (isset($_FILES["import_excel_file"]["name"])) {
		if ($_FILES["import_excel_file"]["name"] != '') {

			$_SESSION['progress'] = 0;

			$path = $_FILES["import_excel_file"]["tmp_name"];
			$spreadsheet = IOFactory::load($path);
			$worksheet = $spreadsheet->getActiveSheet();
			$rows = $worksheet->toArray();

			$data_to_insert = [];

			// Iterate over rows (skip the first row if it's a header)
			foreach ($rows as $key => $row) {
				if ($key <= 1) {
					continue; // Skip header row
				}

				// Assuming your Excel columns map to: Column A=Name, Column B=Email
				$data_to_insert[] = [
					'name' => $row[0],
					'sku' => $row[1],
					'price' => $row[2],
					'discount' => $row[3],
					'image' => $row[4],
					'description' => $row[5],
					'category' => $row[6],
					'stock' => $row[7],
					// 'tipe' => $row[8],
					// 'categories' => $row[9],
					// Add more fields as needed
				];

				$_POST['name'] = $row[0];
				$_POST['sku'] = $row[1];
				$_POST['price'] = $row[2];
				$_POST['discount'] = $row[3];
				$_POST['description'] = $row[5];
				$_POST['category'] = explode(',',$row[6]);
				$_POST['stock'] = $row[7];

				$this->M_product->save_product('admin', 'products', 'import');
			}

			echo json_encode(['status' => 'done']);
			// Optional: Insert data into your MySQL database using CodeIgniter's query builder
			// $this->db->insert_batch('your_table_name', $data_to_insert);

			// echo "<pre>";
			// print_r($data_to_insert); // Display imported data
			// echo "</pre>";
			// echo "Import successful!";
		} else {
			echo "Error: No file selected.";
		}
	}
	public function promo()
	{
		$data = [];
		// $this->M_app->admin_template($data, 'products/index');
		// $this->load->view('products/promo');
	}
}
