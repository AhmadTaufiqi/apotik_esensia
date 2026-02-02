<main role="main" class="main-content" style="margin-top: 64px;">
  <div class="d-flex mb-3">
    <h4 class="mb-0"><?= $title ?></h4>
  </div>

  <div class="card">
    <div class="card-body">
      <div class="table-responsive">
        <table class="table datatable">
          <thead>
            <tr>
              <th>Nama</th>
              <th>Email</th>
              <th>Role</th>
              <th>Telepon</th>
              <th>Date Created</th>
              <th width="10%">Action</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($data as $user) : ?>
              <tr>
                <td><?= htmlspecialchars($user['nama'] ?? $user['name'] ?? '') ?></td>
                <td><?= htmlspecialchars($user['email'] ?? '') ?></td>
                <td>
                  <?php
                  $role = $user['role'];
                  if ($role == 1) echo '<span class="badge bg-primary">Admin</span>';
                  elseif ($role == 3) echo '<span class="badge bg-warning text-light">Kasir</span>';
                  elseif ($role == 4) echo '<span class="badge bg-info text-light">Kurir</span>';
                  elseif ($role == 2) echo '<span class="badge bg-secondary">User</span>';
                  else echo '<span class="badge bg-light text-light">-</span>';
                  ?>
                </td>
                <td><?= htmlspecialchars($user['telp'] ?? $user['phone'] ?? '-') ?></td>
                <td><?= htmlspecialchars($user['created_at'] ?? '') ?></td>
                <td>
                  <button class="btn btn-sm" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-ellipsis-vertical"></i>
                  </button>
                  <div class="dropdown-menu">
                    <a href="<?= base_url('admin/user/view/' . ($user['id'] ?? '')) ?>" class="dropdown-item">
                      <span class="iconify mr-2" data-icon="ci:show"></span>Lihat Detail</a>
                    <?php if ($user['role'] != 2) : ?>
                      <a class="dropdown-item" href="<?= base_url('admin/user/edit/' . ($user['id'] ?? '')) ?>">
                        <span class="iconify mr-2" data-icon="material-symbols:edit-square-outline-rounded"></span>Edit</a>
                    <?php endif; ?>
                    <button class="dropdown-item" data-bs-toggle="modal" data-target="#hapusModal" onclick="hapus(<?= htmlspecialchars($user['id'] ?? 0) ?>)">
                      <span class="iconify mr-2" data-icon="fluent:delete-48-regular"></span>Hapus</button>
                  </div>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</main>