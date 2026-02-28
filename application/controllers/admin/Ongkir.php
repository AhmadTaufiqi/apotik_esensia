<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ongkir extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model('M_app');
    $this->load->model('M_ongkir');

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
    $ongkir = $this->M_ongkir->get_all_ongkir();
    $data = [
      'title' => 'Manajemen Ongkir',
      'active_menu' => 'admin_ongkir',
      'data' => $ongkir
    ];

    $this->M_app->admin_template($data, 'order/admin_ongkir');
  }

  public function create()
  {
    $this->load->library('form_validation');

    $this->form_validation->set_rules('jarak_start', 'Jarak Start', 'required|numeric');
    $this->form_validation->set_rules('jarak_end', 'Jarak End', 'required|numeric|callback_validate_jarak_different|callback_validate_jarak_unique_create');
    $this->form_validation->set_rules('nominal', 'Nominal', 'required|numeric');

    if ($this->form_validation->run() == false) {
      $this->session->set_flashdata('error', validation_errors('<span>', '</span>'));
      redirect(base_url('admin_ongkir'));
    }

    // Normalize input to what model expects
    $jarak_start = $this->input->post('jarak_start');
    $jarak_end = $this->input->post('jarak_end');

    // set a single 'jarak' POST value so save_ongkir() can use it
    $_POST['jarak'] = $jarak_start . '-' . $jarak_end;

    $result = $this->M_ongkir->save_ongkir('ongkir', 'create');

    if (!empty($result['status'])) {
      $this->session->set_flashdata('success', 'Ongkir berhasil ditambahkan');
    } else {
      $this->session->set_flashdata('error', 'Gagal menambahkan ongkir');
    }

    redirect(base_url('admin_ongkir'));
  }

  public function update()
  {
    $this->load->library('form_validation');

    $this->form_validation->set_rules('id', 'ID', 'required');
    $this->form_validation->set_rules('jarak_start', 'Jarak Start', 'required|numeric');
    $this->form_validation->set_rules('jarak_end', 'Jarak End', 'required|numeric|callback_validate_jarak_different|callback_validate_jarak_unique_update');
    $this->form_validation->set_rules('nominal', 'Nominal', 'required|numeric');

    if ($this->form_validation->run() == false) {
      $this->session->set_flashdata('error', validation_errors('<span>', '</span>'));
      redirect(base_url('admin_ongkir'));
    }

    $jarak_start = $this->input->post('jarak_start');
    $jarak_end = $this->input->post('jarak_end');

    // map to model expected field
    $_POST['jarak'] = $jarak_start . '-' . $jarak_end;

    $result = $this->M_ongkir->update_ongkir('ongkir', 'update');

    if (!empty($result['status'])) {
      $this->session->set_flashdata('success', 'Ongkir berhasil diperbarui');
    } else {
      $this->session->set_flashdata('error', 'Gagal memperbarui ongkir');
    }

    redirect(base_url('admin_ongkir'));
  }

  /**
   * Hapus (soft delete) data ongkir
   */
  public function delete()
  {
    $id = $this->input->post('id');

    if (empty($id)) {
      $this->session->set_flashdata('error', 'ID tidak ditemukan');
      redirect(base_url('admin_ongkir'));
    }

    $result = $this->M_ongkir->delete_ongkir($id);

    if ($result) {
      $this->session->set_flashdata('success', 'Ongkir berhasil dihapus');
    } else {
      $this->session->set_flashdata('error', 'Gagal menghapus ongkir');
    }

    redirect(base_url('admin_ongkir'));
  }

  /**
   * Callback untuk validasi bahwa jarak_start dan jarak_end tidak boleh sama
   */
  public function validate_jarak_different($jarak_end)
  {
    $jarak_start = $this->input->post('jarak_start');

    if ($jarak_start == $jarak_end) {
      $this->form_validation->set_message('validate_jarak_different', 'Jarak Start dan Jarak End tidak boleh sama');
      return false;
    }

    return true;
  }

  /**
   * Callback untuk validasi bahwa kombinasi jarak_start dan jarak_end bersifat unique (CREATE)
   */
  public function validate_jarak_unique_create($jarak_end)
  {
    $jarak_start = $this->input->post('jarak_start');

    // Cek apakah kombinasi jarak sudah ada di database
    $existing = $this->M_ongkir->check_jarak_exists($jarak_start, $jarak_end);

    if ($existing) {
      $this->form_validation->set_message('validate_jarak_unique_create', 'Rentang jarak tersebut tumpang tindih dengan data lain');
      return false;
    }

    return true;
  }

  /**
   * Callback untuk validasi bahwa kombinasi jarak_start dan jarak_end bersifat unique (UPDATE)
   */
  public function validate_jarak_unique_update($jarak_end)
  {
    $jarak_start = $this->input->post('jarak_start');
    $id = $this->input->post('id');

    // Cek apakah kombinasi jarak sudah ada di database (exclude record saat ini)
    $existing = $this->M_ongkir->check_jarak_exists($jarak_start, $jarak_end, $id);

    if ($existing) {
      $this->form_validation->set_message('validate_jarak_unique_update', 'Rentang jarak tersebut tumpang tindih dengan data lain');
      return false;
    }

    return true;
  }
}
