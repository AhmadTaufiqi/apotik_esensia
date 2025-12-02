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

  public function latestNotifications()
  {
    // return latest orders that need admin attention as JSON
    $limit = intval($this->input->get('limit') ?? 5);
    $this->load->model('M_orders');
    $list = $this->M_orders->get_recent_notifications($limit);

    // map to a friendly structure
    $data = array_map(function($r){
      $title = 'Order Baru #' . ($r['order_id'] ?? '');
      if (($r['order_status'] ?? '') === 'unpaid') {
        $subtitle = 'Status: unpaid';
      } else if (isset($r['is_paid']) && $r['is_paid']) {
        $subtitle = 'Pembayaran diterima — perlu dikirim';
      } else {
        $subtitle = 'Perlu ditindaklanjuti';
      }

      return [
        'order_id' => $r['order_id'],
        'title' => $title,
        'message' => $subtitle,
        'created_at' => $r['order_created'] ?? null,
        'link' => base_url('admin/orders'),
      ];
    }, $list);

    $count = count($data);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode(['count' => $count, 'data' => $data]);
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
