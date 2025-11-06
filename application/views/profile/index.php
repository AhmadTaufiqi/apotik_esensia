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
        $order_products = $o['order_products'];
        ?>
        <div class="card card-product-cart mb-2 flex-col p-2">
          <div class="d-flex mb-3">
            <span>Dipesan Pada: <b class="text-muted"><?= date_format(date_create($order['created_at']), "Y/m/d") ?></b></span>
            <div class="ms-auto order-status-<?= $order['status'] ?>">
              <i class="fas fa-motorcycle"></i>
              <span><?= $order['status'] ?></span>
            </div>
          </div>

          <!-- loop products -->
          <?php foreach ($order_products as $idx => $op) : ?>
            <?php
            if ($idx == 1) {
              echo '<div class="collapse" id="collapse_prod_' . $order['id'] . '">';
            }

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
                <h5 class="color-esensia mb-0">Rp. <?= number_format($op['price'] - ($op['price'] * $op['discount'] / 100), 0, '', '.')?></h5>
              </div>
            </div>
            <?php
            if ($idx + 1 == count($order_products)) {
              echo '</div>';
              echo '<a class="text-center toggle-expand mt-2" data-bs-toggle="collapse" href="#collapse_prod_' . $order['id'] . '" role="button" aria-expanded="false" aria-controls="collapse_prod_' . $order['id'] . '">Lihat Semua</a>';
            }
            ?>
          <?php endforeach; ?>
        </div>
      <?php endforeach; ?>
    </div>
  </form>

</div>

<script>
  document.addEventListener("DOMContentLoaded", function() {

    var old_text = $('.toggle-expand').html();
    // console.log(old_text);

    $('.toggle-expand').on('click', function() {
      var expanded = $(this).attr('aria-expanded');

      if (expanded == 'true') {
        $(this).html('tutup');
      } else {
        $(this).html(old_text);
      }
    })
  })
</script>