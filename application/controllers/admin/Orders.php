<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once('vendor/autoload.php');

use Doku\Snap\Snap;

use Doku\Snap\Models\VA\Request\CreateVaRequestDto;
use Doku\Snap\Models\TotalAmount\TotalAmount;
use Doku\Snap\Models\VA\AdditionalInfo\CreateVaRequestAdditionalInfo;
use Doku\Snap\Models\VA\VirtualAccountConfig\CreateVaVirtualAccountConfig;

class Orders extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model('M_app');
    $this->load->model('M_orders');

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
    // Read filter parameters
    $search = $this->input->get('search');
    $date_from = $this->input->get('date_from');
    $date_to = $this->input->get('date_to');
    $customer_id = $this->input->get('customer_id');
    $status = $this->input->get('status');

    // Build filters array
    $filters = [
      'search' => $search,
      'date_from' => $date_from,
      'date_to' => $date_to,
      'customer_id' => $customer_id,
      'status' => $status,
    ];

    // Get filtered orders (use filtered method if any filter is set, otherwise use default)
    if (!empty($search) || !empty($date_from) || !empty($date_to) || !empty($customer_id) || !empty($status)) {
      $orders = $this->M_orders->get_all_orders_filtered($filters);
    } else {
      $orders = $this->M_orders->get_all_orders();
    }

    // Get list of unique customers for filter dropdown
    $customers = $this->db->select('id, name')->from('users')->where(['deleted_at' => null, 'role' => 2])->order_by('name', 'ASC')->get()->result();

    $data = [
      'title' => 'Pesanan',
      'data' => $orders,
      'customers' => $customers,
      'filters' => $filters,
    ];

    $this->M_app->admin_template($data, 'order/admin_orders');
  }

  public function detail($id)
  {
    if (empty($id)) {
      show_404();
    }

    // Get order with customer information and address details
    $order = $this->db->query(
      "
      SELECT o.*, 
             u.name as customer_name, 
             u.email as customer_email, 
             u.telp as customer_phone, 
             a.negara as address_negara,
             a.provinsi as address_provinsi,
             a.kota as address_kota,
             a.kecamatan as address_kecamatan,
             a.kelurahan as address_kelurahan,
             a.kode_pos as address_kode_pos,
             a.catatan as address_catatan,
             a.long as address_long,
             a.lat as address_lat,
             a.jarak as address_jarak
      FROM orders o
      INNER JOIN users u ON o.customer_id = u.id
      LEFT JOIN address a ON u.id = a.user_id
      WHERE o.id = " . $this->db->escape($id)
    )->row_array();

    if (empty($order)) {
      show_404();
    }

    // Get order products with product details
    $order_products = $this->M_orders->get_order_product_by_orderid($id);

    $data = [
      'title' => 'Detail Order #' . $id,
      'order' => $order,
      'order_products' => $order_products,
    ];

    $this->M_app->admin_template($data, 'order/admin_view_order');
  }

  public function populateOrderStatus()
  {
    // Accept status via GET or POST and return HTML fragment for that status
    $status = $this->input->get_post('status');
    if (empty($status)) {
      // default to unpaid if not provided
      $status = 'unpaid';
    }

    // Use the model method to generate HTML
    $html = $this->M_app->getOrderStatusHtml($status);

    // Return as HTML
    header('Content-Type: text/html; charset=utf-8');
    echo $html;
    return;
  }

  public function snap()
  {

    $privateKey = "-----BEGIN RSA PRIVATE KEY-----
MIIEpAIBAAKCAQEAuFICYiKw1iaCG4hjVDZ4nSjISgCxviHWmQ//C5rkMIqriwOr
SjVu6Ky0Y27JgXe7cjf8e5h9Via4xmmzDUVU0isxhoCRJoEp7qcw1ssjxfIhkpeN
LHh52CQQ1crIFfMvpnnBQMYULzCfzO6b48GSlhRgCR3hIkjU54VXQtVp2L9y/CVT
HFlr4SNKYDPe916p1LD463eJ4EVHbyh8VyExWC06jy2PzrVUuuCqBExolcPmkUvl
wqUiVdOGBy7+hJsjURuIa5BNBlcTvEL9gbehZ88UUsuGRioCbMLFVAcGk5x4KsKB
qU0ahILm2IklkQZfUqur9biYe4ot5dxUENyBfwIDAQABAoIBAQCdHYrajCeg5AJT
5daFmkkF7hWMvzrDj6SVpIULJ2UL26iOPvprr1BzFYROnck2ixFFM2QNFtb/8NHg
j4kI7uh2nksBE+amo8NSo0GGVnKP8O2dP4IfPjLegx+2nbwgucMMbQzGYhIih5gv
39USN5b0Rzn1i3q09tBE6eyQE8q97kEFhEy7D9pLPjKBNbXlfb6ij1evPt5HLlpP
rcwA8W5mGu7mJ5FV02/ZTcaVHls9tRmWMb5YaE2KqV/YMCZI7ZBM33X0V4QgHgro
nerBxnaE3BW8caX4GUj5AAkjCWGYCnMZpzfmuQdy8ULvbIpSRarmGHbxn+mhS8zO
jAST9mQBAoGBAOT6I+P0v9MPHuzBsXfsvpp+Eo+ExhzVpJEOqg60g4eYAmfvVtgH
NrHU1bK9eo1eZCsUvXx6GbEtEUcU/D28TgoMi4jSNgkNnj1Vd0qP5GcCwwKUiPSK
c4S2cfZbs05Ox/yEye3WufmDeU56Fk7XnQINX4gYmSPQEUPpvmk1PtG/AoGBAM4S
ssmGkPULPeVy60rMW+0F1BKFtuZSwR0JBYFT4YZNVzIVTk6Am66btNB6AwQvH7CV
UtE0t7Nau2D/Gk66DyxuGZJ65jumvUJyMX1ZM7eTMNPuZeYeHOpdAZNPM2aVNTcv
N5byuMA9KEorReKSL1gC0Qw+rn1tFoapL+dD5sBBAoGBAL69hKJC4nxtryQoIa61
vv0xIkL9po6khYb0gULoqlyMiwyLentQXwZ6Nl3Dq1ASHj0o9MO5bqeB1E+zMoA2
2YdTdfTOr4aRGo0bIdkxzmDlEw+WLhQPNTWLSZmgP9hulfdLom6Gnbs1AxsVZnnc
8ISiIT9cxkzn6Un6b8xyN1c/AoGAeeHhUQSANA7kGxOvStw3+qaZ2iKwHOYRRgUR
9n4QQ4j2665iVFgIvGtntG6V3iGpEp4fD5GonTIq5aG8g5fUZajxAwwhpGJoSiaU
Utkxl4A9Pvwf1M02uP8tcV1Ev4W8pdkNfgAtebYyYDvb57givGFeF2nzdkfRLPBg
Xt5wWoECgYBg4TXBho3SbgYfMf7eEx5ET+DaQ1UQ1C4+CaeGsilBRAxFUYBCK3RX
vgo3kczJrDGJ2H5uLzugX88BBwJB/BN0454vQj5GtO+uN07HZl9Kqt9nCf1Heyd3
KpReKNzR02XT7YlHnT9NYrE4zq49oco1hHP6kFOE5lpWALJ4bq+GVg==
-----END RSA PRIVATE KEY-----";
    $publicKey = "-----BEGIN PUBLIC KEY-----
MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAuFICYiKw1iaCG4hjVDZ4
nSjISgCxviHWmQ//C5rkMIqriwOrSjVu6Ky0Y27JgXe7cjf8e5h9Via4xmmzDUVU
0isxhoCRJoEp7qcw1ssjxfIhkpeNLHh52CQQ1crIFfMvpnnBQMYULzCfzO6b48GS
lhRgCR3hIkjU54VXQtVp2L9y/CVTHFlr4SNKYDPe916p1LD463eJ4EVHbyh8VyEx
WC06jy2PzrVUuuCqBExolcPmkUvlwqUiVdOGBy7+hJsjURuIa5BNBlcTvEL9gbeh
Z88UUsuGRioCbMLFVAcGk5x4KsKBqU0ahILm2IklkQZfUqur9biYe4ot5dxUENyB
fwIDAQAB
-----END PUBLIC KEY-----";
    $clientId = "BRN-0205-1765808905140";
    $secretKey = "SK-htCn0Zhhsrag4a4f6uBl";
    $isProduction = false;
    $issuer = "YOUR_ISSUER";
    $authCode = "YOUR_AUTH_CODE";
    $dokuPublicKey = "-----BEGIN PUBLIC KEY-----
MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEApUqg8zd3C9w804VQmwoPpsJgtdUAFBmRWGBuao9cdSlsBeKe9M7gmrpznUh/SAaX4V5XW8lbZ/9MsF1Y5rvu5iRxe2Kn6uR1hy10esyUlAtzdOm6ervcBCd66dY2j3u1qDRqIrhqrlSK/u50V9txIxYU3yOjUspLeseYOY+A6RjnZFoC/4sdyeBySGYW7ZqF5AlYk1zwckgxYm3GcaLtZEvA22Zp+JXvGv9pFxRF4JW4BsSoh3D4JOMV2r1gqXHdYP0W0LippCpw0VCX+uNuYt7jdZe3xZIUfrIZGiMldoBtMzjXqfhWw760IT4nTyT9AjpDCpFrXPkuYv1QBb95HwIDAQAB
-----END PUBLIC KEY-----";

    $snap = new Snap($privateKey, $publicKey, $dokuPublicKey, $clientId, $issuer, $isProduction, $secretKey, $authCode);
    return ($snap);
  }

  public function createVARequest()
  {
    $snap = $this->snap();
    // var_dump($snap);
    // exit;
    $createVaRequestDto = new CreateVaRequestDto(
      "81290142",  // partner
      "17223992157",  // customerno
      "8129014217223992157",  // virtualAccountNo
      "T_" . time(),  // virtualAccountName
      "test.example." . time() . "@test.com",  // virtualAccountEmail
      "621722399214895",  // virtualAccountPhone
      "INV_CIMB_" . time(),  // trxId
      new TotalAmount("12500.00", "IDR"),  // totalAmount
      new CreateVaRequestAdditionalInfo(
        "VIRTUAL_ACCOUNT_BANK_CIMB",
        new CreateVaVirtualAccountConfig(true)
      ), // additionalInfo
      'C',  // virtualAccountTrxType
      "2025-12-18T09:54:04+07:00"  // expiredDate
    );

    $result = $snap->createVa($createVaRequestDto);
    echo json_encode($result, JSON_PRETTY_PRINT);
  }

  public function latestNotifications()
  {
    // return latest orders that need admin attention as JSON
    $limit = intval($this->input->get('limit') ?? 5);
    $this->load->model('M_orders');
    $list = $this->M_orders->get_recent_notifications($limit);

    // map to a friendly structure
    $data = array_map(function ($r) {
      $title = 'Order Baru #' . ($r['order_id'] ?? '');
      if (($r['order_status'] ?? '') === 'unpaid') {
        $subtitle = 'Status: unpaid';
      } else if (isset($r['is_paid']) && $r['is_paid']) {
        $subtitle = 'Pembayaran diterima — perlu dikirim';
      } else {
        $subtitle = 'Perlu ditindaklanjuti';
      }

      return [
        'order_id' => $r['order_id'],
        'title' => $title,
        'message' => $subtitle,
        'created_at' => $r['order_created'] ?? null,
        'link' => base_url('admin/orders'),
      ];
    }, $list);

    $count = count($data);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode(['count' => $count, 'data' => $data]);
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

  public function manage_shipping($order_id)
  {
    if (empty($order_id)) {
      show_404();
    }

    // Get order with customer information
    $order = $this->db->query(
      "
      SELECT o.*, o.id order_id, u.name as customer_name, u.email as customer_email
      FROM orders o
      INNER JOIN users u ON o.customer_id = u.id
      WHERE o.id = " . $this->db->escape($order_id)
    )->row_array();

    if (empty($order)) {
      show_404();
    }

    // Handle POST request to update shipping status
    if ($this->input->post()) {
      $shipping_status = $this->input->post('shipping_status');

      if (!empty($shipping_status)) {
        $update_result = $this->M_orders->update_shipping_status($order_id, $shipping_status);

        if ($update_result) {
          $this->session->set_flashdata('success', 'Status pengiriman berhasil diperbarui.');
        } else {
          $this->session->set_flashdata('error', 'Gagal memperbarui status pengiriman.');
        }
      }

      redirect('admin/orders/manage_shipping/' . $order_id);
    }

    $data = [
      'title' => 'Kelola Pengiriman - Order #' . $order_id,
      'order' => $order,
    ];

    $this->M_app->admin_template($data, 'order/admin_manage_shipping');
  }
}
