<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Orders extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->load->model('M_app');
    $this->load->model('M_orders');
    $this->load->model('M_cart');

    $is_nologin = false;

    if (empty($this->session->userdata('id_akun'))) {
      $is_nologin = true;
    } elseif ($this->session->userdata('role') != 2) {
      $is_nologin = true;
    }

    if ($is_nologin) {
      redirect(base_url('auth'));
    }
  }

  public function index()
  {
    $this->load->view('order/index');
  }

  public function createOrder(){
    $cart_product_id = $this->input->post('cart_product_id');

    $save = $this->M_orders->save_order('orders', 'create order form cart');

    if($save){
      $this->M_cart->deactivate($cart_product_id);
      $this->session->set_flashdata('msg', '<small class="text-success ps-2">succes save order</small>');
      
    } else {
      $this->session->set_flashdata('msg', '<small class="text-danger ps-2">failed save order</small>');
    }

    redirect('orders/index');
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
