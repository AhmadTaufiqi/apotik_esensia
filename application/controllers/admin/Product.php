<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\IOFactory;
use PHPUnit\Framework\MockObject\DuplicateMethodException;
use Symfony\Component\DomCrawler\Crawler;

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
			// 'category' => explode(',', $product->categories == '' ? '' : $product->categories),
			'category' => $product->category,
			'multiple_cat' => explode(',', $product->categories == '' ? '' : $product->categories)
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

	public function importHtml()
	{
		$file_uri = base_url() . 'html_data_products2/Sheet1.html';

		$html = file_get_contents('html_data_products2/Sheet1.html'); // Or use Guzzle for URLs
		$crawler = new Crawler($html); // Or $crawler->addHtmlContent($html);

		// Ensure upload directory exists
		$upload_dir = FCPATH . 'dist/img/uploads/products/';
		if (!is_dir($upload_dir)) {
			mkdir($upload_dir, 0755, true);
		}

		// $tes = $crawler->filter('table'); // Selects <h1 class="title"> elements;

		$rows = $crawler->filter('table tbody tr');
		$rows->each(function (Crawler $row, $i) use ($upload_dir) {
			if ($i == 0) return; // Skip header row
			$cells = $row->filter('td');
			if ($cells->count() < 8) return; // Ensure enough columns

			$name = trim($cells->eq(0)->text());
			$sku_raw = trim($cells->eq(1)->text());
			$price_raw = trim($cells->eq(2)->text());
			
			$price_generated = floatval(str_replace(',','',$price_raw));
			$price = is_numeric($price_generated) ? $price_generated : '0';
			$discount = trim($cells->eq(3)->text());
			$imageCell = $cells->eq(4);
			$image_src = '';
			if ($imageCell->filter('img')->count() > 0) {
				$image_src = $imageCell->filter('img')->attr('src');
			}
			$description = trim($cells->eq(5)->text());
			$category_name = trim($cells->eq(6)->text());
			$stock = trim($cells->eq(7)->text());

			if (!empty($name)) {

				// Handle category
				$existing_cat = $this->db->get_where('product_category', ['category' => $category_name])->row();
				if ($existing_cat) {
					$category_id = $existing_cat->id;
				} else {
					$data_cat = [
						'category' => $category_name,
						'created_at' => $this->M_app->datetime()
					];
					$this->db->insert('product_category', $data_cat);
					$category_id = $this->db->insert_id();
				}

				// Generate SKU if empty
				// $sku = empty($sku) ? $this->M_app->generateSkuByNameAndCat($name, $category_id, $i) : $sku;

				$sku = $sku_raw;

				$product_code = $this->M_app->generateSkuByNameAndCat($name, $category_id, $i);
				if (empty($sku_raw) || !is_numeric($sku_raw)) {
					$sku = $product_code;
				}

				// Handle image upload
				$image = 'default_image.png';
				if (!empty($image_src)) {
					$src_path = FCPATH . 'html_data_products2/' . $image_src;

					$dest_path = $upload_dir . $sku . '.jpg';
					if (file_exists($src_path)) {
						copy($src_path, $dest_path);
						$image = $sku . '.jpg';
					}
				}

				// Check if product exists by name
				$existing_product = $this->db->get_where('products', ['name' => $name])->row();
				if ($existing_product) {
					// Update
					$update_data = [
						'sku' => $sku,
						'product_code' => $product_code,
						'price' => $price,
						'discount' => $discount,
						'image' => $image,
						'description' => $description ?: '-',
						'category' => $category_id,
						'stock' => $stock,
						'updated_at' => $this->M_app->datetime()
					];

					$this->db->where('id', $existing_product->id);
					$this->db->update('products', $update_data);
				} else {
					// Insert
					$insert_data = [
						'name' => $name,
						'sku' => $sku,
						'product_code' => $product_code,
						'price' => $price,
						'discount' => $discount,
						'image' => $image,
						'description' => $description ?: '-',
						'category' => $category_id,
						'stock' => $stock,
						'created_at' => $this->M_app->datetime()
					];

					$this->db->insert('products', $insert_data);
				}
			}
		});

		echo json_encode(['status' => 'done']);
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

			// Iterate over rows (skip the first row if it's a header)
			foreach ($rows as $key => $row) {
				if ($key <= 0) {
					continue; // Skip header row
				}

				// Get category ids for this row

				// Insert unique categories and get ids
				$category_id = 0;

				$existing = $this->db->get_where('product_category', ['category' => $row[6]])->row();
				if ($existing) {
					$category_id = $existing->id;
				} else {
					$data_cat = [
						'category' => $row[6],
						'created_at' => $this->M_app->datetime()
					];

					$this->db->insert('product_category', $data_cat);
					$category_id = $this->db->insert_id();
				}

				if ($row[0] == '') {
					continue; // Skip if name is empty
				}

				$_POST['name'] = $row[0];
				$_POST['sku'] = $this->M_app->generateSkuByNameAndCat($row[0], $category_id, $key);
				$_POST['price'] = floatval(str_replace('.', '', $row[2]));
				$_POST['discount'] = ($row[3] ?? 0);
				$_POST['image'] = ($row[4] ?? 'default_image.png');
				$_POST['description'] = ($row[5] ?? '-');
				$_POST['category'] = $category_id;
				$_POST['stock'] = $row[7];

				$this->M_product->save_product('admin', 'products', 'import');
			}

			echo json_encode(['status' => 'done']);
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
