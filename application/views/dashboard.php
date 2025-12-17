<main role="main" class="main-content" style="margin-top: 64px;">

  <div class="container-fluid">
    <div class="row mb-3">
      <div class="col-12">
        <h4 class="mb-0">Dashboard</h4>
        <small class="text-muted">Ringkasan cepat performa toko (data dummy)</small>
      </div>
    </div>

    <div class="row g-3 mb-4">
      <div class="col-sm-12 col-md-9 px-0">
        <div class="row mx-0 g-3">
          <div class="col-xl-3 col-6">
            <div class="card p-3">
              <div class="d-flex align-items-center">
                <div class="me-3 bg-light rounded-circle d-flex align-items-center justify-content-center" style="width:48px;height:48px">📦</div>
                <div>
                  <div class="text-muted small">Jumlah Produk</div>
                  <div class="fw-bold fs-5"><?= $total_product ?></div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-xl-3 col-6">
            <div class="card p-3">
              <div class="d-flex align-items-center">
                <div class="me-3 bg-light rounded-circle d-flex align-items-center justify-content-center" style="width:48px;height:48px">🗂️</div>
                <div>
                  <div class="text-muted small">Jumlah Kategori</div>
                  <div class="fw-bold fs-5"><?= $total_category ?></div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-xl-3 col-6">
            <div class="card p-3">
              <div class="d-flex align-items-center">
                <div class="me-3 bg-light rounded-circle d-flex align-items-center justify-content-center" style="width:48px;height:48px">🧾</div>
                <div>
                  <div class="text-muted small">Produk Di Keranjang</div>
                  <div class="fw-bold fs-5"><?= $total_oncart ?></div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-xl-3 col-6">
            <div class="card p-3">
              <div class="d-flex align-items-center">
                <div class="me-3 bg-light rounded-circle d-flex align-items-center justify-content-center" style="width:48px;height:48px">🧾</div>
                <div>
                  <div class="text-muted small">Transaksi Hari Ini</div>
                  <div class="fw-bold fs-5"><?= $total_orders ?></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-sm-12 col-md-3">
        <div class="card p-3">
          <div class="d-flex align-items-center">
            <div class="me-3 bg-light rounded-circle d-flex align-items-center justify-content-center" style="width:48px;height:48px">💰</div>
            <div>
              <div class="text-muted small">Total Hari Ini</div>
              <div class="fw-bold fs-5 text-success" id="card-revenue">Rp. <?= number_format($total_income, 0, ',', '.') ?></div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="row mb-3">
      <div class="col-lg-7 mb-3">
        <div class="card p-3 h-100">
          <div class="d-flex justify-content-between mb-2">
            <div>
              <div class="fw-bold">Statistik Penjualan</div>
              <small class="text-muted">7 hari terakhir (data dummy)</small>
            </div>
          </div>
          <canvas id="chart-daily" style="height:260px"></canvas>
        </div>
      </div>
      <div class="col-lg-5 mb-3">
        <div class="card p-3 h-100">
          <div class="d-flex justify-content-between mb-2">
            <div>
              <div class="fw-bold">Pesanan Dibatalkan</div>
              <small class="text-muted">1 Minggu (unpaid/missing)</small>
            </div>
          </div>
          <canvas id="chart-monthly" style="height:260px"></canvas>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-12">
        <div class="card p-3">
          <div class="fw-bold mb-2">Transaksi Terbaru</div>
          <div class="table-responsive">
            <table class="table table-sm table-striped mb-0">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Invoice</th>
                  <th>Customer</th>
                  <th>Items</th>
                  <th>Total</th>
                  <th>Status</th>
                </tr>
              </thead>
              <tbody id="recent-transactions">
                <?php foreach ($orders_today as $key => $order) : ?>
                  <tr>
                    <td><?= $key + 1 ?></td>
                    <td><?= 'inv001' ?></td>
                    <td><?= $order['customer_id'] ?></td>
                    <td><?= 'item 1' ?></td>
                    <td><?= $order['cost_price'] ?></td>
                    <td><?= $order['status'] ?></td>
                  </tr>
                <?php endforeach; ?>
                <!-- rows inserted by JS -->
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>

<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  document.addEventListener("DOMContentLoaded", function() {

    // Dummy data generation
    const dummy = {
      // smaller sample numbers for a concise dashboard
      products: 124,
      categories: 8,
      transactionsToday: 7,
      revenueToday: 250,
      daily: (function() {
        const labels = [];
        const data = [];
        // last 5 days
        for (let i = 4; i >= 0; i--) {
          const d = new Date();
          d.setDate(d.getDate() - i);
          // labels.push(d.toLocaleDateString());
          // data.push(Math.floor(Math.random() * 800) + 200);
        }
        return {
          labels,
          data
        };
      })(),
      monthly: (function() {
        const labels = [];
        const data = [];
        const monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
        const now = new Date();
        // last 7 days
        for (let i = 6; i >= 0; i--) {
          const d = new Date(now.getFullYear(), now.getMonth(), now.getDate() - i);
          const m = new Date(now.getFullYear(), now.getMonth() - i, 1);

          labels.push(d.getDate() + ' ' + monthNames[d.getMonth()]);

          data.push(Math.floor(Math.random() * 800) + 50);
        }
        return {
          labels,
          data
        };
      })(),
      recent: (function() {
        const rows = [];
        // 4 recent transactions
        for (let i = 1; i <= 4; i++) {
          rows.push({
            invoice: 'INV' + (1000 + i),
            customer: 'Customer ' + i,
            items: Math.floor(Math.random() * 3) + 1,
            total: (Math.floor(Math.random() * 150) + 20),
            status: ['Pending', 'Paid', 'Shipped', 'Cancelled'][Math.floor(Math.random() * 4)]
          });
        }
        return rows;
      })()
    };

    // daily chart
    const ctxDaily = document.getElementById('chart-daily').getContext('2d');

    var chart_daily = new Chart(ctxDaily, {
      type: 'line',
      data: {
        labels: dummy.daily.labels,
        datasets: [{
          label: 'Pendapatan (Rp)',
          data: dummy.daily.data,
          borderColor: '#198754',
          backgroundColor: 'rgba(25,135,84,0.15)',
          tension: 0.3,
          fill: true
        }]
      },
      options: {
        responsive: true,
        // maintainAspectRatio: false
      }
    });

    // monthly chart
    const ctxMonthly = document.getElementById('chart-monthly').getContext('2d');
    new Chart(ctxMonthly, {
      type: 'bar',
      data: {
        labels: dummy.monthly.labels,
        datasets: [{
          label: 'Produk Batal Dipesan',
          data: dummy.monthly.data,
          backgroundColor: 'rgba(13,110,253,0.8)'
        }]
      },
      options: {
        responsive: true,
        // maintainAspectRatio: false
      }
    });

    $.ajax({
      url: '<?= base_url("admin/dashboard/get_weekly_orders") ?>',
      type: 'GET',
      dataType: 'json',
      success: function(response) {
        if (response.success) {
          dummy.daily.labels = response.labels;
          dummy.daily.data = response.data;
          updateChart(chart_daily, response);
        }
      },
      error: function() {
        console.error('Failed to fetch weekly orders data');
      }
    });

    function updateChart(chart, newData) {
      // Assuming newData has properties like 'labels' and 'values'
      console.log(chart);
      chart.data.labels = newData.labels;
      chart.data.datasets[0].data = newData.data; // Adjust index if multiple datasets
      // If you have multiple datasets, you might loop through them
      /*
      newData.datasets.forEach((dataset, index) => {
          chart.data.datasets[index].data = dataset.data;
      });
      */

      chart.update(); // Re-render the chart with the new data
    }
  });
</script>