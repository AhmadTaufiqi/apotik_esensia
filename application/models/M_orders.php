<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_orders extends CI_Model
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model('M_app');
  }

  public function getId($table)
  {
    $q = $this->db->query("SELECT MAX(id) AS kd_max FROM $table")->row_array();
    $tmp = ((int) $q['kd_max']) + 1;
    return sprintf("%04s", $tmp);
  }

  public function get_total_orders($is_today)
  {
    $today = date('Y-m-d');
    $query = 'SELECT * FROM orders';
    $query .= ' WHERE 1 = 1';

    if ($is_today) {
      $query .= " AND created_at LIKE '$today%'";
    }

    $total = $this->db->query($query)->result_array();
    if ($total) {
      return $total;
    }

    return [];
  }

  public function get_total_income($is_today)
  {
    $today = date('Y-m-d');
    $query = 'SELECT sum(cost_price) total_income FROM orders';
    $query .= " WHERE status = 'shipped'";

    if ($is_today) {
      $query .= " AND created_at LIKE '$today%'";
    }

    $total = $this->db->query($query)->row_array();

    if ($total['total_income']) {
      return $total['total_income'];
    }

    return 0;
  }

  public function get_order_product($user_id)
  {
    $this->db->trans_start();

    $order = $this->db->select('*')
      ->from('orders o')
      ->join('order_products op', 'o.id = op.order_id', 'left')
      ->join('products p', 'op.product_id = p.id', 'left')
      ->where(['o.customer_id' => $user_id])
      ->order_by('o.id', 'DESC')
      ->get()->result_object();
    $this->db->trans_complete();

    return $order;
  }

  public function get_order_by_userid($user_id)
  {
    $this->db->trans_start();

    $order = $this->db->select('*')
      ->from('orders o')
      ->join('order_products op', 'o.id = op.order_id', 'left')
      ->join('products p', 'op.product_id = p.id', 'left')
      ->where(['o.customer_id' => $user_id])
      ->get()->result_object();
    $this->db->trans_complete();

    return $order;
  }

  public function get_order_product_by_orderid($order_id)
  {
    $this->db->trans_start();

    $order = $this->db->select('*')
      ->from('order_products op')
      ->join('products p', 'op.product_id = p.id', 'left')
      ->where(['op.order_id' => $order_id])
      ->get()->result_array();
    $this->db->trans_complete();

    return $order;
  }

  public function get_order($user_id = null)
  {
    $this->db->trans_start();
    $order = $this->db->select('*')
      ->from('orders o')
      ->where('o.customer_id', $user_id)
      ->get()
      ->result_array();
    $this->db->trans_complete();

    return $order;
  }

  public function get_order_by_id($order_id = null)
  {
    $this->db->trans_start();
    $order = $this->db->select('*')
      ->from('orders o')
      ->where('o.id', $order_id)
      ->get()
      ->row_array();
    $this->db->trans_complete();

    return $order;
  }

  public function get_all_orders()
  {
    $this->db->trans_start();
    $query = 'SELECT * FROM orders o';
    $query .= ' INNER JOIN users u ON u.id=o.customer_id';
    $query .= ' WHERE 1 = 1';
    $order = $this->db->query($query)->result_array();
    $this->db->trans_complete();

    return $order;
  }

  public function get_weekly_orders($where)
  {
    $start_date = date('Y-m-d', strtotime('-6 days'));
    $end_date = date('Y-m-d');

    // Sesuaikan nama tabel/kolom (orders, created_at, total_price) sesuai DB Anda
    $this->db->select("DATE(created_at) AS date, COUNT(*) AS order_count, IFNULL(SUM(cost_price),0) AS total_amount", false);

    if (!empty($where)) {
      $this->db->where($where);
    }

    // optional: filter range tanggal jika diberikan (expects 'YYYY-MM-DD')
    if (!empty($start_date) && !empty($end_date)) {
      $this->db->where("DATE(created_at) BETWEEN " . $this->db->escape($start_date) . " AND " . $this->db->escape($end_date));
    }

    // status should be completed orders
    // $this->db->where('status', 'completed');

    $this->db->group_by("DATE(created_at)");
    $this->db->order_by("DATE(created_at) ASC");

    $query = $this->db->get('orders');
    return $query->result_array();
  }

  /**
   * Get orders with optional filters.
   * 
   * @param array $filters Array with keys: search (order/customer name), date_from, date_to, customer_id, status
   * @return array
   */
  public function get_all_orders_filtered($filters = [])
  {
    $this->db->trans_start();

    $query = 'SELECT * FROM orders o ';
    $query .= 'INNER JOIN users u ON u.id=o.customer_id ';
    $query .= 'WHERE 1=1 ';

    // Search filter (customer name or order ID)
    if (!empty($filters['search'])) {
      $search = $this->db->escape_like_str($filters['search']);
      $query .= "AND (u.name LIKE '%$search%' OR o.id LIKE '%$search%') ";
    }

    // Date range filter
    if (!empty($filters['date_from'])) {
      $date_from = $this->db->escape($filters['date_from']);
      $query .= "AND DATE(o.created_at) >= $date_from ";
    }
    if (!empty($filters['date_to'])) {
      $date_to = $this->db->escape($filters['date_to']);
      $query .= "AND DATE(o.created_at) <= $date_to ";
    }

    // Customer filter
    if (!empty($filters['customer_id'])) {
      $customer_id = intval($filters['customer_id']);
      $query .= "AND o.customer_id = $customer_id ";
    }

    // Status filter
    if (!empty($filters['status'])) {
      $status = $this->db->escape($filters['status']);
      $query .= "AND o.status = $status ";
    }

    $query .= 'ORDER BY o.created_at DESC';

    $order = $this->db->query($query)->result_array();
    $this->db->trans_complete();

    return $order;
  }

  /**
   * Get recent orders that should be shown as notifications.
   * Conditions:
   * - order.status = 'unpaid'
   * - OR invoice.is_paid = 1 AND order.status NOT IN ('shipped','sending')
   */
  public function get_recent_notifications($limit = 5)
  {
    $this->db->trans_start();

    $sql = "SELECT o.id AS order_id, o.status AS order_status, o.created_at AS order_created, u.name AS customer_name, i.is_paid
            FROM orders o
            LEFT JOIN users u ON u.id = o.customer_id
            LEFT JOIN invoices i ON i.order_id = o.id
            WHERE (o.status = 'unpaid')
               OR (i.is_paid = 1 AND (o.status IS NULL OR o.status NOT IN ('shipped','sending','completed')))
            ORDER BY o.created_at DESC
            LIMIT ?";

    $query = $this->db->query($sql, [$limit]);
    $res = $query->result_array();

    $this->db->trans_complete();
    return $res;
  }

  public function data_order()
  {
    $data = [
      // 'id' => $this->uuid->v4(),
      // 'product_id' => $this->input->post('product_id'),
      // 'qty' => $this->input->post('qty'),
      'status' => 'unpaid', // default status 'unpaid'
      // 'sku' => $this->input->post('sku'),
      'customer_id' => $this->session->userdata('id_akun'),
      'created_at' => $this->M_app->datetime(),
      'updated_at' => $this->M_app->datetime(),
      'cost_price' => $this->input->post('total_cost_price'),
      'raw_cost_price' => $this->input->post('total_raw_cost_price'),
    ];

    return $data;
  }

  public function update_order($foto, $foto_default)
  {
    $prod = [
      'product_id' => $this->input->post('product_id'),
      // 'qty' => $this->input->post('qty'),
      'status' => $this->input->post('status'),
      'sku' => $this->input->post('sku'),
      'updated_at' => $this->M_app->datetime(),
    ];

    return $prod;
  }

  public function save_order($table, $activity)
  {
    $data = $this->data_order();

    $this->db->trans_start();
    // $this->db->insert('product', $user);
    $this->db->insert($table, $data);

    $order_id = $this->db->insert_id();

    $this->add_order_product($order_id);

    $this->db->trans_complete();

    $arr_result = [
      'order_id' => $order_id,
    ];

    if ($this->db->trans_status()) {

      //belum dibuat tabel nya
      // $this->M_app->log_activity(' menambahkan data baru ' . $activity . ' [' . $prod['id'] . ']');
      $arr_result['status'] = true;
    } else {
      $arr_result['status'] = false;
    }

    return $arr_result;
  }

  public function add_order_product($order_id)
  {
    $this->db->trans_start();
    $products = $this->input->post('product_id');
    $qty = $this->input->post('product_qty');

    foreach ($products as $i => $id) {
      $data = [
        'order_id' => $order_id,
        'product_id' => $id,
        'qty' => $qty[$i],
        'created_at' => $this->M_app->datetime(),
        'updated_at' => $this->M_app->datetime(),
      ];
      $this->db->insert('order_products', $data);
      $this->db->trans_complete();
    }
  }

  public function update_product($foto_default, $table, $activity)
  {
    $id = $this->input->post('id');

    $foto = $this->input->post('foto_product');

    $data = $this->update_order($foto, $foto_default);

    $this->db->trans_start();
    $this->db->where(['id' => $id]);
    $this->db->update($table, $data);

    $this->db->trans_complete();

    if ($this->db->trans_status()) {
      // $this->M_app->log_activity(' mengubah data ' . $activity . ' [' . $id . ']');
      return true;
    } else {

      return false;
    }
  }

  public function insert_batch($prod, $identities, $datas, $table, $activity)
  {
    $this->db->trans_start();
    $this->db->insert_batch('product', $prod);
    $this->db->trans_complete();

    if ($this->db->trans_status()) {
      // $this->M_app->log_activity(' import data baru ' . $activity);
      return true;
    } else {
      return false;
    }
  }

  public function hapus($id, $table, $activity)
  {
    $data = [
      'deleted_at' => $this->M_app->datetime(),
    ];

    $this->db->trans_start();
    $this->db->where(['id' => $id]);
    $this->db->update('product', $data);

    $this->db->trans_complete();

    if ($this->db->trans_status()) {
      // $this->M_app->log_activity($activity);
      return true;
    } else {
      return false;
    }
  }
}
