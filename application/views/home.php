    <div id="carouselExampleSlidesOnly" class="carousel slide mb-3" data-bs-ride="carousel">

      <!-- <div class="navbar px-2 navbar-top-fix">
        <div class="card p-1 rounded-circle border-0 me-2">
          <img src="<?= base_url() ?>dist/img/logo.png" alt="" height="30" class="rounded-circle">
        </div>
        <div class="col pe-2">
          <div class="search-container">
            <input type="text" class="form-control search-input" placeholder="Search...">
            <i class="fas fa-search search-icon"></i>
          </div>
        </div>
        <a href="#" class="btn bg-white rounded-circle px-1 me-1" style="height: 40px; width:40px;" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight">
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-basket2-fill color-esensia" viewBox="0 0 16 16">
            <path d="M5.929 1.757a.5.5 0 1 0-.858-.514L2.217 6H.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h.623l1.844 6.456A.75.75 0 0 0 3.69 15h8.622a.75.75 0 0 0 .722-.544L14.877 8h.623a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1.717L10.93 1.243a.5.5 0 1 0-.858.514L12.617 6H3.383zM4 10a1 1 0 0 1 2 0v2a1 1 0 1 1-2 0zm3 0a1 1 0 0 1 2 0v2a1 1 0 1 1-2 0zm4-1a1 1 0 0 1 1 1v2a1 1 0 1 1-2 0v-2a1 1 0 0 1 1-1" />
          </svg>
        </a>
      </div> -->
      <div class="carousel-inner" style="background-color: aliceblue;height:240px;">
        <div class="carousel-item active">
          <!-- <h1>Promo 1</h1> -->
          <img src="<?= base_url() ?>dist/img/banner/telekonsultasi.png" class="d-block" alt="...">
        </div>
        <div class="carousel-item">
          <!-- <h1>Promo 2</h1> -->
          <img src="<?= base_url() ?>dist/img/banner/vaksinasi_haji.png" class="d-block" alt="...">
        </div>
        <!-- <div class="carousel-item">
          <h1>Promo 3</h1>
          <img src="..." class="d-block w-100" alt="...">
        </div> -->
      </div>
    </div>

    <section id="small-categories" class="p-2">
      <div class="card p-2">
        <div class="d-flex">
          <div class="col">
            <span class="fw-bold">Cari Berdasarkan Kategori</span>
          </div>
          <a href="#" class="col-4 text-end">Lihat Semua</a>
        </div>
        <div class="d-flex">
          <?php foreach ($categories as $key => $cat) : ?>
            <?php
            if($key >= 4) break; // limit to 4 categories shown
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
          <!-- <a href="#" class="item-category">
            <div class="card p-3 mb-2">
              <img src="<?= base_url() ?>/dist/img/category/susu.png" alt="">
            </div>
            <span>SUSU</span>
          </a>
          <a href="#" class="item-category">
            <div class="card p-3 mb-2">
              <img src="<?= base_url() ?>/dist/img/category/vitamins.png" alt="">
            </div>
            <span>VITAMINS</span>
          </a>
          <a href="#" class="item-category">
            <div class="card p-3 mb-2">
              <img src="<?= base_url() ?>/dist/img/category/kontrasepsi.png" alt="">
            </div>
            <span>KONTRASEPSI</span>
          </a> -->
        </div>
      </div>
    </section>

    <section id="small-promos" class="p-2 mb-4">
      <div class="px-2">
        <div class="d-flex">
          <div class="col">
            <span class="fw-bold">Promo</span>
          </div>
          <a href="<?= base_url('Products/Promo') ?>" class="col-4 text-end">Lihat Semua</a>
        </div>
        <div class="slide-products">
          <div class="product-items">
            <?php foreach ($products as $pd) : ?>
              <div class="col-5 p-0">
                <div class="card card-product">
                  <div>
                    <div class="product-image">
                      <button class="btn-add-to-cart" data-product-id="<?= $pd->id ?>"><i class="fas fa-plus"></i></button>
                      <img src="<?= base_url() ?>dist/img/uploads/products/<?= $pd->image ?>" alt="" class="w-100">
                    </div>
                    <p class="product-name"><?= $pd->name ?></p>
                  </div>
                  <!-- kalau ada promo maka class .price-promo muncul -->
                  <div class="px-2 pb-2">
                    <?php $price = $pd->price ?>
                    <small class="price-promo">Rp. <?= number_format($price, 0, '', '.') ?></small>
                    <p class="price">Rp.<?= number_format($price - ($price * $pd->discount / 100), 0, '', '.') ?></p>
                  </div>
                </div>
              </div>
            <?php endforeach; ?>
            <!-- <div class="col-5 p-0">
              <div class="card card-product">
                <div>
                  <div class="product-image">
                    <button class="btn-add-to-cart" data-product-id="1"><i class="fas fa-plus"></i></button>
                    <img src="<?= base_url() ?>dist/img/products/sgm-expl.png" alt="" class="w-100">
                  </div>
                  <p class="product-name">Nama Obat obat obat obat</p>
                </div>
                <div class="px-2 pb-2">
                  <?php $price = 9000 ?>
                  <small class="price-promo">Rp. <?= number_format($price, 0, '', '.') ?></small>
                  <p class="price">Rp.<?= number_format($price - ($price * 20 / 100), 0, '', '.') ?></p>
                </div>
              </div>
            </div> -->
          </div>
        </div>
        <!-- <div class="d-flex">
          <a href="#" class="item-category">
            <img src="<?= base_url() ?>/dist/img/category/promo.png" alt="">
            <span>PROMO</span>
          </a>
          <a href="#" class="item-category">
            <img src="<?= base_url() ?>/dist/img/category/susu.png" alt="">
            <span>SUSU</span>
          </a>
          <a href="#" class="item-category">
            <img src="<?= base_url() ?>/dist/img/category/vitamins.png" alt="">
            <span>VITAMINS</span>
          </a>
          <a href="#" class="item-category">
            <img src="<?= base_url() ?>/dist/img/category/kontrasepsi.png" alt="">
            <span>KONTRASEPSI</span>
          </a>
        </div> -->
      </div>
    </section>