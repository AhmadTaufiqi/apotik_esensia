<div class="container px-0">
  <div class="d-flex flex-column">
    <div class="content p-2">
      <?php
      $total_price_order = 0;
      ?>
      <div class="card card-product-cart mb-2 flex-col p-3">
        <div class="d-flex mb-3">
          <span>Dipesan Pada: <b class="text-muted"><?= date_format(date_create($order['created_at']), "Y/m/d") ?></b></span>
          <div class="ms-auto">
            <?= $order_status ?>
          </div>
        </div>

        <!-- loop products -->
        <?php foreach ($order_products as $idx => $op) : ?>
          <?php
          $total_price_product = ($op['price'] - ($op['price'] * $op['discount'] / 100)) * $op['qty'];
          $total_price_order = $total_price_order + $total_price_product;

          if ($idx + 1 <= count($order_products) && $idx >= 1) {
            echo '<hr>';
          }

          ?>
          <div class="d-flex">
            <div>
              <div class="product-images">
                <img src="<?= base_url() ?>dist/img/uploads/products/<?= $op['image'] ?>" alt="" class="h-100">
              </div>
            </div>

            <div class="ms-auto form-group d-flex flex-column text-end justify-content-between">
              <div class="d-flex align-items-center">
                <div class="col">
                  <h6 class="form-label product-name fw-bold mb-0 mx-1"><?= $op['name'] ?></h6>
                </div>
                <span>x <?= $op['qty'] ?></span>
              </div>
              <h6 class="color-esensia mb-0">Rp. <?= number_format($total_price_product, 0, '', '.') ?></h6>
            </div>
          </div>
        <?php endforeach; ?>
        <div class="d-flex mt-3 align-items-center">
          <?php if ($order['status'] == 'unpaid') : ?>
            <a href="<?= base_url('invoice/') . $order['id'] ?>" class="btn btn-sm btn-danger text-light">Bayar Sekarang</a>
          <?php elseif ($order['status'] == 'paid') : ?>
            <a href="<?= base_url('invoice/detail/') . $order['id'] ?>" class="btn btn-sm btn-info text-light">Lihat Invoice</a>
          <?php endif; ?>
          <div class="text-end ms-auto d-flex align-items-center">
            <span class="me-1">Total:</span>
            <h5 class="color-esensia mb-0">Rp. <?= number_format($total_price_order, 0, '', '.') ?></h5>
          </div>
          <div class="text-end">
            <!-- <a href="<?= base_url() ?>orders/detail/<?= $order['id'] ?>" class="btn btn-sm btn-secondary text-light"><i class="fas fa-eye me-1"></i>detail</a> -->
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  document.addEventListener("DOMContentLoaded", function() {

    var old_text = $('.toggle-expand').html();
    // console.log(old_text);

    $('.toggle-expand').on('click', function() {
      var expanded = $(this).attr('aria-expanded');

      if (expanded == 'true') {
        $(this).html('<span style="border-bottom:1px solid #80808040;">tutup</span>');
      } else {
        $(this).html(old_text);
      }
    })
  })
</script>