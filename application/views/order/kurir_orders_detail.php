<main role="main" class="main-content" style="margin-top: 64px;">
  <div>
    <div class="row">
      <!-- Bukti Pembayaran -->
      <div class="col-md-6 mb-4">
        <div class="card">
          <div class="card-body text-center">
            <div class="card-header p-0 pb-2 mb-3 text-left">
              <h5 class="card-title mb-0">Bukti Pembayaran</h5>
            </div>
            <?php if (!empty($invoice['proof_of_payment'])) : ?>
              <img src="<?= base_url('dist/img/uploads/bukti_transfer/' . $invoice['proof_of_payment']) ?>" alt="Bukti Pembayaran" class="img-fluid rounded" style="max-height: 300px;">
            <?php else : ?>
              <div class="text-muted">
                <i class="fas fa-image fa-3x mb-3"></i>
                <p>Bukti pembayaran belum diupload</p>
              </div>
            <?php endif; ?>
          </div>
        </div>
      </div>

      <!-- Data Invoice -->
      <div class="col-md-6 mb-4">
        <div class="card">
          <div class="card-body">
            <div class="card-header p-0 pb-2 mb-3">
              <h5 class="card-title mb-0">Data Invoice</h5>
            </div>
            <div class="mb-2">
              <div class="row">
                <div class="col">
                  <p class="mb-2"><strong>Total Pembayaran:</strong></p>
                </div>
                <div class="col">
                  <p class="mb-2">Rp <?= number_format($invoice['order_price'] ?? 0, 0, ',', '.') ?></p>
                </div>
              </div>
              <div class="row">
                <div class="col">
                  <p class="mb-2"><strong>Metode Pembayaran:</strong></p>
                </div>
                <div class="col">
                  <p class="mb-2"><?= $invoice['payment_method'] ?? 'N/A' ?></p>
                </div>
              </div>
              <div class="row">
                <div class="col">
                  <p class="mb-2"><strong>Tanggal Dibuat:</strong></p>
                </div>
                <div class="col">
                  <p class="mb-2">
                    <?= date('d-m-Y H:i', strtotime($invoice['created_at'] ?? '')) ?>
                  </p>
                </div>
              </div>
            </div>
            <?php if (!empty($invoice['expired_at'])) : ?>
              <span><strong>Batas Waktu:</strong> <?= date('d-m-Y H:i', strtotime($invoice['expired_at'])) ?></span>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>

    <!-- Data Order -->
    <div class="card mb-4">
      <div class="card-body">
        <div class="card-header p-0 pb-2 mb-3">
          <h5 class="card-title mb-0">Data Order</h5>
        </div>
        <div class="row">
          <div class="col-md-6">
            <h6>Informasi Customer</h6>
            <p><strong>Nama:</strong> <?= $order['customer_name'] ?? 'N/A' ?></p>
            <p><strong>Email:</strong> <?= $order['customer_email'] ?? 'N/A' ?></p>
            <p><strong>Telepon:</strong> <?= $order['customer_phone'] ?? 'N/A' ?></p>
            <p><strong>Alamat:</strong> <?= $address['kota'] ?? 'N/A' ?></p>
            <span><strong>Maps:</strong> <a href="https://www.google.com/maps/search/?api=1&query=<?= $address['long']?>,<?= $address['lat'] ?>" target="_blank">Telusuri alamat</a></span>
          </div>
          <div class="col-md-6">
            <h6>Informasi Order</h6>
            <p><strong>Status Order:</strong>
              <span class="badge bg-secondary"><?= $order['status'] ?? 'N/A' ?></span>
            </p>
            <p><strong>Tanggal Order:</strong> <?= date('d-m-Y H:i', strtotime($order['created_at'] ?? '')) ?></p>
            <p><strong>Total Harga:</strong> Rp <?= number_format($order['cost_price'] ?? 0, 0, ',', '.') ?></p>
          </div>
        </div>
      </div>
    </div>

    <!-- Produk dalam Order -->
    <div class="card">
      <div class="card-body">
        <div class="card-header p-0 pb-3">
          <h5 class="card-title mb-0">Produk dalam Order</h5>
        </div>
        <div class="table-responsive">
          <table class="table table-striped">
            <thead>
              <tr>
                <th>Produk</th>
                <th>Jumlah</th>
                <th>Harga</th>
                <th>Total</th>
              </tr>
            </thead>
            <tbody>
              <?php if (!empty($order_products)) : ?>
                <?php foreach ($order_products as $product) : ?>
                  <tr>
                    <td>
                      <div class="d-flex align-items-center">
                        <?php if (!empty($product['image'])) : ?>
                          <img src="<?= base_url('dist/img/uploads/products/' . $product['image']) ?>" alt="<?= $product['name'] ?>" class="rounded me-2" style="width: 50px; height: 50px; object-fit: cover;">
                        <?php endif; ?>
                        <div>
                          <strong><?= $product['name'] ?? 'N/A' ?></strong>
                          <br><small class="text-muted">SKU: <?= $product['sku'] ?? 'N/A' ?></small>
                        </div>
                      </div>
                    </td>
                    <td><?= $product['qty'] ?? 0 ?></td>
                    <td>Rp <?= number_format($product['price'] ?? 0, 0, ',', '.') ?></td>
                    <td>Rp <?= number_format(($product['qty'] ?? 0) * ($product['price'] ?? 0), 0, ',', '.') ?></td>
                  </tr>
                <?php endforeach; ?>
              <?php else : ?>
                <tr>
                  <td colspan="4" class="text-center text-muted">Tidak ada produk dalam order ini</td>
                </tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <!-- Tombol Aksi -->
    <div class="d-flex justify-content-between mt-4">
      <a href="<?= base_url('kasir/orders') ?>" class="btn btn-secondary text-light">Kembali ke Daftar Order</a>
      <div>
        <?php if (($invoice['is_paid'] ?? 0) == 0) : ?>
          <button class="btn btn-success text-light me-2" onclick="confirmPayment(<?= $order['id'] ?? 0 ?>)">Konfirmasi Pembayaran</button>
        <?php endif; ?>
        <button class="btn btn-danger" onclick="rejectPayment(<?= $order['id'] ?? 0 ?>)">Tolak Pembayaran</button>
      </div>
    </div>
  </div>
</main>

<script>
  function confirmPayment(orderId) {
    if (confirm('Apakah Anda yakin ingin mengkonfirmasi pembayaran ini?')) {
      // Implement confirmation logic here
      window.location.href = '<?= base_url('kasir/orders/confirmPayment/') ?>' + orderId;
    }
  }

  function rejectPayment(orderId) {
    if (confirm('Apakah Anda yakin ingin menolak pembayaran ini?')) {
      // Implement rejection logic here
      window.location.href = '<?= base_url('kasir/orders/reject_payment/') ?>' + orderId;
    }
  }
</script>