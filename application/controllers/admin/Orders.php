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
      $orders = $this->M_orders->get_all_orders();
    }

    // Get list of unique customers for filter dropdown
    $customers = $this->db->select('id, name')->from('users')->where(['deleted_at' => null, 'role' => 2])->order_by('name', 'ASC')->get()->result();

    $data = [
      'title' => 'Pesanan',
      'data' => $orders,
      'customers' => $customers,
      'filters' => $filters,
    ];

    $this->M_app->admin_template($data, 'order/admin_orders');
  }

  public function detail($id)
  {
    // accept id from URL segment or GET as fallback
    if (empty($id)) {
      $id = $this->input->get('id');
    }

    if (empty($id)) {
      show_404();
    }

    $select_category = 'SELECT pc.category FROM product_category pc WHERE pc.id = p.category';
    $order = $this->db->query("SELECT * FROM orders WHERE id = " . $this->db->escape($id))->row();

    $join = "INNER JOIN order_products ON order_products.product_id=products.id";
    $order_product = $this->db->query("SELECT * FROM order_products $join WHERE order_id = $this->db->escape($id)")->result_array;
    var_dump($order_product);

    if (empty($order)) {
      show_404();
    }

    // load categories for sidebar/display if needed
    $categories = $this->db->query('SELECT * FROM product_category')->result();

    $data = [
      'title' => 'Detail Order',
      'product' => $order,
      'categories' => $categories,
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
