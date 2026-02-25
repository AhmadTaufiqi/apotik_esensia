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
    $this->load->model('M_user');
    $this->load->model('M_invoice');
    $this->load->model('M_ongkir');

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

  public function detail($id)
  {
    $order = $this->M_orders->get_order_by_id($id);
    $status = $this->M_app->getOrderStatusHtml($order['status']);
    
    $order_products = $this->M_orders->get_order_product_by_orderid($id);

    $data = [
      'title' => 'Detail Order',
      'order' => $order,
      'order_status' => $status,
      'order_products' => $order_products,
      'back_url' => base_url('profile')
    ];
    $this->M_app->templateCart($data, 'order/detail');
  }

  public function createOrder()
  {
    $address = $this->M_user->get_user_address_by_id($this->session->userdata('id_akun'));
    $cost_price = $this->input->post('total_cost_price');
    // $ongkir = $address['jarak'] * 2000; // 2k per km
    $ongkir = $this->input->post('ongkir'); // 2k per km

    //recheck if ongkir was 0 from checkout form
    if($ongkir != 0) {
	  	$ongkir = $this->M_ongkir->get_ongkir_by_jarak($address['jarak']);
      $ongkir = $ongkir['nominal'];
    }
    
    $cart_product_id = $this->input->post('cart_product_id');

    $save = $this->M_orders->save_order('orders', 'create order form cart');
    $order_id = $this->db->insert_id();

    $input_invoice = [
      'order_id' => $save['order_id'],
      'order_price' => round($cost_price + $ongkir),
      'payment_id' => $this->input->post('payment_method_id'),
      'payment_method' => $this->input->post('payment_method_name'),
      'other' => null,
      'is_paid' => 0,
    ];

    $save_invoice = $this->M_invoice->save_invoice('invoices', $input_invoice, 'create invoice from order');

    if ($save['status'] && $save_invoice) {
      $this->M_cart->deactivate($cart_product_id);
      $this->session->set_flashdata('msg', '<small class="text-success ps-2">succes save order</small>');
    } else {
      $this->session->set_flashdata('msg', '<small class="text-danger ps-2">failed save order</small>');
    }

    redirect('invoice/' . $save['order_id']);
  }

  public function payment()
  {
    $this->load->view('order/index');
  }

  public function shipping()
  {
    $this->load->view('order/index');
  }

  public function confirm_arrived($order_id = null)
  {
    if (empty($order_id) || !$this->session->userdata('id_akun')) {
      redirect('auth/login');
    }

    $customer_id = $this->session->userdata('id_akun');

    if ($this->M_orders->confirm_arrived($order_id, $customer_id)) {
      $this->session->set_flashdata('success', 'Terima kasih! Pesanan telah dikonfirmasi diterima.');
    } else {
      $this->session->set_flashdata('error', 'Gagal mengkonfirmasi pesanan. Pastikan pesanan dalam status pengiriman.');
    }

    redirect('orders/detail/' . $order_id);
  }

  public function ongkir()
  {
    $this->load->view('order/ongkir');
  }
}
