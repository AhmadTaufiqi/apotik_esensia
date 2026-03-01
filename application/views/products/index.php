<div class="container p-2">
  <h4>Produk</h4>
  <!-- <div class="d-flex align-items-center mb-3"> -->
  <form id="filter-form" method="get" action="<?= base_url('products') ?>">
    <div class="row mx-0 mb-3">
      <div class="col-12 p-0 col-lg-10">
        <div class="row">
          <div class="col-12 col-lg-5 px-2">
            <div class="form-group mb-2">
              <input type="text" name="search" id="filter-search" class="form-control rounded-15" placeholder="Cari produk" value="<?= htmlspecialchars($search ?? '') ?>">
            </div>
          </div>
          <div class="col-12 col-lg-4 px-2">
            <div class="form-group mb-2">
              <select name="category" id="filter-category" class="form-select rounded-15">
                <option value="">Semua Kategori</option>
                <?php if (!empty($categories)) : ?>
                  <?php foreach ($categories as $cat) : ?>
                    <option value="<?= $cat->id ?>" <?= ($this->input->get('category') == $cat->id) ? 'selected' : '' ?>>
                      <?= !empty($cat->category) ? htmlspecialchars($cat->category) : '' ?>
                    </option>
                  <?php endforeach; ?>
                <?php endif; ?>
              </select>
            </div>
          </div>
          <div class="col-12 col-lg-3 px-2">
            <div class="form-group mb-2">
              <select name="sort" id="filter-sort" class="form-select rounded-15">
                <option value="">Urutkan</option>
                <option value="price_asc" <?= ($this->input->get('sort') == 'price_asc') ? 'selected' : '' ?>>Harga: Rendah ke Tinggi</option>
                <option value="price_desc" <?= ($this->input->get('sort') == 'price_desc') ? 'selected' : '' ?>>Harga: Tinggi ke Rendah</option>
                <option value="name_asc" <?= ($this->input->get('sort') == 'name_asc') ? 'selected' : '' ?>>Nama: A-Z</option>
                <option value="name_desc" <?= ($this->input->get('sort') == 'name_desc') ? 'selected' : '' ?>>Nama: Z-A</option>
              </select>
            </div>
          </div>
        </div>
      </div>
      <div class="col p-0 text-end">
        <button type="submit" class="btn btn-primary rounded-15">Terapkan</button>
      </div>
    </div>
  </form>
  <!-- </div> -->

  <div class="row g-2">
    <?php if (!empty($products)) : ?>
      <?php foreach ($products as $pd) : ?>
        <div class="col-6 col-md-4 col-lg-3">
          <a href="<?= base_url('products/detail/' . $pd->id) ?>" style="text-decoration: none; color: inherit;">
            <div class="card card-product">
              <div>
                <div class="product-image">
                  <button class="btn-add-to-cart btn btn-sm btn-success" data-product-id="<?= $pd->id ?>" onclick="event.stopPropagation(); event.preventDefault(); return false;"><i class="fas fa-plus"></i></button>
                  <img src="<?= base_url() ?>dist/img/uploads/products/<?= $pd->image ?>" alt="<?= htmlspecialchars($pd->name) ?>" class="w-100" style="position:absolute; align-self:anchor-center;">
                </div>
                <p class="product-name"><?= htmlspecialchars($pd->name) ?></p>
              </div>
              <div class="px-2 pb-2">
                <?php $price = $pd->price ?>
                <small class="price-promo">Rp. <?= number_format($price, 0, '', '.') ?></small>
                <p class="price">Rp.<?= number_format($price - ($price * ($pd->discount ?? 0) / 100), 0, '', '.') ?></p>
              </div>
            </div>
          </a>
        </div>
      <?php endforeach; ?>
    <?php else : ?>
      <div class="col-12">
        <div class="alert alert-info">Tidak ada produk ditemukan.</div>
      </div>
    <?php endif; ?>
  </div>
</div>
<script>
  (function() {
    var cat = document.getElementById('filter-category');
    var sort = document.getElementById('filter-sort');
    var form = document.getElementById('filter-form');

    if (cat) cat.addEventListener('change', function() {
      form.submit();
    });
    if (sort) sort.addEventListener('change', function() {
      form.submit();
    });

    // Attach add-to-cart handlers (placeholder)
    document.querySelectorAll('.btn-add-to-cart').forEach(function(btn) {
      btn.addEventListener('click', function(e) {
        // event already stopped by inline handler, but keep safe
        e.stopPropagation();
        e.preventDefault();
        var id = this.getAttribute('data-product-id');
        alert('Tambah ke keranjang - Product ID: ' + id);
        // TODO: implement actual add-to-cart AJAX or form submit
        return false;
      });
    });
  })();
</script>