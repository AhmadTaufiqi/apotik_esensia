<main role="main" class="main-content" style="margin-top: 64px;">
  <form action="<?= base_url('admin/' . $submit_url) ?>" method="POST" enctype="multipart/form-data">
    <div class="card col-12 col-lg-9 px-0">
      <div class="card-body">
        <h4 class="mb-3"><?= $title ?></h4>
        <?= $this->session->flashdata('message') ?>

        <input type="hidden" name="id" value="<?= $id ?? '' ?>">
        <input type="hidden" name="profile" value="<?= $profile ?? '' ?>">

        <div class="row">
          <div class="col-md-4 text-center">
            <img src="<?= base_url('dist/img/uploads/users/' . ($profile == '' ? 'default.png' : $profile)) ?>" class="img-fluid rounded mb-3" alt="profile" style="max-height:200px;">
            <div class="mb-3">
              <input type="file" name="foto" accept=".jpg,.jpeg,.png">
            </div>
          </div>
          <div class="col-md-8">
            <div class="mb-3">
              <label class="form-label required">Nama</label>
              <input type="text" name="name" class="form-control" value="<?= $name ?? '' ?>" required>
            </div>
            <div class="mb-3">
              <label class="form-label required">Username</label>
              <input type="text" name="username" class="form-control" value="<?= $username ?? '' ?>" required>
            </div>
            <div class="mb-3">
              <label class="form-label required">Email</label>
              <input type="email" name="email" class="form-control" value="<?= $email ?? '' ?>" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Telepon</label>
              <input type="text" name="telp" class="form-control" value="<?= $telp ?? '' ?>">
            </div>
            <div class="mb-3">
              <label class="form-label">Role</label>
              <select name="role" class="form-control">
                <option value="1" <?= (isset($role) && $role == 1) ? 'selected' : '' ?>>Admin</option>
                <option value="2" <?= (isset($role) && $role == 2) ? 'selected' : '' ?>>User</option>
                <option value="3" <?= (isset($role) && $role == 3) ? 'selected' : '' ?>>Juru Pungut</option>
              </select>
            </div>
            <div class="mb-3">
              <label class="form-label">Password (kosongkan jika tidak diubah)</label>
              <input type="password" name="password" class="form-control">
            </div>
          </div>
        </div>

        <?php // address section ?>
        <div class="mt-4">
          <h5>Alamat</h5>
          <div class="mb-3">
            <label class="form-label">Jalan</label>
            <input type="text" name="jalan" class="form-control" value="<?= $address['jalan'] ?? '' ?>">
          </div>
          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label">Kota</label>
              <input type="text" name="kota" class="form-control" value="<?= $address['kota'] ?? '' ?>">
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Provinsi</label>
              <input type="text" name="provinsi" class="form-control" value="<?= $address['provinsi'] ?? '' ?>">
            </div>
          </div>
          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label">Kode Pos</label>
              <input type="text" name="kode_pos" class="form-control" value="<?= $address['kode_pos'] ?? '' ?>">
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Negara</label>
              <input type="text" name="negara" class="form-control" value="<?= $address['negara'] ?? '' ?>">
            </div>
          </div>
        </div>

        <div class="d-flex mt-3">
          <div class="col text-end">
            <button class="btn btn-primary">Simpan</button>
          </div>
        </div>
      </div>
    </div>
  </form>
</main>
