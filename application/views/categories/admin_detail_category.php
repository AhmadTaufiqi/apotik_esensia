<main role="main" class="main-content" style="margin-top: 64px;">
  <form action="<?= base_url('admin/' . $submit_url) ?>" method="POST" enctype="multipart/form-data">
    <div class="card col-9 px-0">
      <div class="card-body">
        <h3 class="mb-3">Create Product</h3>

        <?php
        // $foto_product = $kartu_identitas ?? '';
        // if ($foto_product != '') { 
        ?>
        <!-- <input type="hidden" name="foto_product" value="<?= $kartu_identitas ?>"> -->
        <?php //} 
        ?>
        <div>
          <div class="uploadcms mb-3 upload-container" style="min-height: 290px;width:95%;">
            <img class="rounded-15" src="<?= base_url('dist/img/uploads/products/' . ($foto_product == '' ? 'default_image.png' : $foto_product)) ?>" alt="" id="photo_product" style="position:absolute;width:220px;height:175px;">
            <div class="border-upload text-center">
              <input type="text" name="base64_input" id="base64_input">
              <input class="file-input" type="file" name="file" accept=".jpg, .jpeg, .png" hidden>
              <!-- <i class="fa-solid fa-image" style="font-size: 40px; color: #989898; margin-left: -7%;"></i> -->
              <p style="color: #989898; margin-left: -7%;">Pilih Foto</p>
            </div>
          </div>
        </div>
        <div class="d-flex">
          <div class="col">
            <div class="form-group">
              <label class="form-label required">Nama Produk</label>
              <input type="text" name="name" class="form-control rounded-4">
            </div>
            <div class="form-group">
              <label class="form-label required">SKU</label>
              <input type="text" name="sku" class="form-control">
            </div>
            <div class="form-group">
              <label class="form-label required">Harga</label>
              <input type="number" name="price" class="form-control">
            </div>
            <div class="form-group">
              <label class="form-label">Category</label>
              <select name="category" id="" class="form-control">
                <option value=""></option>
                <?php foreach ($categories as $cat) : ?>
                  <option value="<?= $cat->id ?>"><?= $cat->category ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="form-group">
              <label class="form-label required">Discount</label>
              <input type="number" name="discount" class="form-control" min="0" max="100">
            </div>
            <div class="form-group">
              <label for="" class="form-label">Deskripsi Produk</label>
              <textarea name="description" class="form-control" rows="4"></textarea>
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