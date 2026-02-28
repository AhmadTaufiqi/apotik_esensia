<main role="main" class="main-content" style="margin-top: 64px;">
  <form action="<?= base_url('admin/' . $submit_url) ?>" method="POST" enctype="multipart/form-data">
    <div class="card col-12 col-lg-9 px-0">
      <div class="card-body">
        <h4 class="mb-3"><?= $title ?></h4>
        <?= $this->session->flashdata('message') ?>

        <input type="hidden" name="id" value="<?= $id ?? '' ?>">
        <input type="hidden" name="profile" value="<?= $profile ?? '' ?>">

        <div class="row">
          <!-- <div class="col-md-4 text-center">
            <img src="<?= base_url('dist/img/uploads/users/' . ($profile == '' ? 'default.png' : $profile)) ?>" class="img-fluid rounded mb-3" alt="profile" style="max-height:200px;">
            <div class="mb-3">
              <input type="file" name="foto" accept=".jpg,.jpeg,.png">
            </div>
          </div> -->
          <div class="avatar d-flex align-items-center px-2 p-4">
            <div class="profile-pic-div add-shadow" style="width: 120px; height: 120px;">
              <img src="<?= base_url() ?>dist/img/uploads/users/<?= $profile != '' ? $profile : 'default.png' ?>" id="photo" style="object-fit: cover; object-position: 100% 0;">
              <input type="file" id="file_profile" name="foto" max="2000" accept=".jpg,.jpeg,.png">
              <label for="file_profile" id="uploadBtn" style="height:40px">Pilih Foto</label>
            </div>
            <input type="hidden" id="foto_base64" name="foto_base64" max="2000">
          </div>
          <div class="col-md-8">
            <div class="mb-3">
              <label class="form-label required">Nama</label>
              <input type="text" name="name" class="form-control" value="<?= $name ?? '' ?>" required>
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
                <option value="3" <?= (isset($role) && $role == 3) ? 'selected' : '' ?>>Kasir</option>
                <option value="4" <?= (isset($role) && $role == 4) ? 'selected' : '' ?>>Kurir</option>
              </select>
            </div>
            <div class="mb-3">
              <label class="form-label">Password (kosongkan jika tidak diubah)</label>
              <input type="password" name="new_password" class="form-control" autocomplete="new-password">
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