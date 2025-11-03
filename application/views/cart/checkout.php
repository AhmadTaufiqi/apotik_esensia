<div class="d-flex flex-column">
  <form action="<?= base_url()?>orders/createOrder" method="POST">
    <div class="content p-2">
      <div class="card mb-2 flex-row py-2 px-3">
        <div class="d-flex">
          <div class="d-flex flex-column">
            <div class="d-flex align-items-center mb-2">
              <i class="fas fa-location-dot fa-lg color-esensia"></i>
              <h5 class="mb-0 ms-2" id="address_name">Taufiqi</h5>
              <span class="ms-2 small" id="address_phone_number">089777333111</span>
            </div>
            <span>
              Jl. Ngesrep Barat Dalam III, Srondol Kulon, Kec. Banyumanik, Kota Semarang, Jawa Tengah 50263
            </span>
          </div>
          <a href="<?= base_url() ?>profile/edit_address" class="col-1 text-end align-self-center">
            <i class="fas fa-angle-right fa-xl text-muted"></i>
          </a>
        </div>
      </div>

      <?php
      $total_price = 0;
      $raw_total_price = 0;
      foreach ($cart_products as $i => $cp) : ?>
        <?php
        $prod_dataset = $cp['prod_dataset'];
        $quantity = $cp['product_qty'];
        $discount = $prod_dataset['discount'];
        $price = $cp['total_price'];
        $raw_price = $cp['raw_total_price'];

        $total_price = $total_price + $price;
        $raw_total_price = $raw_total_price + $raw_price;
        ?>
        <div class="card card-product-cart mb-2 flex-row">
          <div class="p-2">
            <div class="product-images">
              <img src="<?= base_url() ?>dist/img/uploads/products/<?= $prod_dataset['image'] ?>" alt="" class="h-100">
            </div>
          </div>

          <div class="form-group d-flex flex-column p-2 justify-content-between">
            <div class="d-flex">
              <h6 class="col form-label product-name mb-0 me-2"><?= $prod_dataset['name'] ?></h6>
              <span>x <?= $quantity ?></span>
            </div>
            <div class="text-end">
              <h5 class="color-esensia mb-0">Rp. <?= number_format($price, 0, '', '.'); ?></h5>
              <small class="discount"><?= $prod_dataset['discount'] ? "Rp. " . number_format($raw_price, 0, '', '.') : '' ?></small>
            </div>
          </div>
        </div>
        <input type="hidden" name="cart_product_id[<?= $i ?>]" value="<?= $cp['product_cart_id'] ?>">
        <input type="hidden" name="product_id[<?= $i ?>]" value="<?= $prod_dataset['id'] ?>">
        <input type="hidden" name="product_qty[<?= $i ?>]" value="<?= $quantity ?>">
      <?php endforeach; ?>
    </div>

    <div class="col card p-3 m-2">
      <a role="button" class="d-flex" data-bs-toggle="offcanvas" data-bs-target="#offcanvasBottom" aria-controls="offcanvasBottom">
        <span class="me-auto">Metode Pembayaran</span>
        <div>
          <span class="text-muted small" id="metode-pembayaran">Pilih Metode</span>
          <i class="fas fa-angle-right fa-lg text-muted"></i>
        </div>
      </a>
    </div>

    <input type="hidden" name="total_cost_price" value="<?= $total_price ?>">
    <input type="hidden" name="total_raw_cost_price" value="<?= $raw_total_price ?>">
    <div class="container-button mt-auto">
      <h5 id="total_price_cart" class="color-esensia ms-auto mb-0">Rp. <?= number_format($total_price, 0, '', '.'); ?></h5>
      <button class="btn rounded-4 btn-sm p-2 px-4 bg-esensia text-light ms-1" <?= empty($cart_products) ? 'disabled' : '' ?>>Buat Pesanan</button>
    </div>
  </form>
</div>

<div class="offcanvas offcanvas-bottom" tabindex="-1" id="offcanvasBottom" aria-labelledby="offcanvasBottomLabel">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title" id="offcanvasBottomLabel">Offcanvas bottom</h5>
    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body small">
    ...
  </div>
</div>