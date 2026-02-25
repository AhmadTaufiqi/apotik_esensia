<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_ongkir extends CI_Model
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

  public function get_all_ongkir()
  {
    return $this->db->get('ongkir')->result_array();
  }

  public function get_ongkir_by_jarak($jarak)
  {
    // Cari ongkir dimana jarak masuk dalam range jarak_start dan jarak_end
    $this->db->where('jarak_start <=', $jarak);
    $this->db->where('jarak_end >=', $jarak);
    $ongkir = $this->db->get('ongkir')->row_array();

    // Jika tidak ada ongkir yang sesuai, ambil ongkir dengan nominal tertinggi
    if (empty($ongkir)) {
      $this->db->order_by('nominal', 'DESC');
      $this->db->limit(1);
      $ongkir = $this->db->get('ongkir')->row_array();
    }

    return $ongkir;
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

  public function save_ongkir($table, $activity)
  {
    $data = [
      'jarak_start' => $this->input->post('jarak_start'),
      'jarak_end' => $this->input->post('jarak_end'),
      'nominal' => $this->input->post('nominal'),
      'created_at' => $this->M_app->datetime(),
      'updated_at' => $this->M_app->datetime()
    ];

    $this->db->trans_start();

    $this->db->insert($table, $data);

    $this->db->trans_complete();

    if ($this->db->trans_status()) {
      $arr_result['status'] = true;
    } else {
      $arr_result['status'] = false;
    }

    return $arr_result;
  }

  public function update_ongkir($table, $activity)
  {
    $id = $this->input->post('id');

    $data = [
      'jarak_start' => $this->input->post('jarak_start'),
      'jarak_end' => $this->input->post('jarak_end'),
      'nominal' => $this->input->post('nominal'),
      'updated_at' => $this->M_app->datetime()
    ];

    $this->db->trans_start();

    $this->db->where(['id' => $id]);
    $this->db->update($table, $data);

    $this->db->trans_complete();

    if ($this->db->trans_status()) {
      $arr_result['status'] = true;
    } else {
      $arr_result['status'] = false;
    }
    return $arr_result;
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

  /**
   * Cek apakah kombinasi jarak_start dan jarak_end sudah ada di database
   * @param int $jarak_start
   * @param int $jarak_end
   * @param int $exclude_id (opsional) - ID record yang dikecualikan (untuk update)
   * @return bool true jika sudah ada, false jika belum ada
   */
  public function check_jarak_exists($jarak_start, $jarak_end, $exclude_id = null)
  {
    // Pastikan nilai numerik dan normalisasi range (start <= end)
    $start = (float) $jarak_start;
    $end = (float) $jarak_end;
    if ($start > $end) {
      $tmp = $start;
      $start = $end;
      $end = $tmp;
    }

    // Cek apakah ada record yang tumpang tindih dengan rentang [start, end]
    // Kondisi overlap (inklusif): existing.start <= new_end AND existing.end >= new_start
    $this->db->where('jarak_start <=', $end);
    $this->db->where('jarak_end >=', $start);

    // Jika exclude_id ada (saat update), exclude record dengan ID tersebut
    if ($exclude_id !== null) {
      $this->db->where('id !=', $exclude_id);
    }

    $query = $this->db->get('ongkir');

    return $query->num_rows() > 0;
  }

  /**
   * Soft delete ongkir record by setting deleted_at
   * @param int $id
   * @return bool
   */
  public function delete_ongkir($id)
  {
    if (empty($id)) {
      return false;
    }

    $this->db->trans_start();
    $this->db->delete('ongkir', ['id' => $id]);
    $this->db->trans_complete();

    return $this->db->trans_status();
  }
}
