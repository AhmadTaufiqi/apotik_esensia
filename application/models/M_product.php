<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_product extends CI_Model
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

  public function data_prod($role)
  {
    $data = [
      // 'id' => $this->uuid->v4(),
      'name' => ucwords($this->input->post('name')),
      'sku' => $this->input->post('sku'),
      'price' => $this->input->post('price'),
      // 'is_discount' => $this->input->post('is_discount'),
      'discount' => $this->input->post('discount'),
      'image' => $this->M_app->uploadFile('products', 'jpg|jpeg|png', 'file', 'default_image.png'),
      'description' => $this->input->post('description'),
      'category' => $this->input->post('category'),
      'created_at' => $this->M_app->datetime(),
      // 'updated_at' => $this->M_app->datetime(),
    ];

    return $data;
  }

  public function update_prod($foto, $foto_default)
  {
    $prod = [
      'name' => ucwords($this->input->post('name')),
      'sku' => $this->input->post('sku'),
      'price' => $this->input->post('price'),
      'is_discount' => $this->input->post('is_discount'),
      'discount' => $this->input->post('discount'),
      'image' => $this->M_app->updateBase64('products', $foto, 'jpg|jpeg|png', 'base64_input', $foto_default),
      'description' => $this->input->post('description'),
      'category' => $this->input->post('category'),
      'created_at' => $this->M_app->datetime(),
    ];

    return $prod;
  }

  public function save_product($role, $table, $activity)
  {
    $data = $this->data_prod($role);

    $this->db->trans_start();
    // $this->db->insert('product', $user);
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

  public function update_product($foto_default, $table, $activity)
  {
    $id = $this->input->post('id');

    $foto = $this->input->post('foto_product');

    $data = $this->update_prod($foto ,$foto_default);

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
