<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Categories extends CI_Controller
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
		// fetch categories
		$categories = [];
		if ($this->db->table_exists('product_category')) {
			$categories = $this->db->select('id, category, icon')->from('product_category')->order_by('category', 'ASC')->get()->result();
		}

		$data = [
			'title' => 'Kategori',
			'categories' => $categories,
			'total_my_cart' => $this->M_cart->get_total_user_cart($this->session->userdata('id_akun')),
		];

		$this->M_app->template($data, 'categories/index');
	}
}
