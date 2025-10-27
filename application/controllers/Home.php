<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends CI_Controller
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
		$user_id = $this->session->userdata('id_akun');
		$categories = $this->db->select('*')
			->from('product_category')
			->get()
			->result_object();

		$data = [
			'categories' => $categories,
			'total_my_cart' => $this->M_cart->get_total_user_cart($user_id)
		];
		$this->M_app->template($data, 'home');
		// $this->load->view('home');
	}
}
