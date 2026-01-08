<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Orders extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model('M_app');
    $this->load->model('M_orders');
    $this->load->model('M_user');

    $is_nologin = false;

    if (empty($this->session->userdata('id_akun'))) {
      $is_nologin = true;
    } elseif ($this->session->userdata('role') != 3) {
      $is_nologin = true;
    }

    if ($is_nologin) {
      redirect(base_url('admin/auth'));
    }
  }

  public function index()
  {
    // Read filter parameters
    $search = $this->input->get('search');
    $date_from = $this->input->get('date_from');
    $date_to = $this->input->get('date_to');
    $customer_id = $this->input->get('customer_id');
    $status = $this->input->get('status');

    // Build filters array
    $filters = [
      'search' => $search,
      'date_from' => $date_from,
      'date_to' => $date_to,
      'customer_id' => $customer_id,
      'status' => $status,
    ];

    // Get filtered orders (use filtered method if any filter is set, otherwise use default)
    if (!empty($search) || !empty($date_from) || !empty($date_to) || !empty($customer_id) || !empty($status)) {
      $orders = $this->M_orders->get_all_orders_filtered($filters);
    } else {
      $orders = $this->M_orders->get_kasir_orders();
    }

    // Get list of unique customers for filter dropdown
    $customers = $this->db->select('id, name')->from('users')->where(['deleted_at' => null, 'role' => 2])->order_by('name', 'ASC')->get()->result();

    $data = [
      'title' => 'Pesanan',
      'data' => $orders,
      'customers' => $customers,
      'filters' => $filters,
    ];

    $this->M_app->kasir_template($data, 'order/kasir_orders');
  }

  public function reviewPayment($order_id)
  {
    // Get order with customer information
    $order = $this->db->query(
      "
      SELECT o.*, u.name as customer_name, u.email as customer_email, u.telp as customer_phone
      FROM orders o
      INNER JOIN users u ON o.customer_id = u.id
      WHERE o.id = " . $this->db->escape($order_id)
    )->row_array();

    if (empty($order)) {
      show_404();
    }

    $invoice = $this->M_invoice->get_invoice_by_orderid($order_id);

    $address = $this->M_user->get_user_address_by_id($order['customer_id']);

    $order_products = $this->M_orders->get_order_product_by_orderid($order_id);

    $data = [
      'title' => 'Review Pembayaran Order #' . $order_id,
      'address' => $address,
      'order' => $order,
      'invoice' => $invoice,
      'order_products' => $order_products,
      'order_status' => $this->M_app->getOrderStatusHtml($order['status']),
    ];
    $this->M_app->kasir_template($data, 'order/kasir_payment_review');
  }

  // request acceptance = order status 'paid' & invoice is_paid = 1
  // payment accepted = order status 'payment accepted' & invoice is_paid = 1
  // payment rejected = order status 'payment rejected' & invoice is_paid = 2
  public function confirmPayment($order_id)
  {
    $invoice = $this->M_invoice->get_invoice_by_orderid($order_id);

    $confirm = $this->M_invoice->confirm_payment($order_id);

    if (!$confirm) {
    } else {

      if ($confirm) {
        $alert = '<div class="alert alert-success" role="alert">Berhasil menyimpan data produk</div>';
        $this->session->set_flashdata('message', $alert);
        
        redirect(base_url('kasir/Orders'));
      } else {
        $alert = '<div class="alert alert-danger" role="alert">Gagal menyimpan data produk</div>';
        $this->session->set_flashdata('message', $alert);

        redirect(base_url('kasir/Orders/reviewPayment/' . $order_id));
      }
    }
  }

  public function detail($id)
  {
    if (empty($id)) {
      show_404();
    }

    // Get order with customer information and address details
    $order = $this->db->query(
      "
      SELECT o.*, 
             u.name as customer_name, 
             u.email as customer_email, 
             u.telp as customer_phone, 
             a.negara as address_negara,
             a.provinsi as address_provinsi,
             a.kota as address_kota,
             a.kecamatan as address_kecamatan,
             a.kelurahan as address_kelurahan,
             a.kode_pos as address_kode_pos,
             a.catatan as address_catatan,
             a.long as address_long,
             a.lat as address_lat,
             a.jarak as address_jarak
      FROM orders o
      INNER JOIN users u ON o.customer_id = u.id
      LEFT JOIN address a ON u.id = a.user_id
      WHERE o.id = " . $this->db->escape($id)
    )->row_array();

    if (empty($order)) {
      show_404();
    }

    // Get order products with product details
    $order_products = $this->M_orders->get_order_product_by_orderid($id);

    $data = [
      'title' => 'Detail Order #' . $id,
      'order' => $order,
      'order_products' => $order_products,
    ];

    $this->M_app->admin_template($data, 'order/admin_view_order');
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
    $data = array_map(function ($r) {
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
}
