<div class="d-flex flex-column">
  <form method="POST" action="<?= base_url() ?>cart/checkout" enctype="multipart/form-data">

    <?php if (key_exists('id', $address)) : ?>
      <input type="text" name="address[id]" value="<?= $address['id'] ?>">
    <?php endif; ?>
    <input type="text" name="address[user_id]" value="<?= $user_id ?>">
    <div class="content p-2">

      <div class="card card-product-cart mb-2 p-2">
        <div class="d-flex">
          <div class="avatar me-3">
            <img class="rounded-circle" height="120" width="120" src="<?= base_url() ?>dist/img/products/sgm-expl.png" alt="" class="h-100">
          </div>
          <div class="col-6 p-2">
            <div class="form-group mb-2">
              <input type="text" class="form-control" name="name" value="<?= $name ?? $name ?>">
            </div>
            <div class="form-group mb-2">
              <input type="text" class="form-control" name="name" value="<?= $hp_akun ?? $hp_akun ?>">
            </div>
          </div>
        </div>
        <div class="p-2">
          <div class="form-group mb-2">
            <label class="form-label" for="">Negara</label>
            <input type="text" class="form-control" name="address[negara]" value="Indonesia" readonly>
          </div>
          <div class="form-group mb-2">
            <label class="form-label" for="">Provinsi</label>
            <input type="text" class="form-control" name="address[provinsi]" value="Jawa Tengah" readoly>
          </div>
          <div class="form-group mb-2">
            <label class="form-label" for="">Kota</label>
            <input type="text" class="form-control" name="address[kota]" value="<?= $address['kota'] ?? $address['kota'] ?>">
          </div>
          <div class="form-group mb-2">
            <label class="form-label" for="">Kecamatan</label>
            <input type="text" class="form-control" name="address[kecamatan]" value="<?= $address['kecamatan'] ?? $address['kecamatan'] ?>">
          </div>
          <div class="form-group mb-2">
            <label class="form-label" for="">Kelurahan</label>
            <input type="text" class="form-control" name="address[kecamatan]" value="<?= $address['kelurahan'] ?? $address['kelurahan'] ?>">
          </div>
          <div class="form-group mb-2">
            <label class="form-label" for="">Kode Pos</label>
            <input type="text" class="form-control" name="address[kecamatan]" value="<?= $address['kode_pos'] ?? $address['kode_pos'] ?>">
          </div>
          <div class="form-group mb-2">
            <label class="form-label" for="">Catatan</label>
            <textarea class="form-control" name="address[catatan]"><?= $address['catatan'] ?? $address['catatan'] ?></textarea>
          </div>
          <input type="text" id="address_long" name="address[long]" value="<?= $address['long'] ?? $address['long'] ?>">
          <input type="text" id="address_long" name="address[lat]" value="<?= $address['lat'] ?? $address['lat'] ?>">
        </div>
        <div class="col text-end">
          <button class="btn rounded-4 btn-sm bg-esensia text-light ms-1">Simpan</button>
        </div>

      </div>
    </div>

    <div class="container-button mt-auto">
      <button class="btn rounded-4 btn-sm p-2 px-4 bg-esensia text-light ms-1">Buat Pesanan</button>
    </div>
  </form>

</div>