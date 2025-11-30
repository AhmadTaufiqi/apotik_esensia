<main class="main-content">
  <div class="container-fluid p-2">
    
    <?php if (!empty($product)) : ?>
      <!-- Product Image Section -->
      <div class="mb-3">
        <div class="card p-0 rounded-4 overflow-hidden">
          <img src="<?= base_url('dist/img/uploads/products/' . ($product->image ?? 'default_image.png')) ?>" 
               alt="<?= htmlspecialchars($product->name ?? '') ?>" 
               class="w-100" 
               style="height: 300px; object-fit: cover;">
        </div>
      </div>

      <!-- Product Info Card -->
      <div class="card p-3 mb-3">
        <!-- Product Name and Price -->
        <div class="mb-3">
          <h5 class="fw-bold mb-2"><?= htmlspecialchars($product->name ?? '') ?></h5>
          
          <!-- Price Section -->
          <div class="mb-3">
            <?php 
              $price = $product->price ?? 0;
              $discount = $product->discount ?? 0;
              $discounted_price = $price - ($price * $discount / 100);
            ?>
            <?php if ($discount > 0) : ?>
              <small class="text-muted text-decoration-line-through">
                Rp <?= number_format($price, 0, '', '.') ?>
              </small>
              <br>
              <div class="d-flex align-items-center gap-2">
                <h4 class="fw-bold text-success mb-0">
                  Rp <?= number_format($discounted_price, 0, '', '.') ?>
                </h4>
                <span class="badge bg-danger"><?= $discount ?>% OFF</span>
              </div>
            <?php else : ?>
              <h4 class="fw-bold text-success mb-0">
                Rp <?= number_format($price, 0, '', '.') ?>
              </h4>
            <?php endif; ?>
          </div>

          <!-- Stock Info -->
          <div class="mb-2">
            <small class="text-muted">
              Stok: <span class="fw-bold <?= ($product->stock > 0) ? 'text-success' : 'text-danger' ?>">
                <?= ($product->stock > 0) ? $product->stock . ' pcs' : 'Habis' ?>
              </span>
            </small>
          </div>

          <!-- SKU -->
          <?php if (!empty($product->sku)) : ?>
            <small class="text-muted">SKU: <span class="fw-bold"><?= htmlspecialchars($product->sku) ?></span></small>
          <?php endif; ?>
        </div>

        <!-- Divider -->
        <hr class="my-3">

        <!-- Description -->
        <?php if (!empty($product->description)) : ?>
          <div class="mb-3">
            <h6 class="fw-bold mb-2">Deskripsi</h6>
            <p class="text-muted small">
              <?= nl2br(htmlspecialchars($product->description)) ?>
            </p>
          </div>
        <?php endif; ?>

        <!-- Categories -->
        <?php if (!empty($product->category)) : ?>
          <div class="mb-3">
            <h6 class="fw-bold mb-2">Kategori</h6>
            <div class="d-flex flex-wrap gap-2">
              <?php 
                $categories = array_filter(array_map('trim', explode(',', $product->category)));
                foreach ($categories as $cat) : 
              ?>
                <span class="badge bg-light text-dark"><?= htmlspecialchars($cat) ?></span>
              <?php endforeach; ?>
            </div>
          </div>
        <?php endif; ?>

        <!-- Add to Cart Button -->
        <button class="btn btn-success w-100 py-2 fw-bold btn-add-to-cart" data-product-id="<?= $product->id ?? '' ?>">
          <i class="fas fa-shopping-cart me-2"></i>Tambah ke Keranjang
        </button>
      </div>

    <?php else : ?>
      <div class="alert alert-warning text-center">
        Produk tidak ditemukan.
      </div>
    <?php endif; ?>

  </div>
</main>
