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
              <th>Customer</th>
              <th>Status pesanan</th>
              <th>Tanggal</th>
              <th>Nominal</th>
              <th width="10%">Action</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($data as $order) : ?>
              <tr>
                <td><?= $order['name'] ?></td>
                <td class="order_status"><?= $order['status'] ?></td>
                <td><?= $order['created_at'] ?></td>
                <td>Rp. <?= number_format($order['cost_price'], 0, ',', '.') ?></td>
                <td>
                  <button class="btn btn-sm" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-ellipsis-vertical"></i>
                  </button>
                  <div class="dropdown-menu">
                    <a href="" class="dropdown-item">
                      <span class="iconify mr-2" data-icon="ci:show"></span>Lihat Detail</a>
                    <a class="dropdown-item" href="<?= base_url('admin/product/edit/' . $order['id']) ?>">
                      <span class="iconify mr-2" data-icon="material-symbols:edit-square-outline-rounded"></span>Edit</a>
                    <button class="dropdown-item" data-bs-toggle="modal" data-target="#hapusModal" onclick="hapus(<?= $order['id'] ?>)">
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

<script>
  (function(){
    const populateUrl = '<?= base_url("admin/orders/populateOrderStatus") ?>';

    // For each status cell, request the formatted HTML and replace the cell content
    document.querySelectorAll('td.order_status').forEach(function(td){
      const raw = td.textContent || td.innerText || '';
      const status = raw.trim();
      if (!status) return;

      // AJAX GET request
      fetch(populateUrl + '?status=' + encodeURIComponent(status))
        .then(function(res){ return res.text(); })
        .then(function(html){
          // replace the cell innerHTML with returned HTML
          td.innerHTML = html;
        })
        .catch(function(err){
          console.error('Error fetching status HTML', err);
        });
    });
  })();
</script>