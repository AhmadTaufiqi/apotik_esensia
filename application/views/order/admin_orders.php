<main role="main" class="main-content" style="margin-top: 64px;">
  <div class="d-flex mb-3">
    <h2 class="mb-0"><?= $title ?></h2>
  </div>

  <div class="card">
    <div class="card-body">
      <div class="table-responsive">
        <table class="table">
          <thead>
            <tr>
              <th>Customer</th>
              <th>Quantity</th>
              <th>Status Order</th>
              <th>Date Created</th>
              <th width="10%">Action</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($data as $order) : ?>
              <tr>
                <td><?= $order->created_by ?></td>
                <td><?= $order->qty ?></td>
                <td><?= $order->status ?></td>
                <td><?= $order->created_at ?></td>
                <td>
                  <button class="btn btn-sm" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-ellipsis-vertical"></i>
                  </button>
                  <div class="dropdown-menu">
                    <a href="" class="dropdown-item">
                      <span class="iconify mr-2" data-icon="ci:show"></span>Lihat Detail</a>
                    <a class="dropdown-item" href="<?= base_url('admin/product/edit/' . $order->id) ?>">
                      <span class="iconify mr-2" data-icon="material-symbols:edit-square-outline-rounded"></span>Edit</a>
                    <button class="dropdown-item" data-bs-toggle="modal" data-target="#hapusModal" onclick="hapus(<?= $order->id ?>)">
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