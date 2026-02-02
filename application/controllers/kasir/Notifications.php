<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Notifications extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model('M_app');
    $this->load->model('M_orders');

    $is_nologin = false;

    if (empty($this->session->userdata('id_akun'))) {
      $is_nologin = true;
    } elseif ($this->session->userdata('role') == 2) {
      $is_nologin = true;
    }

    if ($is_nologin) {
      redirect(base_url('admin/auth'));
    }
  }

  public function index()
  {
    $data = [];
    $this->M_app->admin_template($data, 'notification/inex');
  }

  public function detail($id)
  {
    $data = [];
    $this->M_app->admin_template($data, 'notification/detail');
  }

  public function latestNotifications()
  {
    $user_role = $this->session->userdata('role');
    // return latest orders that need admin attention as JSON
    $limit = intval($this->input->get('limit') ?? 5);
    $this->load->model('M_orders');
    $list = $this->M_orders->get_recent_notifications($limit, $user_role);

    // map to a friendly structure
    $data = array_map(function ($r) {
      $title = 'Order Baru #' . ($r['order_id'] ?? '');
      if (($r['order_status'] ?? '') === 'unpaid') {
        $subtitle = 'Status: unpaid';
      } else if (isset($r['is_paid']) && $r['is_paid']) {
        $subtitle = 'Pembayaran diterima — perlu diperiksa';
      } else if ($r['order_status'] == 'paid' && isset($r['is_paid']) && $r['is_paid']) {
        $subtitle = 'Pesanan Perlu Dikirim';
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


}
