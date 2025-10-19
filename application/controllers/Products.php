<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Products extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_app');
		// if (empty($this->session->userdata('id_akun'))) {
		// 	redirect(base_url('login'));
		// }
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
