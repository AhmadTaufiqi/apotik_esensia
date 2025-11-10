<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Invoice extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->load->model('M_app');
    $this->load->model('M_orders');
    $this->load->model('M_invoice');

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

  public function index($order_id)
  {
    $invoice = $this->M_invoice->get_invoice_by_orderid($order_id);
    $data = [
      'title' => 'Bayar Pesanan'
    ];
    $this->M_app->templateCart($data, 'order/detail');
  }

  public function detail($id)
  {
    $order = $this->M_orders->get_order_by_id($id);
    $order_products = $this->M_orders->get_order_product_by_orderid($id);

    $data = [
      'title' => 'Detail Order',
      'order' => $order,
      'order_products' => $order_products,
    ];
    $this->M_app->templateCart($data, 'order/detail');
  }

  public function createOrder()
  {
    $cart_product_id = $this->input->post('cart_product_id');

    $save = $this->M_orders->save_order('orders', 'create order form cart');

    if ($save) {
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
