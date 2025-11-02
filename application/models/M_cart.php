<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_cart extends CI_Model
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

  public function get_cart_product($id)
  {
    $this->db->trans_start();

    $order = $this->db->select('*')
      ->from('cart_products cp')
      ->join('products p', 'cp.product_id = p.id', 'left')
      ->where(['cp.id' => $id])
      ->get()->row_array();

    $this->db->trans_complete();

    return $order;
  }

  public function get_user_cart($user_id, $status)
  {
    $this->db->trans_start();
    $order = $this->db->select('cp.id cart_id, cp.*, p.*')
      ->from('cart_products cp')
      ->join('products p', 'p.id = cp.product_id', 'left')
      ->where(['customer_id' => $user_id, 'status' => $status])
      ->get()
      ->result_object();

    $this->db->trans_complete();

    return $order;
  }

  public function get_total_user_cart($user_id)
  {
    $my_cart = $this->get_user_cart($user_id, 1);

    $sum = 0;
    foreach ($my_cart as $c) {
      $sum = $sum + $c->qty;
    }

    return $sum;
  }

  public function get_user_cart_by_prod_id($product_id, $user_id, $is_active)
  {
    $this->db->trans_start();
    $order = $this->db->select('*')
      ->from('cart_products')
      ->where([
        'product_id' => $product_id,
        'customer_id' => $user_id,
        'status' => $is_active,
      ])
      ->get()
      ->row_array();

    $this->db->trans_complete();

    return $order;
  }

  public function data_cart($role, $user_id)
  {
    $data = [
      // 'id' => $this->uuid->v4(),
      'qty' => 1,
      'product_id' => $this->input->post('product_id'),
      'created_at' => $this->M_app->datetime(),
      'updated_at' => $this->M_app->datetime(),
      // 'status' => 1, default = 1 on database
      'customer_id' => $user_id,
    ];

    return $data;
  }

  public function update_order($foto, $foto_default)
  {
    $prod = [
      'product_id' => $this->input->post('product_id'),
      'qty' => $this->input->post('qty'),
      'status' => $this->input->post('status'),
      'sku' => $this->input->post('sku'),
      'updated_at' => $this->M_app->datetime(),
    ];

    return $prod;
  }

  public function save_to_cart($role, $table, $user_id)
  {
    $data = $this->data_cart($role, $user_id);

    $this->db->trans_start();
    $this->db->insert($table, $data);

    $this->db->trans_complete();

    if ($this->db->trans_status()) {

      //belum dibuat tabel nya
      // $this->M_app->log_activity(' menambahkan data baru ' . $activity . ' [' . $prod['id'] . ']');
      return true;
    } else {
      return false;
    }
  }

  public function add_cart_prod_qty($id)
  {
    $this->db->trans_start();
    $cart_product = $this->db->get_where('cart_products', ['id' => $id])->row_array();
    $qty = $cart_product['qty'];

    $this->db->update('cart_products', ['qty' => $qty + 1], ['id' => $id]);
    $this->db->trans_complete();
  }

  public function update_cart_qty($cart_id, $qty)
  {
    $this->db->trans_start();
    $this->db->update('cart_products', ['qty' => $qty], ['id' => $cart_id]);
    $this->db->trans_complete();

    if ($this->db->trans_status()) {
      return true;
    } else {
      return false;
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

  public function delete_cart_product($id)
  {
    $this->db->trans_start();
    $this->db->delete('cart_products', ['id' => $id]);
    $this->db->trans_complete();

    if ($this->db->trans_status()) {
      // $this->M_app->log_activity($activity);
      return true;
    } else {
      return false;
    }
  }

  public function deactivate($arr_id)
  {
    $this->db->trans_start();

    $data = [
      'status' => 0,
      'updated_at' => $this->M_app->datetime()
    ];

    $this->db->where_in(['id' => $arr_id])->update('cart_products', $data);
    $this->db->trans_complete();
    if ($this->db->trans_status()) {
      // $this->M_app->log_activity($activity);
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
