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
    $this->load->model('M_payment_method');

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
    $order = $this->M_orders->get_order_by_id($order_id);

    //if expired should delete the order & invoice
    $payment_method = [];

    if ($invoice) {
      $payment_method = $this->M_payment_method->get_payment_method($invoice['payment_id']);
    }

    $data = [
      'title' => 'Bayar Pesanan',
      'method' => $payment_method,
      'order' => $order,
      'invoice' => $invoice,
      'back_url' => base_url('orders/detail/' . $order_id)
    ];

    $data['back_url'] = false;
    if ($this->input->get('from') == 'orders') {
      $data['back_url'] = false;
    }

    $this->M_app->templateCart($data, 'invoice/index');
  }

  public function deleteExpired($order_id)
  {
    $invoice = $this->M_invoice->get_invoice_by_orderid($order_id);

    if ($invoice['is_paid'] == 0 && strtotime($invoice['expired_at']) < time()) {
      // delete order
      $this->M_orders->delete_order_by_id($order_id, 'orders', 'delete');
      //delete invoice
      $this->M_invoice->delete_invoice($order_id, 'invoices', 'delete');
      redirect(base_url('orders'));
    }
  }

  public function detail($order_id)
  {
    $order = $this->M_orders->get_order_by_id($order_id);
    $invoice = $this->M_invoice->get_invoice_by_orderid($order_id);

    $payment_method = [];

    if ($invoice) {
      $payment_method = $this->M_payment_method->get_payment_method($invoice['payment_id']);
    }

    $data = [
      'title' => 'Detail Invoice',
      'method' => $payment_method,
      'order' => $order,
      'invoice' => $invoice,
      'back_url' => base_url('orders/detail/' . $order_id)
    ];

    $this->M_app->templateCart($data, 'invoice/index');
  }

  public function uploadBuktiTf()
  {
    $id = $this->input->post('id');
    $order_id = $this->input->post('order_id');
    $this->M_invoice->upload_bukti_transfer($id, $order_id);
    redirect(base_url('/invoice/' . $order_id));
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
