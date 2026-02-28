<main role="main" class="main-content" style="margin-top: 64px;">
  <div class="row">
    <div class="card col-lg-9">
      <div class="card-body">
        <h4 class="mb-3"><?= $title ?></h4>

        <div class="row">
          <div class="col">
            <img src="<?= base_url('dist/img/uploads/users/' . ($user['foto'] ?? 'default.png')) ?>" class="img-fluid rounded mb-3" alt="profile" style="max-height:200px;">
          </div>
          <div class="col-md-8">
            <table class="table">
              <tr>
                <th>Nama</th>
                <td><?= htmlspecialchars($user['name'] ?? '') ?></td>
              </tr>
              <tr>
                <th>Email</th>
                <td><?= htmlspecialchars($user['email'] ?? '') ?></td>
              </tr>
              <tr>
                <th>Telepon</th>
                <td><?= htmlspecialchars($user['telp'] ?? '-') ?></td>
              </tr>
              <tr>
                <th>Role</th>
                <td>
                  <?php if ($user['role'] == 1) : ?>
                    <span class="badge bg-primary">Admin</span>
                  <?php elseif ($user['role'] == 2) : ?>
                    <span class="badge bg-secondary">User</span>
                  <?php elseif ($user['role'] == 3) : ?>
                    <span class="badge bg-warning text-dark">Juru Pungut</span>
                  <?php else : ?>
                    <span class="badge bg-light text-dark">-</span>
                  <?php endif; ?>
                </td>
              </tr>
              <tr>
                <th>Dibuat</th>
                <td><?= htmlspecialchars($user['created_at'] ?? '') ?></td>
              </tr>
            </table>

            <?php if (!empty($address)) : ?>
              <h5 class="mt-4">Alamat</h5>
              <table class="table">
                <tr>
                  <td colspan="2"><?= htmlspecialchars($address['catatan'] ?? '-') ?></td>
                </tr>
                <tr>
                  <th>Jalan</th>
                  <td><?= empty($address['jalan']) || $address['jalan'] == '' ? $address['jalan'] : '-' ?></td>
                </tr>
                <tr>
                  <th>Kelurahan</th>
                  <td><?= htmlspecialchars($address['kelurahan'] ?? '-') ?></td>
                </tr>
                <tr>
                  <th>Kecamatan</th>
                  <td><?= htmlspecialchars($address['kecamatan'] ?? '-') ?></td>
                </tr>
                <tr>
                  <th>Kota</th>
                  <td><?= htmlspecialchars($address['kota'] ?? '-') ?></td>
                </tr>
                <tr>
                  <th>Provinsi</th>
                  <td><?= htmlspecialchars($address['provinsi'] ?? '-') ?></td>
                </tr>
                <tr>
                  <th>Kode Pos</th>
                  <td><?= htmlspecialchars($address['kode_pos'] ?? '-') ?></td>
                </tr>
                <tr>
                  <th>Negara</th>
                  <td><?= htmlspecialchars($address['negara'] ?? '-') ?></td>
                </tr>
              </table>
            <?php endif; ?>

            <?php if (!empty($identitas)) : ?>
              <h5 class="mt-4">Identitas</h5>
              <table class="table">
                <tr>
                  <th>Jenis Identitas</th>
                  <td><?= htmlspecialchars($identitas['jenis_identitas'] ?? '') ?></td>
                </tr>
                <tr>
                  <th>Nomor Identitas</th>
                  <td><?= htmlspecialchars($identitas['nomor_identitas'] ?? '') ?></td>
                </tr>
                <tr>
                  <th>Foto Kartu</th>
                  <td>
                    <?php if (!empty($identitas['kartu_identitas'])) : ?>
                      <img src="<?= base_url('dist/img/uploads/users/identitas/' . $identitas['kartu_identitas']) ?>" style="max-height:150px;" class="img-fluid">
                    <?php else : ?>
                      -
                    <?php endif; ?>
                  </td>
                </tr>
              </table>
            <?php endif; ?>

            <?php if (!empty($address)) : ?>
              <h5 class="mt-4">Alamat</h5>
              <table class="table">
                <tr>
                  <th>Jalan</th>
                  <td><?= htmlspecialchars($address['jalan'] ?? '-') ?></td>
                </tr>
                <tr>
                  <th>Kota</th>
                  <td><?= htmlspecialchars($address['kota'] ?? '-') ?></td>
                </tr>
                <tr>
                  <th>Provinsi</th>
                  <td><?= htmlspecialchars($address['provinsi'] ?? '-') ?></td>
                </tr>
                <tr>
                  <th>Kode Pos</th>
                  <td><?= htmlspecialchars($address['kode_pos'] ?? '-') ?></td>
                </tr>
                <tr>
                  <th>Negara</th>
                  <td><?= htmlspecialchars($address['negara'] ?? '-') ?></td>
                </tr>
              </table>
            <?php endif; ?>

          </div>
        </div>

        <div class="mt-3">
          <a href="<?= base_url('admin/user/edit/' . $user['id']) ?>" class="btn btn-primary text-light">Edit</a>
          <a href="<?= base_url('admin/user') ?>" class="btn btn-light">Kembali</a>
        </div>
      </div>
    </div>

  </div>
</main>