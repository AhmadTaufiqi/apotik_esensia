<main role="main" class="main-content" style="margin-top: 64px;">
  <div class="d-flex mb-3">
    <h4 class="mb-0"><?= $title ?></h4>
    <a href="<?= base_url('admin/product') ?>" class="btn btn-secondary ms-auto text-light">Kembali</a>
  </div>

  <div class="card col-12 col-lg-9 px-0">
    <div class="card-body">
      <div class="row">
        <div class="col-md-4">
          <img src="<?= base_url('dist/img/uploads/products/' . ($product->image ?? 'default_image.png')) ?>" alt="<?= htmlspecialchars($product->name ?? '') ?>" class="img-fluid rounded-2 w-100">
        </div>
        <div class="col-md-8">
          <h3 class="fw-bold"><?= htmlspecialchars($product->name ?? '') ?></h3>
          <p class="text-muted">SKU: <strong><?= htmlspecialchars($product->sku ?? '-') ?></strong></p>

          <div class="mb-2">
            <div class="d-flex bg-light p-2 align-items-center">
              <h4 class="color-esensia mb-0">Rp <?= number_format($product->price ?? 0, 0, ',', '.') ?></h4>
              <?php if (!empty($product->discount) && $product->discount > 0) : ?>
                <small class="text-muted text-decoration-line-through ms-2">Rp <?= number_format($product->price ?? 0, 0, ',', '.') ?></small>
                <div class="col">
                  <span class="badge bg-danger"><?= intval($product->discount) ?>% OFF</span>
                </div>
              <?php endif; ?>
            </div>
          </div>

          <p class="mb-1">Stok: <strong><?= ($product->stock > 0) ? $product->stock . ' pcs' : 'Habis' ?></strong></p>
          <p class="mb-3">Kategori: <strong><?= htmlspecialchars($product->t_category ?? ($product->category ?? '-')) ?></strong></p>

          <hr>

          <?php if (!empty($product->description)) : ?>
            <div class="mb-3">
              <h6>Deskripsi</h6>
              <p class="text-muted"><?= nl2br(htmlspecialchars($product->description)) ?></p>
            </div>
          <?php endif; ?>

          <div class="d-flex gap-2">
            <a href="<?= base_url('admin/product/edit/' . $product->id) ?>" class="btn btn-primary text-light p-2 px-3">Edit</a>
            <button class="btn btn-danger p-2 px-3" data-bs-toggle="modal" data-bs-target="#hapusModal" onclick="document.getElementById('hapus_id').value='<?= $product->id ?>'">Hapus</button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal Hapus-->
  <div class="modal fade" id="hapusModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <form action="<?= base_url() ?>/admin/product/delete" method="POST">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Hapus Produk</h5>
            <button class="close" type="button" data-bs-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <input type="hidden" name="id" id="hapus_id">
          <div class="modal-body">Apakah Anda yakin ingin menghapus produk ini?</div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Batal</button>
            <button type="submit" id="btn-hapus" class="btn btn-primary">Hapus</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</main>