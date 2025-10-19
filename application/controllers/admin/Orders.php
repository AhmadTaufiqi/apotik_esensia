<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Orders extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model('M_app');
    $this->load->model('M_orders');
    if (empty($this->session->userdata('id_akun'))) {
      redirect(base_url('admin/auth'));
    }
  }

  public function index()
  {
    $orders = $this->M_orders->get_order();

    $data = [
      'data' => $orders
    ];

    $this->M_app->admin_template($data, 'order/admin_orders');
  }

  public function payment()
  {
    $this->load->view('order/index');
  }

  public function shipping()
  {
    $this->load->view('order/index');
  }

  public function ongkir()
  {
    $this->load->view('order/ongkir');
  }
}
