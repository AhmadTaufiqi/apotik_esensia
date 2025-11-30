<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model('M_app');
    $this->load->model('M_user');

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
    $users = $this->M_user->get_users();

    $data = [
			'title' => 'Manajemen User',
      'data' => $users
    ];

    $this->M_app->admin_template($data, 'user_management');
  }

  public function ongkir()
  {
    $this->load->view('order/ongkir');
  }
}
