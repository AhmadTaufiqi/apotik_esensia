<main role="main" class="main-content" style="margin-top: 64px;">
  <div class="d-flex mb-3">
    <h4 class="mb-0"><?= $title ?></h4>
    <a href="<?= base_url() ?>admin/product/create" class="btn btn-primary ms-auto text-light" style="align-content:center;">
      <i class="fas fa-plus me-1"></i>
      Tambah Produk
    </a>
  </div>
  <?= $this->session->flashdata('message') ?>
  <div class="card">
    <div class="card-body">
      <div class="table-responsive">
        <table class="table">
          <thead>
            <tr>
              <th>Sku</th>
              <th>Nama</th>
              <th>Harga Rp.</th>
              <th>Stok</th>
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
                <td><?= number_format(empty($prod->price) ? 0 : $prod->price, 0, ',', '.') ?></td>
                <td><?= $prod->stock ?></td>
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
                    <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#hapusModal" onclick="$('#hapus_id').val('<?= $prod->id ?>')">
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

<!-- Modal Hapus-->
<div class="modal fade" id="hapusModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form action="<?= base_url()?>/admin/product/delete" method="POST">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Hapus Produk</h5>
          <button class="close" type="button" data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <input type="text" name="id" id="hapus_id">
        <div class="modal-body">Apakah Anda yakin ingin menghapus produk ini?</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Batal</button>
          <button type="submit" id="btn-hapus" class="btn btn-primary" href="#">Hapus</button>
        </div>
      </div>
    </form>
  </div>
</div>