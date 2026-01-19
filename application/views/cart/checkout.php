  <div class="d-flex flex-column">
    <form action="<?= base_url() ?>orders/createOrder" method="POST">
      <div class="container">

        <div class="content p-2">
          <div class="card mb-2 py-2 px-3">
            <div class="d-flex">
              <div class="d-flex flex-column me-auto">
                <div class="d-flex align-items-center mb-2">
                  <i class="fas fa-location-dot fa-lg color-esensia"></i>
                  <h5 class="mb-0 ms-2" id="address_name"><?= $user['name'] ?? 'Nama tidak tersedia' ?></h5>
                  <span class="ms-2 small" id="address_phone_number"><?= $user['telp'] ?? 'Telepon tidak tersedia' ?></span>
                </div>
                <span>
                  <?php if ($address) : ?>
                    <?= $address['jalan'] . ' ' . $address['kode_pos'] . ', ' . $address['kelurahan'] . ', ' . $address['kecamatan'] . ', ' . $address['kota'] . ', ' . $address['provinsi'] ?>
                  <?php else : ?>
                    Alamat belum diisi. Silakan lengkapi alamat di profil.
                  <?php endif; ?>
                </span>
              </div>
              <a href="<?= base_url() ?>profile/edit" class="col-1 text-end align-self-center">
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
      </div>

      <input type="hidden" name="total_cost_price" value="<?= $total_price ?>">
      <input type="hidden" name="total_raw_cost_price" value="<?= $raw_total_price ?>">
      <input type="hidden" name="payment_method_name" id="payment_method_name">
      <input type="hidden" name="payment_method_id" id="payment_method_id">
      <div class="container-button mt-auto">
        <div class="d-flex align-items-center container">
          <h5 id="total_price_cart" class="color-esensia ms-auto mb-0">Rp. <?= number_format($total_price, 0, '', '.'); ?></h5>
          <button id="btn_create_order" class="btn rounded-4 btn-sm p-2 px-4 bg-esensia text-light ms-1" <?= empty($cart_products) ? 'disabled' : '' ?>>Buat Pesanan</button>
        </div>
      </div>
    </form>
  </div>

  <div class="offcanvas offcanvas-bottom" tabindex="-1" id="offcanvasBottom" aria-labelledby="offcanvasBottomLabel" style="height: 40vh;">
    <div class="offcanvas-header py-2">
      <h5 class="offcanvas-title" id="offcanvasBottomLabel">Metode Pembayaran</h5>
      <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body small">
      <!-- QRIS -->
      <div class="mb-4">
        <div class="row g-2">
          <?php foreach ($payment_method as $pm) : ?>
            <div class="col-6 col-lg-3">
              <div class="payment-option" data-value="<?= $pm['method_name'] ?>" data-id="<?= $pm['id'] ?>">
                <?php if (strtolower($pm['bank_name']) == 'qris') : ?>
                  <img src="<?= base_url() ?>dist/img/payment_methods/qris.png" alt="QRIS" />
                <?php else : ?>
                  <img src="<?= base_url() ?>dist/img/payment_methods/<?= $pm['image'] ?>" alt="QRIS" />
                <?php endif; ?>
                <span><?= $pm['method_name'] ?></span>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>

    </div>
    <div class="modal-footer justify-content-center">
      <div id="selectedMethod" class="text-center text-muted">
        Belum ada metode yang dipilih
      </div>
      <input type="hidden" id="temp_payment_method_name" name="payment_method_name">
      <input type="hidden" id="temp_payment_method_id" name="payment_method_id">
      <div class="ms-auto">
        <button class="btn btn-sm btn-success" id="save_payment_method">Simpan</button>
      </div>
    </div>
  </div>
  <script>
    const isCartEmpty = '<?= empty($cart_products) ?>';
    const hasAddress = '<?= ($address && !empty($address['long']) && !empty($address['lat']) && !empty($address['kecamatan']) && !empty($address['kelurahan'])) ? 'true' : 'false' ?>';
    const options = document.querySelectorAll(".payment-option");
    const selectedText = document.getElementById("selectedMethod");

    options.forEach((option) => {
      option.addEventListener("click", () => {
        options.forEach((opt) => opt.classList.remove("active"));
        option.classList.add("active");
        selectedText.innerHTML = `<strong>Metode dipilih:</strong> ${option.dataset.value}`;
        $('#temp_payment_method_id').val(option.dataset.id);
        $('#temp_payment_method_name').val(option.dataset.value);
      });
    });

    document.addEventListener("DOMContentLoaded", function() {

      $('#save_payment_method').on('click', function(e) {
        console.log('clicked');
        e.preventDefault();
        const method_id = $('#temp_payment_method_id').val();
        const selectedMethod = $('#temp_payment_method_name').val();
        $('#payment_method_id').val(method_id);
        $('#payment_method_name').val(selectedMethod);

        $('#metode-pembayaran').text(selectedMethod);
        $('#offcanvasBottom').offcanvas('hide');

        activatesaveButton();
      });

      $('#btn_create_order').on('click', function(e) {
        if (hasAddress === 'false') {
          alert('Alamat belum diisi. Silakan lengkapi alamat di profil.');
          e.preventDefault();
          return false;
        }
      });

      function activatesaveButton() {
        // console.log(isCartEmpty);
        const payment_method = $('#payment_method_id').val();

        console.log(payment_method);
        console.log(hasAddress);
        if (payment_method == '' || payment_method == null || payment_method == undefined || hasAddress === 'false') {
          $('#btn_create_order').prop('disabled', true);
        } else {
          $('#btn_create_order').prop('disabled', false);
        }
      }
      activatesaveButton();
    });
  </script>