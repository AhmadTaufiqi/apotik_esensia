<main role="main" class="main-content" style="margin-top: 64px;">
  <div class="d-flex mb-3">
    <h1 class="mb-0">Product</h1>
    <a href="<?= base_url()?>admin/product/create" class="btn btn-primary ms-auto" style="align-content:center;">
      <i class="fas fa-plus me-1"></i>
      Create Product
    </a>
  </div>

  <div class="card">
    <div class="card-body">
      <div class="table-responsive">
        <table class="table">
          <thead>
            <tr>
              <th>Sku</th>
              <th>Nama</th>
              <th>Harga Rp.</th>
              <th>Kategori</th>
              <th>Diskon</th>
              <th width="10%">Action</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($data as $prod) : ?>
              <tr>
                <td><?= $prod->sku ?></td>
                <td><?= $prod->name ?></td>
                <td><?= number_format($prod->price, 0, 0, '.') ?></td>
                <td><?= $prod->t_category ?></td>
                <td><?= $prod->discount ?></td>
                <td>
                  <button class="btn btn-sm" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-ellipsis-vertical"></i>
                  </button>
                  <div class="dropdown-menu">
                    <a href="" class="dropdown-item">
                      <span class="iconify mr-2" data-icon="ci:show"></span>Lihat Detail</a>
                    <a class="dropdown-item" href="<?= base_url('admin/product/edit/' . $prod->id) ?>">
                      <span class="iconify mr-2" data-icon="material-symbols:edit-square-outline-rounded"></span>Edit</a>
                    <button class="dropdown-item" data-bs-toggle="modal" data-target="#hapusModal" onclick="hapus(<?= $prod->id ?>)">
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