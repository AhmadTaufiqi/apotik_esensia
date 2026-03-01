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
      'active_menu' => 'admin_orders',
      'data' => $orders,
      'customers' => $customers,
      'filters' => $filters,
    ];

    $this->M_app->admin_template($data, 'order/admin_orders');
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
      'active_menu' => 'admin_orders',
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

  public function setExpired($id)
  {
    if (empty($id)) {
      show_404();
    }

    $this->db->trans_start();
    $this->db->where('id', $id);
    $this->db->update('orders', [
      'status' => 'expired',
      'updated_at' => $this->M_app->datetime()
    ]);
    $this->db->trans_complete();

    if ($this->db->trans_status()) {
      $this->M_app->log_activity(' mengubah status pesanan menjadi expired [' . $id . ']');
      $this->session->set_flashdata('success', 'Status pesanan berhasil diubah menjadi expired.');
    } else {
      $this->session->set_flashdata('error', 'Gagal mengubah status pesanan.');
    }

    redirect('admin_orders');
  }

  // update status shipping and others
  public function manage_shipping($order_id)
  {
    if (empty($order_id)) {
      show_404();
    }

    // Get order with customer information
    $order = $this->db->query(
      "
      SELECT o.*, o.id order_id, u.name as customer_name, u.email as customer_email
      FROM orders o
      INNER JOIN users u ON o.customer_id = u.id
      WHERE o.id = " . $this->db->escape($order_id)
    )->row_array();

    if (empty($order)) {
      show_404();
    }

    // Handle POST request to update status
    if ($this->input->post()) {
      $status = $this->input->post('status');

      if (!empty($status)) {
        $this->db->where('id', $order_id);
        $this->db->update('orders', ['status' => $status, 'updated_at' => $this->M_app->datetime()]);
        $update_result = $this->db->affected_rows() > 0;

        if ($update_result) {
          $this->session->set_flashdata('success', 'Status pesanan berhasil diperbarui.');
        } else {
          $this->session->set_flashdata('error', 'Gagal memperbarui status pesanan.');
        }
      }

      redirect('admin_orders/manage_shipping/' . $order_id);
    }

    $data = [
      'title' => 'Kelola Pengiriman - Order #' . $order_id,
      'active_menu' => 'admin_orders',
      'order' => $order,
    ];

    $this->M_app->admin_template($data, 'order/admin_manage_shipping');
  }
}
