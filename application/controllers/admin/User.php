<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model('M_app');
    $this->load->model('M_user');

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
    $user_id = $this->session->userdata('id_akun');
    $users = $this->M_user->get_users();

    $data = [
			'title' => 'Manajemen User',
      'active_menu' => 'admin_user',
      'data' => $users
    ];

    $this->M_app->admin_template($data, 'user_management');
  }

  public function view($id)
  {
    if (empty($id)) {
      $id = $this->input->get('id');
    }

    if (empty($id)) show_404();

    $user = $this->M_user->get_user_by_id($id);
    if (empty($user)) show_404();

    $address = $this->M_user->get_user_address_by_id($id);

    $data = [
      'title' => 'Detail User',
      'active_menu' => 'admin_user',
      'user' => $user,
      'address' => $address
    ];

    $this->M_app->admin_template($data, 'users/admin_view_user');
  }

  public function edit($id)
  {
    if (empty($id)) show_404();

    $user = $this->M_user->get_user_by_id($id);
    if (empty($user)) show_404();

    $address = $this->M_user->get_user_address_by_id($id);

    $data = [
      'title' => 'Edit User',
      'active_menu' => 'admin_user',
      'id' => $user['id'],
      'name' => $user['name'],
      'email' => $user['email'],
      'telp' => $user['telp'],
      'role' => $user['role'],
      'profile' => $user['foto'] ?? '',
      'address' => $address,
      'submit_url' => 'user/update'
    ];

    $this->M_app->admin_template($data, 'users/admin_form_user');
  }

  public function update()
  {
    $id = $this->input->post('id');
    $role = $this->input->post('role');

    // use update_identitas which handles users and user_identitas updates
    $updated = $this->M_user->update_profile('users', 'update_user', $role);

    if ($updated) {
      $alert = '<div class="alert alert-success" role="alert">Berhasil mengubah data user</div>';
    } else {
      $alert = '<div class="alert alert-danger" role="alert">Gagal mengubah data user</div>';
    }

    $this->session->set_flashdata('message', $alert);
    redirect('admin/user/edit/' . $id);
  }
}
