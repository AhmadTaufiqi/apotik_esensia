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

  public function get_order_onchart($product_id, $user_id)
  {
    $this->db->trans_start();
    $order = $this->db->select('*')
      ->from('orders o')
      ->where(['o.product_id' => $product_id,])
      ->get()
      ->result_object();
    $this->db->trans_complete();

    return $order;
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

    foreach($products as $i => $id){
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
