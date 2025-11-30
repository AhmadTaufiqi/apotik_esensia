<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Orders extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model('M_app');
    $this->load->model('M_orders');

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
    $orders = $this->M_orders->get_all_orders();

    $data = [
			'title' => 'Pesanan',
      'data' => $orders
    ];

    $this->M_app->admin_template($data, 'order/admin_orders');
  }
  
  public function populateOrderStatus()
  {
    // Accept status via GET or POST and return HTML fragment for that status
    $status = $this->input->get_post('status');
    if (empty($status)) {
      // default to unpaid if not provided
      $status = 'unpaid';
    }

    // Use the model method to generate HTML
    $html = $this->M_app->getOrderStatusHtml($status);

    // Return as HTML
    header('Content-Type: text/html; charset=utf-8');
    echo $html;
    return;
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
