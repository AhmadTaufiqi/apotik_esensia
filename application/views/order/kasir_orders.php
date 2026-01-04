<main role="main" class="main-content" style="margin-top: 64px;">
  <div class="d-flex mb-3">
    <h4 class="mb-0"><?= $title ?></h4>
  </div>

  <!-- Filter Form -->
  <div class="card mb-3">
    <div class="card-body">
      <form method="get" action="<?= base_url('admin/orders') ?>" class="row mx-0 g-3">
        <!-- Search by name or order ID -->
        <div class="col-md-3 px-1">
          <label for="search" class="form-label">Cari Nama / Order ID</label>
          <input type="text" class="form-control" id="search" name="search" value="<?= htmlspecialchars($filters['search'] ?? '') ?>" placeholder="Cari...">
        </div>

        <!-- Date Range -->
        <div class="col-md-3 px-1">
          <label for="date_range" class="form-label">Rentang Tanggal</label>
          <input type="text" class="form-control" id="date_range" placeholder="Pilih rentang tanggal">
          <input type="hidden" id="date_from" name="date_from" value="<?= htmlspecialchars($filters['date_from'] ?? '') ?>">
          <input type="hidden" id="date_to" name="date_to" value="<?= htmlspecialchars($filters['date_to'] ?? '') ?>">
        </div>

        <!-- Customer Filter -->
        <div class="col-md-3 px-1">
          <label for="customer_id" class="form-label">Customer</label>
          <select class="form-select form-control" id="customer_id" name="customer_id">
            <option value="">Semua Customer</option>
            <?php if (!empty($customers)) : ?>
              <?php foreach ($customers as $cust) : ?>
                <option value="<?= $cust->id ?>" <?= (isset($filters['customer_id']) && $filters['customer_id'] == $cust->id) ? 'selected' : '' ?>>
                  <?= htmlspecialchars($cust->name) ?>
                </option>
              <?php endforeach; ?>
            <?php endif; ?>
          </select>
        </div>

        <!-- Status Filter -->
        <div class="col-md-2 px-1">
          <label for="status" class="form-label">Status Pesanan</label>
          <select class="form-select form-control" id="status" name="status">
            <option value="">Semua Status</option>
            <option value="unpaid" <?= (isset($filters['status']) && $filters['status'] === 'unpaid') ? 'selected' : '' ?>>Belum Dibayar</option>
            <option value="paid" <?= (isset($filters['status']) && $filters['status'] === 'unpaid') ? 'selected' : '' ?>>Sudah Dibayar</option>
            <option value="payment accepted" <?= (isset($filters['status']) && $filters['status'] === 'unpaid') ? 'selected' : '' ?>>Pembayaran Diterima</option>
            <option value="completed" <?= (isset($filters['status']) && $filters['status'] === 'completed') ? 'selected' : '' ?>>Completed</option>
          </select>
        </div>

        <!-- Buttons -->
        <div class="col-12 d-flex gap-2 px-1">
          <button type="submit" class="btn btn-primary">Filter</button>
          <a href="<?= base_url('admin/orders') ?>" class="btn btn-secondary text-light">Reset</a>
        </div>
      </form>
    </div>
  </div>

  <div class="card">
    <div class="card-body">
      <div class="">
        <table class="table datatable">
          <thead>
            <tr>
              <th>Customer</th>
              <th colspan="2">Status pesanan</th>
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
                <td>
                  <span class="badge bg-<?= isset($order['shipping_status']) && $order['shipping_status'] == 'arrived' ? 'success' : (isset($order['shipping_status']) && $order['shipping_status'] == 'sending' ? 'info' : 'secondary') ?>">
                    <?= isset($order['shipping_status']) ? ucfirst(str_replace('_', ' ', $order['shipping_status'])) : 'Not shipped' ?>
                  </span>
                </td>
                <td><?= $order['created_at'] ?></td>
                <td>Rp. <?= number_format($order['cost_price'], 0, ',', '.') ?></td>
                <td>
                  <button class="btn btn-sm" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-ellipsis-vertical"></i>
                  </button>
                  <div class="dropdown-menu" style="width:240px">
                    <a href="<?= base_url('admin/orders/detail/') . $order['order_id'] ?>" class="dropdown-item">
                      <span class="iconify mr-2" data-icon="ci:show"></span>Lihat Detail</a>

                    <?php if ($order['status'] == 'paid') : ?>
                      <a href="<?= base_url('kasir/orders/reviewPayment/') . $order['order_id'] ?>" class="dropdown-item">
                        <div class="d-flex">
                          <span class="fas fa-check me-2"></span>
                          <span class="text-wrap">
                            Review & konfirmasi pembayaran
                          </span>
                        </div>
                      </a>
                    <?php endif; ?>

                    <?php if ($order['status'] == 'payment accepted') : ?>
                      <a href="<?= base_url('admin/orders/manage_shipping/') . $order['order_id'] ?>" class="dropdown-item">
                        <span class="fas fa-motorcycle me-2"></span>Kelola Pengiriman</a>
                    <?php endif; ?>
                    <button class="dropdown-item" data-bs-toggle="modal" data-target="#hapusModal" onclick="hapus(<?= $order['order_id'] ?>)">
                      <span class="fas fa-trash me-2"></span>Hapus</button>
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
  document.addEventListener("DOMContentLoaded", function() {

    // Initialize DateRangePicker
    const dateFromVal = '<?= htmlspecialchars($filters['date_from'] ?? '') ?>';
    const dateToVal = '<?= htmlspecialchars($filters['date_to'] ?? '') ?>';
    let startDate = moment().subtract(29, 'days');
    let endDate = moment();

    // If filter values exist, use them
    if (dateFromVal && dateToVal) {
      startDate = moment(dateFromVal, 'YYYY-MM-DD');
      endDate = moment(dateToVal, 'YYYY-MM-DD');
    }

    $('#date_range').daterangepicker({
      startDate: startDate,
      endDate: endDate,
      locale: {
        format: 'DD/MM/YYYY',
        separator: ' - ',
        applyLabel: 'Terapkan',
        cancelLabel: 'Batal',
        fromLabel: 'Dari',
        toLabel: 'Sampai',
        customRangeLabel: 'Custom',
        daysOfWeek: ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'],
        monthNames: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember']
      },
      ranges: {
        'Hari Ini': [moment(), moment()],
        'Kemarin': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
        '7 Hari Terakhir': [moment().subtract(6, 'days'), moment()],
        '30 Hari Terakhir': [moment().subtract(29, 'days'), moment()],
        'Bulan Ini': [moment().startOf('month'), moment().endOf('month')],
        'Bulan Lalu': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
      }
    }, function(start, end) {
      // Update hidden fields with selected date range
      $('#date_from').val(start.format('YYYY-MM-DD'));
      $('#date_to').val(end.format('YYYY-MM-DD'));
    });
  });

  (function() {
    const populateUrl = '<?= base_url("kasir/orders/populateOrderStatus") ?>';

    // For each status cell, request the formatted HTML and replace the cell content
    document.querySelectorAll('td.order_status').forEach(function(td) {
      const raw = td.textContent || td.innerText || '';
      const status = raw.trim();
      if (!status) return;

      // AJAX GET request
      fetch(populateUrl + '?status=' + encodeURIComponent(status))
        .then(function(res) {
          return res.text();
        })
        .then(function(html) {
          // replace the cell innerHTML with returned HTML
          td.innerHTML = html;
        })
        .catch(function(err) {
          console.error('Error fetching status HTML', err);
        });
    });
  })();
</script>