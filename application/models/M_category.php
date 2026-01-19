<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_category extends CI_Model
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

  public function get_total_categories()
  {
    $total = $this->db->select('count(*) total_categories')
      ->from('product_category')->get()->row_array();
    if ($total) {
      return $total['total_categories'];
    }

    return 0;
  }

  public function get_all_categories(){

  }

  public function get_category_by_id($product_id)
  {
    $category = $this->db->select('*')
      ->get_where('product_category', ['id' => $product_id])->row_array();
    if ($category) {
      return $category;
    }

    return '';
  }

  public function update_cat($foto, $foto_default)
  {
    $prod = [
      'icon' => $this->M_app->updateBase64('categories', $foto, 'jpg|jpeg|png', 'base64_input', $foto_default),
      'category' => $this->input->post('name'),
      'updated_at' => $this->M_app->datetime(),
    ];

    return $prod;
  }

  public function update_category($foto_default, $table, $activity)
  {
    $id = $this->input->post('id');

    $foto = $this->input->post('foto_category');

    $data = $this->update_cat($foto, $foto_default);

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
