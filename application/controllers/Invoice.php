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
      // neither order nor invoice should be deleted anymore; just mark them expired
      $this->M_orders->set_to_expired_order($order_id);
      $this->db->update('invoices', ['status' => 'expired'], ['order_id' => $order_id]);
      redirect(base_url('orders'));
    }
  }

  /**
   * CLI / cron entry point to scan all invoices and expire overdue ones.
   *
   * Usage from shell:
   *   php index.php invoice cron_expire
   *
   * or schedule via web request if your hosting doesn't allow CLI:
   *   wget -qO- "https://example.com/invoice/cron_expire" >/dev/null 2>&1
   */
  public function cron_expire()
  {
    // allow both web and CLI for flexibility; if you prefer to restrict to CLI
    // you can uncomment the check below.
    // if (! $this->input->is_cli_request()) {
    //     show_error('This method may only be called from CLI');
    // }

    $success = $this->M_invoice->expire_overdue_orders();
    if ($success) {
      echo "expired invoices processed\n";
    } else {
      echo "failed to update expired invoices\n";
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
