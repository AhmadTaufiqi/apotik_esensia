    <div class="container p-0">

      <div id="carouselExampleSlidesOnly" class="carousel slide mb-3" data-bs-ride="carousel">
        <div class="carousel-inner">
          <div class="carousel-item active">
            <!-- <h1>Promo 1</h1> -->
            <img src="<?= base_url() ?>dist/img/banner/telekonsultasi.png" class="d-block" alt="...">
          </div>
          <div class="carousel-item">
            <!-- <h1>Promo 2</h1> -->
            <img src="<?= base_url() ?>dist/img/banner/vaksinasi_haji.png" class="d-block" alt="...">
          </div>
        </div>
      </div>

      <section id="small-categories" class="p-2">
        <div class="card p-2">
          <div class="d-flex">
            <div class="col">
              <span class="fw-bold">Cari Berdasarkan Kategori</span>
            </div>
            <a href="<?= base_url('categories') ?>" class="col-4 text-end">Lihat Semua</a>
          </div>
          <div class="d-flex">
            <?php foreach ($categories as $key => $cat) : ?>
              <?php
              if ($key >= 4) break; // limit to 4 categories shown
              if ($cat->icon == '') {
                $icon = "dist/img/uploads/categories/default_image.png";
              } else {
                $icon = "dist/img/uploads/categories/$cat->icon";

                if (!file_exists($icon)) {
                  $icon = "dist/img/uploads/categories/default_image.png";
                }
              }

              ?>
              <a href="#" class="item-category">
                <div class="card p-3 mb-2">
                  <img src="<?= base_url() . $icon ?>" alt="" style="width:65px;height:55px;border-radius:5px">
                </div>
                <span><?= $cat->category ?></span>
              </a>
            <?php endforeach; ?>
          </div>
        </div>
      </section>

      <section id="small-promos" class="p-2 mb-4">
        <div class="d-flex mb-1">
          <div class="col">
            <span class="fw-bold">Promo</span>
          </div>
          <a href="<?= base_url('Products') ?>" class="col-4 text-end">Lihat Semua</a>
        </div>
        <div class="slide-products">
          <div class="product-items">
            <?php foreach ($products as $key => $pd) : ?>
              <?php if ($key >= 6) {
                break;
              }
              ?>
              <a href="<?= base_url('products/detail/' . $pd->id) ?>" class="col-5 col-lg-3 p-0" style="text-decoration: none; color: inherit;">
                <div class="card card-product">
                  <div>
                    <div class="product-image">
                      <button class="btn-add-to-cart" data-product-id="<?= $pd->id ?>" onclick="event.stopPropagation(); event.preventDefault(); return false;"><i class="fas fa-plus"></i></button>
                      <img src="<?= base_url() ?>dist/img/uploads/products/<?= $pd->image ?>" alt="" class="w-100" style="position:absolute; align-self:anchor-center;">
                    </div>
                    <p class="product-name"><?= $pd->name ?></p>
                  </div>
                  <!-- kalau ada promo maka class .price-promo muncul -->
                  <div class="px-2 pb-2">
                    <?php $price = $pd->price ?>
                    <small class="price-promo" <?= ($pd->discount > 0 ? '' : 'hidden') ?>>Rp. <?= number_format($price, 0, '', '.') ?></small>
                    <p class="price">Rp.<?= number_format($price - ($price * $pd->discount / 100), 0, '', '.') ?></p>
                  </div>
                </div>
              </a>
            <?php endforeach; ?>
          </div>
        </div>
      </section>
    </div>