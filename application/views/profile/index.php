<div class="d-flex flex-column">
  <form method="POST" action="<?= base_url() ?>cart/checkout">

    <div class="content p-2">

      <div class="card card-product-cart mb-2 flex-row p-2">
        <!-- <div class="col"> -->
        <div class="avatar me-3">
          <img class="rounded-circle" height="120" width="120" src="<?= base_url() ?>dist/img/uploads/users/<?= $foto_akun ?>" alt="" class="h-100">
        </div>
        <!-- </div> -->
        <div class="col p-2 py-3">
          <h4 class="mb-1"><?= $name ?></h4>
          <a href="<?= base_url() ?>profile/edit" class="esensia-link h6">Edit</a>
        </div>
        <div class="me-3 align-content-center">
          <a href="<?= base_url() ?>auth/logout" class="btn btn-logout">
            <i class="fas fa-power-off fa-2x"></i>
            <span>Logout</span>
          </a>
        </div>
      </div>
      <?php
      $order_id = 0;
      ?>
      <?php foreach ($orders as $o) : ?>
        <?php
        $order = $o['order'];
        foreach ($o['order_products'] as $op) {
        }
        ?>
        <div class="card card-product-cart mb-2 flex-row">
          <div class="p-2">
            <div class="product-images">
              <img src="<?= base_url() ?>dist/img/products/sgm-expl.png" alt="" class="h-100">
            </div>
          </div>

          <div class="form-group d-flex flex-column p-2 text-end justify-content-between">
            <div class="d-flex align-items-center">
              <h5 class="form-label product-name fw-bold mb-0 me-2">Nama Obat obat</h5>
              <span>x 2</span>
            </div>
            <h5 class="color-esensia mb-0">Rp. 90000</h5>
            <div class="order-status-sending">
              <i class="fas fa-motorcycle"></i>
              <span>Dalam Pengantaran</span>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>

    <div class="container-button mt-auto">
      <div>
        <input type="checkbox" name="cb_cart_product" value="1" class="form-check-input form-check-lg mt-0 me-1">
        <small class="text-muted">Semua</small>
      </div>
      <h5 id="total_price_cart" class="color-esensia ms-auto mb-0">Rp. 90000</h5>
      <button class="btn rounded-4 btn-sm p-2 px-4 bg-esensia text-light ms-1">Buat Pesanan</button>
    </div>
  </form>

</div>
<?
$arr = [
  [
    "order" =>
    [
      "id" => "1", "status" => "onchart", "created_at" => "2025-10-16 22:45:16", "updated_at" => null, "created_by" => "1", "customer_id" => "1", "cost_price" => null, "raw_cost_price" => null
    ],
    "order_products" => [
      [
        "id" => "1", "order_id" => "1", "product_id" => "1", "qty" => null, "created_at" => "2025-10-14 20:10:27", "updated_at" => "0000-00-00 00:00:00", "name" => "Tempra Anggur Sirup 60ml (per Botol) 60Ml Liter", "sku" => "TMPSY01", "price" => "54021", "is_discount" => "0", "discount" => "50", "image" => "DSC1760449587.png", "description" => "TEMPRA SIRUP merupakan obat untuk meredakan demam dan nyeri sakit kepala pada anak-anak. Sirup tempra paracetamol ini dapat menghambat pembentukan prostaglandin yang memicu nyeri dan juga bekerja pada pusat pengatur suhu di hipotalamus untuk menurunkan demam.", "category" => "0"
      ],
      [
        "id" => "9", "order_id" => "1", "product_id" => "9", "qty" => null, "created_at" => "2025-10-06 18:10:19", "updated_at" => "0000-00-00 00:00:00", "name" => "Sanmol Forte 250mg\/5ml Sirup 60ml (per Botol)", "sku" => "snm250", "price" => "41000", "is_discount" => "0", "discount" => "0", "image" => "1759750699.png", "description" => "Sanmol Forte sirup diproduksi oleh PT. Sanbe Farma dan telah terdaftar pada BPOM. Pada setiap 5ml sirup Sanmol Forte mengandung 250mg paracetamol. Sanmol Forte dapat digunakan untuk meredakan nyeri seperti sakit kepala, sakit gigi, serta demam yang menyertai flu dan setelah imunisasi.", "category" => "1"
      ],
      [
        "id" => "2", "order_id" => "1", "product_id" => "2", "qty" => null, "created_at" => "2025-10-08 21:10:15", "updated_at" => "0000-00-00 00:00:00", "name" => "Sanmol Forte 250mg\/5ml Sirup 60ml (per Botol)", "sku" => "snm250", "price" => "41000", "is_discount" => "0", "discount" => "0", "image" => "sik1759933755.png", "description" => "Sanmol Forte sirup diproduksi oleh PT. Sanbe Farma dan telah terdaftar pada BPOM. Pada setiap 5ml sirup Sanmol Forte mengandung 250mg paracetamol. Sanmol Forte dapat digunakan untuk meredakan nyeri seperti sakit kepala, sakit gigi, serta demam yang menyertai flu dan setelah imunisasi.", "category" => "0"
      ]
    ]
  ],
  [
    "order" =>
    [
      "id" => "6", "status" => null, "created_at" => "2025-10-30 00:10:27", "updated_at" => "2025-10-30 00:10:27", "created_by" => null, "customer_id" => "1", "cost_price" => "163032", "raw_cost_price" => "244063"
    ],
    "order_products" =>
    [
      [
        "id" => "2", "order_id" => "6", "product_id" => "2", "qty" => "2", "created_at" => "2025-10-08 21:10:15", "updated_at" => "2025-10-30 00:10:27", "name" => "Sanmol Forte 250mg\/5ml Sirup 60ml (per Botol)", "sku" => "snm250", "price" => "41000", "is_discount" => "0", "discount" => "0", "image" => "sik1759933755.png", "description" => "Sanmol Forte sirup diproduksi oleh PT. Sanbe Farma dan telah terdaftar pada BPOM. Pada setiap 5ml sirup Sanmol Forte mengandung 250mg paracetamol. Sanmol Forte dapat digunakan untuk meredakan nyeri seperti sakit kepala, sakit gigi, serta demam yang menyertai flu dan setelah imunisasi.", "category" => "0"
      ],
      [
        "id" => "1", "order_id" => "6", "product_id" => "1", "qty" => "3", "created_at" => "2025-10-14 20:10:27", "updated_at" => "2025-10-30 00:10:27", "name" => "Tempra Anggur Sirup 60ml (per Botol) 60Ml Liter", "sku" => "TMPSY01", "price" => "54021", "is_discount" => "0", "discount" => "50", "image" => "DSC1760449587.png", "description" => "TEMPRA SIRUP merupakan obat untuk meredakan demam dan nyeri sakit kepala pada anak-anak. Sirup tempra paracetamol ini dapat menghambat pembentukan prostaglandin yang memicu nyeri dan juga bekerja pada pusat pengatur suhu di hipotalamus untuk menurunkan demam.", "category" => "0"
      ]
    ]
  ]
];
