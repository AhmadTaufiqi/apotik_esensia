<div class="d-flex flex-column">
  <form method="POST" action="<?= base_url() ?>cart/checkout">

    <div class="content p-2">
      <?php foreach ($product_cart as $idx => $cart) : ?>
        <?php
        $discount = $cart->discount;
        $price = $discount ? $cart->price - ($cart->price * ($discount / 100)) : $cart->price;

        ?>
        <input type="hidden" value="<?= $cart->product_id ?>" name="product_id[<?= $idx ?>]">
        <input type="hidden" value="<?= $cart->cart_id ?>" name="product_cart_id[<?= $idx ?>]">

        <div class="card card-product-cart mb-2 flex-row">
          <div class="p-2">
            <div class="product-images">
              <img src="<?= base_url() ?>dist/img/uploads/products/<?= $cart->image ?>" alt="" class="h-100">
            </div>
          </div>

          <div class="col p-2 px-1 d-flex flex-column justify-content-between">
            <div class="form-group d-flex py-1">
              <div>
                <input type="checkbox" name="product_cb[<?= $idx ?>]" value="1" class="form-check-input form-check-lg mt-0 me-1">
              </div>
              <label class="form-label mb-0 product-name"><?= $cart->name ?></label>
            </div>
            <div class="row">
              <div class="input-group mt-2 col">
                <div class="minus-btn input-group-prepend">
                  <button type="button" class="btn btn-light btn-outline btn-sm"><i class="fa fa-minus text-danger"></i></button>
                </div>
                <input type="number" class="form-control qty_input form-control-sm text-center" value="<?= $cart->qty ?>" min="1" data-cart-id="<?= $cart->cart_id ?>" name="product_qty[<?= $idx ?>]">
                <div class="plus-btn input-group-prepend">
                  <button type="button" class="btn btn-light btn-outline btn-sm"><i class="fa fa-plus color-esensia"></i></button>
                </div>
              </div>
              <div class="col-2 p-0"></div>
            </div>
            <!-- <small class="price-promo">Rp. <?= number_format($cart->price, 0, '', '.') ?></small> -->
            <!-- <p class="price">Rp.<?= number_format($price - ($price * 20 / 100), 0, '', '.') ?></p> -->
          </div>
          <div class="pe-2 py-2 my-1 text-end d-flex flex-column justify-content-between">
            <h6 class="color-esensia mb-0">Rp. <?= number_format($price * $cart->qty, 0, '', '.') ?></h6>
            <small class="discount"><?= $discount ? number_format(($cart->price * $cart->qty), 0, '', '.') : '' ?></small>
            <a href="delete/<?= $cart->cart_id ?>" class="px-1 py-2 ms-auto" style="width:fit-content;"><i class="fas fa-trash text-danger fa-xl"></i></a>
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
      <button type="submit" class="btn rounded-4 btn-sm p-2 px-4 bg-esensia text-light ms-1">Buat Pesanan</button>
    </div>
  </form>

</div>