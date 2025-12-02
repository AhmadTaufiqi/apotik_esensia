<main role="main" class="main-content" style="margin-top: 64px;">
  <form action="<?= base_url('admin/' . $submit_url) ?>" method="POST" enctype="multipart/form-data">


    <div class="card col-12 col-lg-9 px-0">
      <div class="card-body">
        <h4 class="mb-3"><?= $title ?></h4>
        <?= $this->session->flashdata('message') ?>
        <?php
        $foto_product = $image ?? '';
        if ($foto_product != '') {
        ?>
          <input type="hidden" name="foto_product" value="<?= $image ?>">
        <?php }
        ?>

        <input type="hidden" name="id" value="<?= $id ?? '' ?>">

        <div>
          <div class="uploadcms mb-3 upload-container" style="min-height: 290px;width:95%;">
            <img class="rounded-15" src="<?= base_url('dist/img/uploads/products/' . ($foto_product == '' ? 'default_image.png' : $foto_product)) ?>" alt="" id="photo_product" style="position:absolute;width:220px;height:175px;">
            <div class="border-upload text-center">
              <input type="text" name="base64_input" id="base64_input">
              <input class="file-input" type="file" name="foto" accept=".jpg, .jpeg, .png" hidden>
              <!-- <i class="fa-solid fa-image" style="font-size: 40px; color: #989898; margin-left: -7%;"></i> -->
              <p style="color: #989898; margin-left: -7%;">Pilih Foto</p>
            </div>
          </div>
        </div>
        <div class="d-flex">
          <div class="col">
            <div class="form-group">
              <label class="form-label required">Nama Produk</label>
              <input type="text" name="name" class="form-control rounded-4" value="<?= $name ?? '' ?>" required>
            </div>
            <div class="form-group">
              <label class="form-label required">SKU</label>
              <input type="text" name="sku" class="form-control" value="<?= $sku ?? '' ?>" required>
            </div>
            <div class="form-group">
              <label class="form-label required">Harga</label>
              <input type="number" name="price" class="form-control" value="<?= $price ?? '' ?>" required>
            </div>
            <div class="form-group">
              <label class="form-label required">Stok</label>
              <input type="number" name="stock" class="form-control" value="<?= $stock ?? '' ?>" required>
            </div>
            <div class="form-group">
              <label class="form-label">Category</label>
              <select name="category[]" id="category_select" class="form-control select2" multiple="multiple" data-placeholder="Pilih kategori">
                <?php foreach ($categories as $cat) : ?>
                  <?php
                    $selected = '';
                    if (isset($category)) {
                      if (is_array($category) && in_array($cat->id, $category)) $selected = 'selected';
                      elseif (!is_array($category) && $category == $cat->id) $selected = 'selected';
                    }
                  ?>
                  <option value="<?= $cat->id ?>" <?= $selected ?>><?= $cat->category ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="form-group">
              <label class="form-label required">Diskon</label>
              <input type="number" name="discount" class="form-control" min="0" max="100" value="<?= $discount ?? 0 ?>" required maxlength="100" minlength="0">
            </div>
            <div class="form-group">
              <label for="" class="form-label">Deskripsi Produk</label>
              <textarea name="description" class="form-control" rows="4"><?= $description ?? '' ?></textarea>
            </div>
          </div>
        </div>
        <div class="d-flex">
          <div class="col text-end">
            <button class="btn py-2 px-3 btn-primary ms-auto">Simpan</button>
          </div>
        </div>
      </div>
    </div>
  </form>
</main>
<script>
  // Initialize Select2 for category selection (multiple)
  document.addEventListener("DOMContentLoaded", function() {
  
    console.log(typeof $)
    if (typeof $ === 'undefined' || typeof $.fn.select2 === 'undefined') {
      // select2 not loaded; nothing to do
      return;
    }
    $('#category_select').select2({
      width: '100%',
      placeholder: $('#category_select').data('placeholder') || 'Pilih kategori',
      allowClear: true
    });
  });
</script>