<main role="main" class="main-content" style="margin-top: 64px;">
  <div class="container-fluid px-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
      <div>
        <h4 class="mb-0 fw-bold">Kelola Pengiriman</h4>
        <p class="text-muted mb-0">Order #<?= $order['order_id'] ?></p>
      </div>
      <a href="<?= base_url('admin/orders') ?>" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-2"></i>Kembali ke Daftar Pesanan
      </a>
    </div>

    <!-- Flash Messages -->
    <?php if ($this->session->flashdata('success')) : ?>
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i>
        <?= $this->session->flashdata('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    <?php endif; ?>

    <?php if ($this->session->flashdata('error')) : ?>
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-triangle me-2"></i>
        <?= $this->session->flashdata('error') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    <?php endif; ?>

    <div class="row">
      <!-- Order Information -->
      <div class="col-lg-8 mb-4">
        <div class="card shadow-sm">
          <div class="card-header bg-primary text-white">
            <h5 class="card-title mb-0 text-light">
              <i class="fas fa-shopping-cart me-2"></i>Informasi Pesanan
            </h5>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-md-6">
                <table class="table table-borderless">
                  <tr>
                    <td class="fw-bold text-muted" width="40%">Order ID</td>
                    <td width="10%">:</td>
                    <td class="fw-bold">#<?= $order['order_id'] ?></td>
                  </tr>
                  <tr>
                    <td class="fw-bold text-muted">Tanggal Order</td>
                    <td>:</td>
                    <td><?= date('d F Y H:i', strtotime($order['created_at'])) ?></td>
                  </tr>
                  <tr>
                    <td class="fw-bold text-muted">Status Pesanan</td>
                    <td>:</td>
                    <td>
                      <span class="badge bg-<?= $order['status'] == 'completed' ? 'success' : ($order['status'] == 'paid' ? 'info' : 'warning') ?>">
                        <?= ucfirst($order['status']) ?>
                      </span>
                    </td>
                  </tr>
                  <tr>
                    <td class="fw-bold text-muted">Total Harga</td>
                    <td>:</td>
                    <td class="fw-bold text-success fs-5">Rp <?= number_format($order['cost_price'], 0, ',', '.') ?></td>
                  </tr>
                </table>
              </div>
              <div class="col-md-6">
                <table class="table table-borderless">
                  <tr>
                    <td class="fw-bold text-muted" width="40%">Customer</td>
                    <td width="10%">:</td>
                    <td class="fw-bold"><?= $order['customer_name'] ?></td>
                  </tr>
                  <tr>
                    <td class="fw-bold text-muted">Email</td>
                    <td>:</td>
                    <td><?= $order['customer_email'] ?? '-' ?></td>
                  </tr>
                  <tr>
                    <td class="fw-bold text-muted">Status Pengiriman</td>
                    <td>:</td>
                    <td>
                      <span class="badge bg-<?= isset($order['shipping_status']) && $order['shipping_status'] == 'arrived' ? 'success' : (isset($order['shipping_status']) && $order['shipping_status'] == 'sending' ? 'info' : 'secondary') ?>">
                        <?= isset($order['shipping_status']) ? ucfirst(str_replace('_', ' ', $order['shipping_status'])) : 'Belum dikirim' ?>
                      </span>
                    </td>
                  </tr>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Shipping Status Update -->
      <div class="col-lg-4 mb-4">
        <div class="card shadow-sm">
          <div class="card-header bg-info text-white">
            <h5 class="card-title mb-0 text-light">
              <i class="fas fa-truck me-2"></i>Update Status Pengiriman
            </h5>
          </div>
          <div class="card-body">
            <form method="post" action="<?= base_url('admin/orders/manage_shipping/' . $order['order_id']) ?>">
              <div class="mb-3">
                <label for="status" class="form-label fw-bold">Status Pengiriman</label>
                <select class="form-select" id="status" name="status" required>
                  <option value="">Pilih Status</option>
                  <option value="processing" <?= (isset($order['status']) && $order['status'] == 'processing') ? 'selected' : '' ?>>
                    Sedang Dikemas
                  </option>
                  <option value="need to send" <?= (isset($order['status']) && $order['status'] == 'need to send') ? 'selected' : '' ?>>
                    Perlu dikirim
                  </option>
                  <option value="sending" <?= (isset($order['status']) && $order['status'] == 'sending') ? 'selected' : '' ?>>
                    Sedang dikirim
                  </option>
                  <option value="shipped" <?= (isset($order['status']) && $order['status'] == 'shipped') ? 'selected' : '' ?>>
                    Sudah sampai
                  </option>
                  <option value="completed" <?= (isset($order['status']) && $order['status'] == 'completed') ? 'selected' : '' ?>>
                    Pesanan Selesai
                  </option>
                  <option value="expired" <?= (isset($order['status']) && $order['status'] == 'expired') ? 'selected' : '' ?>>
                    Pesanan kedaluwarsa
                  </option>
                </select>
                <div class="form-text">
                  Pilih status pengiriman yang sesuai untuk pesanan ini.
                </div>
              </div>

              <div class="d-grid">
                <button type="submit" class="btn btn-primary">
                  <i class="fas fa-save me-2"></i>Update Status
                </button>
              </div>
            </form>
          </div>
        </div>

        <!-- Status Information -->
        <div class="card shadow-sm mt-3">
          <div class="card-header bg-light">
            <h6 class="card-title mb-0">
              <i class="fas fa-info-circle me-2"></i>Informasi Status
            </h6>
          </div>
          <div class="card-body">
            <div class="mb-2">
              <span class="badge bg-warning me-2">Sedang Dikemas</span>
              <small class="text-muted">Pesanan sedang diproses dan dikemas</small>
            </div>
            <div class="mb-2">
              <span class="badge bg-danger me-2">Perlu dikirim</span>
              <small class="text-muted">Pesanan perlu di ambil kurir</small>
            </div>
            <div class="mb-2">
              <span class="badge bg-info me-2">Sedang dikirim</span>
              <small class="text-muted">Pesanan sedang dalam perjalanan</small>
            </div>
            <div class="mb-2">
              <span class="badge bg-success me-2">Sudah sampai</span>
              <small class="text-muted">Pesanan telah diterima customer</small>
            </div>
            <div class="mb-2">
              <span class="badge bg-success me-2">Pesanan Selesai</span>
              <small class="text-muted">Pesanan telah selesai</small>
            </div>
            <div class="mb-0">
              <span class="badge bg-danger me-2">Pesanan kedaluwarsa</span>
              <small class="text-muted">Pesanan telah kedaluwarsa</small>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>

<script>
  document.addEventListener("DOMContentLoaded", function() {
    // Auto-hide alerts after 5 seconds
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(function(alert) {
      setTimeout(function() {
        const bsAlert = new bootstrap.Alert(alert);
        bsAlert.close();
      }, 5000);
    });
  });
</script>
