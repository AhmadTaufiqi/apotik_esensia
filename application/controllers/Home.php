<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends CI_Controller
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
		$categories = $this->db->select('*')
			->from('product_category')
			->get()
			->result_object();

		$data = [
			'categories' => $categories
		];
		$this->M_app->template($data, 'home');
		// $this->load->view('home');
	}
}
