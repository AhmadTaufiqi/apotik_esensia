<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Products extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_app');

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
		$data = [];
		$this->M_app->template($data, 'products/admin_product');
	}

	public function form()
	{
		$data = [];
		$this->M_app->template($data, 'products/admin_form_product');
		// $this->load->view('products/promo');
	}
}
