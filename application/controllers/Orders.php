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
    $cart = $this->M_cart->get_user_cart_by_prod_id()($product_id, $user_id);
    
    
    if(!$cart){

      $this->M_cart->save_to_cart('1','cart_products', $product_id);
    } else {
      $cart_prod_id = $cart['id'];

      $this->M_cart->add_cart_prod_qty($cart_prod_id);
    }

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
