<main role="main" class="main-content" style="margin-top: 64px;">
  <div class="d-flex mb-3">
    <h1 class="mb-0">Categories</h1>
    <a href="<?= base_url()?>admin/product/create" class="btn btn-primary ms-auto" style="align-content:center;">
      <i class="fas fa-plus me-1"></i>
      Create Category
    </a>
  </div>
  <div class="card">
    <div class="card-body">
      <div class="table-responsive">
        <table class="table">
          <thead>
            <tr>
              <th>icon</th>
              <th>Nama</th>
              <th width="10%">Action</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($data as $cat) : ?>
              <?php $icon = $cat->icon ?>
              <tr>
                <td width="15%"><img src="<?= base_url('dist/img/uploads/categories/' . ($icon == '' ? 'default_image.png' : $icon)) ?>" style="width:77px;height:65px;" alt=""></td>
                <td><h5><?= $cat->category ?></h5></td>
                <td>
                  <button class="btn btn-sm" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-ellipsis-vertical"></i>
                  </button>
                  <div class="dropdown-menu">
                    <a href="" class="dropdown-item">
                      <span class="iconify mr-2" data-icon="ci:show"></span>Lihat Detail</a>
                    <a class="dropdown-item" href="<?= base_url('admin/categories/edit/' . $cat->id) ?>">
                      <span class="iconify mr-2" data-icon="material-symbols:edit-square-outline-rounded"></span>Edit</a>
                    <button class="dropdown-item" data-bs-toggle="modal" data-target="#hapusModal" onclick="hapus(1)">
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