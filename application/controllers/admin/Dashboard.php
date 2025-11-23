<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_app');
		$this->load->model('M_product');
		$this->load->model('M_category');
		$this->load->model('M_orders');
		$this->load->model('M_cart');

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
		$user_id = $this->session->userdata('id_akun');

		$total_product = $this->M_product->get_total_product();
		$latest_orders = $this->M_orders->get_total_orders(true);
		$total_income = $this->M_orders->get_total_income(true);
		$total_oncart = $this->M_cart->get_total_prod_oncart(false);

		$total_category = $this->M_category->get_total_categories();

		$user = $this->db
			->select('*')
			->from('users')
			->where(['id' => $user_id])
			->get()
			->row_array();
			
		$data = [
			'title' => 'Dashboard',
			'total_product' => $total_product,
			'total_category' => $total_category,
			'total_orders' => count($latest_orders),
			'total_income' => $total_income,
			'orders_today' => $latest_orders,
			'total_oncart' => $total_oncart,
		];

		$this->M_app->admin_template($data, 'dashboard');
	}

	public function save()
	{
		$id = $this->session->userdata('id_akun');
		$foto = $this->input->post('foto');
		$activity = 'users [' . $id . ']';

		$data = [
			'name' => $this->input->post('name'),
			'telp' => $this->input->post('telp'),
			// 'foto' => $this->M_app->updateFile('users', $foto, 'jpg|jpeg|png', 'file', 'default.png')
			'foto' => $this->M_app->uploadBase64('users', 'jpg|jpeg|png', 'foto_base64', 'default.png'),
		];

		$update = $this->M_app->update('users', ['id' => $id], $data, $activity);
		if ($update) {
			$msg = [
				'status' => 200,
				'msg_akun' => $this->session->userdata('id_akun'),
			];

			$foto = [
				'foto_akun' => $data['foto']
			];
			$this->session->set_userdata($foto);
		} else {
			$msg = [
				'status' => 400,
				'msg_akun' => $this->session->userdata('id_akun'),
			];
		}
		$this->session->set_userdata($msg);

		$data = $this->session->userdata();
		// print_r($data);
		redirect(base_url('admin/profile'));
	}

	public function save_pass()
	{
		$id = $this->session->userdata('id_akun');
		$activity = 'users [' . $id . ']';

		$q = $this->M_app->select_where('users.password', 'users', ['id' => $id])->row_array();
		$dataPass = $q['password'];
		$oldPass = md5($this->input->post('old_pass'));

		if ($dataPass == $oldPass) {
			$data = [
				'passwordk' => md5($this->input->post('new_pass'))
			];
			$update = $this->M_app->update('users', ['id' => $id], $data, $activity);
			if ($update) {
				$msg = [
					'status' => 200,
					'msg_akun' => $this->session->userdata('id_akun'),
				];;
			} else {
				$msg = [
					'status' => 400,
					'msg_akun' => $this->session->userdata('id_akun'),
				];;
			}
		} else {
			$msg = [
				'status' => 400,
				'msg_akun' => $this->session->userdata('id_akun'),
			];;
		}

		$this->session->set_userdata($msg);

		redirect(base_url('profile'));
	}
}
