<div class="d-flex flex-column">
  <form action="" method="POST">
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
          <a href="" class="col-1 text-end align-self-center">
            <i class="fas fa-angle-right fa-xl text-muted"></i>
          </a>
        </div>
      </div>

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
          <div>
            <h5 class="color-esensia mb-0">Rp. 90000</h5>
            <small class="discount">Rp. 100000</small>
          </div>
        </div>
      </div>
      
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
          <div>
            <h5 class="color-esensia mb-0">Rp. 90000</h5>
            <small class="discount">Rp. 100000</small>
          </div>
        </div>
      </div>
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

<div class="offcanvas offcanvas-bottom" tabindex="-1" id="offcanvasBottom" aria-labelledby="offcanvasBottomLabel">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title" id="offcanvasBottomLabel">Offcanvas bottom</h5>
    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body small">
    ...
  </div>
</div>