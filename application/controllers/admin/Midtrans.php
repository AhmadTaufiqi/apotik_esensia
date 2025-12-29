<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once('vendor/autoload.php');

use Midtrans\Snap;
use Midtrans\Config as MidtransConfig;

class Midtrans extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->load->model('M_app');
    $is_nologin = false;

    if (empty($this->session->userdata('id_akun'))) {
      $is_nologin = true;
    } elseif ($this->session->userdata('role') != 1) {
      $is_nologin = true;
    }

    if ($is_nologin) {
      redirect(base_url('admin/auth'));
    }

    // Set your Merchant Server Key
    MidtransConfig::$serverKey = 'Mid-server-JmzSr4aQaSxrqUrRPr326-aa';
    // MidtransConfig::$serverKey = 'Mid-server-MHgtWRTFFTv0q3wmlxzSIlAc'; // production
    // Set your Merchant Client Key
    MidtransConfig::$clientKey = 'Mid-client-S07l0keUTymY_FJ2';
    // MidtransConfig::$clientKey = 'Mid-client-7HL36Ml1Q6lOlDPM'; // production
    // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
    MidtransConfig::$isProduction = false;
    // MidtransConfig::$isProduction = true;
    // Set sanitization on (default)
    MidtransConfig::$isSanitized = true;
    // Set 3DS transaction for credit card to true
    MidtransConfig::$is3ds = true;
  }

  public function index()
  {
    $transaction_details = array(
      'order_id' => rand(),
      'gross_amount' => 10000 // no decimal allowed for creditcard
    );

    $item_details = array(
      'id' => 'a1',
      'price' => 10000,
      'quantity' => 1,
      'name' => 'Midtrans Test',
    );

    $customer_details = array(
      'first_name' => 'andri ani',
      'last_name' => 'setiawan',
      'email' => 'andrisetiawan@gmail.com',
      'phone' => '089176723321',
      'address' => array(
        'street' => 'jalan belum jadi',
        'city' => 'bandung',
        'postal_code' => '59171',
        'country_code' => 'IDN'
      )
    );

    $transaction = array(
      'transaction_details' => $transaction_details,
      'customer_details' => $customer_details,
      'item_details' => array($item_details),
    );

    $snapToken = '123';

    try {
      $snapToken = Snap::getSnapToken($transaction);
    } catch (\Exception $e) {
      echo $e->getMessage();
    }

    $this->load->view('midtrans_snap', array('snapToken' => $snapToken));

    // $user_id = $this->session->userdata('id_akun');
  }
}
