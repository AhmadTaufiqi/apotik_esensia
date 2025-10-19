<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Orders extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->load->model('M_app');
    $this->load->model('M_cart');
    // if (empty($this->session->userdata('id_akun'))) {
    // 	redirect(base_url('login'));
    // }
  }

  public function index()
  {
    $this->load->view('order/index');
  }

  public function addToCart()
  {
    $user_id = $this->session->userdata('id_akun');
    $product_id = $this->input->post('product_id');
    $product_oncart = $this->M_cart->get_user_cart($product_id, $user_id);
    
    var_dump($product_oncart);
    $this->M_cart->save_to_cart('1','cart', $product_id);

    echo $this->input->post('product_id');
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
