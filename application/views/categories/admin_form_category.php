<main role="main" class="main-content" style="margin-top: 64px;">
  <form action="<?= base_url('admin/' . $submit_url) ?>" method="POST" enctype="multipart/form-data">
    <div class="card col-12 col-lg-9 px-0">
      <div class="card-body">
        <?= $this->session->flashdata('message') ?>
        <h4 class="mb-3"><?= $title ?></h4>
        <?php
        $foto_category = $icon ?? '';

        if (!empty($foto_category) && file_exists(FCPATH . 'dist/img/uploads/categories/' . $foto_category)) {
          $foto_category = $icon;
        } else {
          $foto_category = 'default_image.png';
        }

        if ($foto_category != '') {
        ?>
          <input type="hidden" name="foto_category" value="<?= $icon ?>">
        <?php }
        ?>

        <input type="hidden" name="id" value="<?= $id ?? '' ?>">

        <div>
          <div class="uploadcms mb-3 upload-container" style="min-height: 290px;width:95%;">
            <img class="rounded-15" src="<?= base_url('dist/img/uploads/categories/' . $foto_category) ?>" alt="" id="photo_product" style="position:absolute;width:200px;height:175px;">
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
              <label class="form-label required">Nama Kategori</label>
              <input type="text" name="name" class="form-control rounded-4" value="<?= $category ?? '' ?>" required>
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