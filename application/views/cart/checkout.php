<div class="d-flex flex-column">
  <form action="<?= base_url() ?>orders/createOrder" method="POST">
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

    <input type="text" name="total_cost_price" value="<?= $total_price ?>">
    <input type="text" name="total_raw_cost_price" value="<?= $raw_total_price ?>">
    <input type="text" name="payment_method" id="payment_method">
    <div class="container-button mt-auto">
      <h5 id="total_price_cart" class="color-esensia ms-auto mb-0">Rp. <?= number_format($total_price, 0, '', '.'); ?></h5>
      <button id="btn_create_order" class="btn rounded-4 btn-sm p-2 px-4 bg-esensia text-light ms-1" <?= empty($cart_products) ? 'disabled' : '' ?>>Buat Pesanan</button>
    </div>
  </form>
</div>

<div class="offcanvas offcanvas-bottom" tabindex="-1" id="offcanvasBottom" aria-labelledby="offcanvasBottomLabel" style="height: 60vh;">
  <div class="offcanvas-header py-2">
    <h5 class="offcanvas-title" id="offcanvasBottomLabel">Offcanvas bottom</h5>
    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body small">

    <!-- Transfer Bank -->
    <div class="mb-4">
      <div class="category-title">
        <i class="bi bi-bank category-icon"></i> Transfer Bank
      </div>
      <div class="row g-2">
        <div class="col-6">
          <div class="payment-option" data-value="Bank BCA">
            <img src="https://upload.wikimedia.org/wikipedia/id/thumb/6/68/Logo_BCA.svg/512px-Logo_BCA.svg.png" alt="BCA" />
            <span>Bank BCA</span>
          </div>
        </div>
        <div class="col-6">
          <div class="payment-option" data-value="Bank BRI">
            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/3/3f/Bank_BRI_logo.svg/512px-Bank_BRI_logo.svg.png" alt="BRI" />
            <span>Bank BRI</span>
          </div>
        </div>
        <div class="col-6">
          <div class="payment-option" data-value="Bank Mandiri">
            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/9/9f/Logo_Bank_Mandiri.svg/512px-Logo_Bank_Mandiri.svg.png" alt="Mandiri" />
            <span>Bank Mandiri</span>
          </div>
        </div>
        <div class="col-6">
          <div class="payment-option" data-value="Bank BNI">
            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/1/12/Logo_BNI.svg/512px-Logo_BNI.svg.png" alt="BNI" />
            <span>Bank BNI</span>
          </div>
        </div>
        <div class="col-6">
          <div class="payment-option" data-value="CIMB Niaga">
            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/b/b9/CIMB_Niaga_logo.svg/512px-CIMB_Niaga_logo.svg.png" alt="CIMB Niaga" />
            <span>CIMB Niaga</span>
          </div>
        </div>
      </div>
    </div>

    <!-- Virtual Account -->
    <div class="mb-4">
      <div class="category-title">
        <i class="bi bi-credit-card category-icon"></i> Virtual Account
      </div>
      <div class="row g-2">
        <div class="col-6">
          <div class="payment-option" data-value="BCA Virtual Account">
            <img src="https://upload.wikimedia.org/wikipedia/id/thumb/6/68/Logo_BCA.svg/512px-Logo_BCA.svg.png" alt="BCA VA" />
            <span>BCA VA</span>
          </div>
        </div>
        <div class="col-6">
          <div class="payment-option" data-value="BRI Virtual Account">
            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/3/3f/Bank_BRI_logo.svg/512px-Bank_BRI_logo.svg.png" alt="BRI VA" />
            <span>BRI VA</span>
          </div>
        </div>
        <div class="col-6">
          <div class="payment-option" data-value="Mandiri Virtual Account">
            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/9/9f/Logo_Bank_Mandiri.svg/512px-Logo_Bank_Mandiri.svg.png" alt="Mandiri VA" />
            <span>Mandiri VA</span>
          </div>
        </div>
        <div class="col-6">
          <div class="payment-option" data-value="BNI Virtual Account">
            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/1/12/Logo_BNI.svg/512px-Logo_BNI.svg.png" alt="BNI VA" />
            <span>BNI VA</span>
          </div>
        </div>
      </div>
    </div>

    <!-- E-Wallet -->
    <div class="mb-4">
      <div class="category-title">
        <i class="bi bi-wallet2 category-icon"></i> E-Wallet
      </div>
      <div class="row g-2">
        <div class="col-6">
          <div class="payment-option" data-value="GoPay">
            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/8/8e/GoPay_logo.svg/512px-GoPay_logo.svg.png" alt="GoPay" />
            <span>GoPay</span>
          </div>
        </div>
        <div class="col-6">
          <div class="payment-option" data-value="ShopeePay">
            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/8/88/ShopeePay_logo.svg/512px-ShopeePay_logo.svg.png" alt="ShopeePay" />
            <span>ShopeePay</span>
          </div>
        </div>
      </div>
    </div>

    <!-- QRIS -->
    <div class="mb-4">
      <div class="category-title">
        <i class="bi bi-qr-code category-icon"></i> QRIS
      </div>
      <div class="row g-2">
        <div class="col-12">
          <div class="payment-option" data-value="QRIS (All Payment QR)">
            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/8/83/Logo_QRIS.svg/512px-Logo_QRIS.svg.png" alt="QRIS" />
            <span>QRIS (All Payment QR)</span>
          </div>
        </div>
      </div>
    </div>

  </div>
  <div class="modal-footer justify-content-center">
    <div id="selectedMethod" class="text-center text-muted">
      Belum ada metode yang dipilih
    </div>
    <input type="text" id="temp_payment_method" name="payment_method">
    <div class="ms-auto">
      <button class="btn btn-sm btn-success" id="save_payment_method">Simpan</button>
    </div>
  </div>
</div>

<script>
  const isCartEmpty = '<?= empty($cart_products) ?>';
  const options = document.querySelectorAll(".payment-option");
  const selectedText = document.getElementById("selectedMethod");

  options.forEach((option) => {
    option.addEventListener("click", () => {
      options.forEach((opt) => opt.classList.remove("active"));
      option.classList.add("active");
      selectedText.innerHTML = `<strong>Metode dipilih:</strong> ${option.dataset.value}`;
      $('#temp_payment_method').val(option.dataset.value);
    });
  });

  document.addEventListener("DOMContentLoaded", function() {

    $('#save_payment_method').on('click', function(e) {
      console.log('clicked');
      e.preventDefault();
      const selectedMethod = $('#temp_payment_method').val();
      $('#payment_method').val(selectedMethod);
      $('#metode-pembayaran').text(selectedMethod);
      $('#offcanvasBottom').offcanvas('hide');

      activatesaveButton();
    });

    function activatesaveButton() {
      console.log(isCartEmpty);
      const payment_method = $('#payment_method').val();

      if (payment_method == '') {
        $('#btn_create_order').prop('disabled', true);
      } else {
        $('#btn_create_order').prop('disabled', false);
      }
    }
    activatesaveButton();
  });
</script>