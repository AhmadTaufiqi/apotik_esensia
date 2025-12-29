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
    
    //if expired should delete the order & invoice

    if($invoice){
      if ($invoice['is_paid'] == 0 && strtotime($invoice['expired_at']) < time()) {
        // delete order
        $this->M_orders->delete_order_by_id($order_id);
        //delete invoice
        $this->M_invoice->delete_invoice_by_orderid($order_id);
        redirect(base_url('orders'));
      }
  // var_dump($invoice);exit;
    //   $input = [
    //     'order_id' => $order_id,
    //     'order_price' => $invoice['order_price'] + $invoice['ongkir'],
    //     'payment_id' => $invoice['payment_id'],
    //     'payment_method' => $this->input->post('payment_methods'),
    //     'other' => '',
    //     'is_paid' => $invoice['is_paid'],
    //   ];

    }
    $data = [
      'title' => 'Bayar Pesanan',
      'invoice' => $invoice
    ];

    $this->M_app->templateCart($data, 'invoice/index');
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
