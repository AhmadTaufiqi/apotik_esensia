<div class="container p-2">
  <div class="d-flex align-items-center mb-3">
    <h4 class="mb-0 mt-2">Kategori</h4>
  </div>

  <div class="row g-2 mb-3">
    <?php if (!empty($categories)) : ?>
      <?php foreach ($categories as $cat) : ?>
        <div class="col-4 col-lg-3">
          <?php
          if ($cat->icon == '') {
            $icon = "dist/img/uploads/categories/default_image.png";
          } else {
            $icon = "dist/img/uploads/categories/$cat->icon";

            if (!file_exists($icon)) {
              $icon = "dist/img/uploads/categories/default_image.png";
            }
          }

          ?>
          <div class="card p-3 mb-2">
            <a href="<?= base_url('products?category=' . $cat->id) ?>" class="d-flex flex-column w-100 p-3 py-2 text-center align-items-center">
              <img src="<?= base_url() . $icon ?>" alt="" style="width:85px;height:63px;border-radius:5px" class="mb-2">
              <span class="text-dark"><?= $cat->category ?></span>
            </a>
          </div>
        </div>
      <?php endforeach; ?>
    <?php else : ?>
      <div class="col-12">
        <div class="alert alert-info">Tidak ada kategori ditemukan.</div>
      </div>
    <?php endif; ?>
  </div>
</div>