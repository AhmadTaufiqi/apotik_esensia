<style>
  .tab-pane ol {
    padding-left: 1.2rem;
    margin-bottom: 0;
  }

  .tab-pane ol li {
    margin-bottom: 8px;
  }

  .nav-link {
    color: black;
  }
</style>

<div class="container p-2">

  <!-- Status Pembayaran -->
  <div class="card p-3 text-center mb-2">
    <?php if ($order['status'] == 'unpaid') : ?>
      <div class="fw-bold text-success mb-1">Menunggu Pembayaran</div>
      <div class="text-muted mb-1">Bayar sebelum</div>
      <!-- Due datetime is stored in data-due as ISO 8601 with timezone. Update this value server-side if needed. -->
      <div id="due_countdown" class="fw-bold text-danger" data-due="<?= date('Y-m-d H:i', strtotime($invoice['expired_at'])) ?>"><?= date('d-m-y', strtotime($invoice['expired_at'])) ?></div>
    <?php else : ?>
      <h4 class="fw-bold text-success mb-1">Pembayaran Sukses</h4>
      <div class="fw-bold mb-1">Menunggu Konfirmasi</div>
    <?php endif; ?>
  </div>

  <?php
  $payment_image = 'default.png';
  $payment_method = strtolower($method['method_name']);

  if (strpos($payment_method, 'bri') !== false) {
    $payment_image = 'bri.png';
  } elseif (strpos($payment_method, 'bca') !== false) {
    $payment_image = 'bca.png';
  } elseif (strpos($payment_method, 'bni') !== false) {
    $payment_image = 'bni.png';
  } elseif (strpos($payment_method, 'mandiri') !== false) {
    $payment_image = 'mandiri.png';
  } elseif (strpos($payment_method, 'ovo') !== false) {
    $payment_image = 'ovo.png';
  } elseif (strpos($payment_method, 'gopay') !== false) {
    $payment_image = 'gopay.png';
  }

  $image = $method['image'];
  $payment_method_img = $image ?? base_url() . 'dist/img/uploads/bukti_transfer/default_image.png';
  ?>

  <?php if ($method['method_name'] != 'Qris') : ?>
    <!-- Metode Pembayaran -->
    <div class="card p-3 mb-2">
      <div class="row">
        <div class="col mb-2">
          <div class="fw-bold mb-2">Metode Pembayaran</div>
          <div class="d-flex align-items-center mb-2">
            <img src="<?= base_url('dist/img/payment_methods/') . strtolower($method['bank_name']) ?>.png" width="45" class="me-2 rounded-1" alt="<?= $invoice['payment_method'] ?>">
            <div>
              <div class="fw-semibold"><?= $invoice['payment_method'] ?></div>
              <div class="d-flex align-items-center mt-1">
                <span class="va-number me-2" style="font-weight: 500;"><?= $method['payment_id'] ?></span>
                <button class="btn btn-sm btn-success py-0" onclick="copyVA()">Salin</button>
              </div>
            </div>
          </div>
        </div>
        <div class="d-flex">
          <div class="col-md-6 col-12">
            <!-- Petunjuk Pembayaran -->
            <div class="card p-3 mb-2">
              <div class="fw-bold mb-3">Petunjuk Pembayaran</div>

              <ul class="nav nav-tabs nav-fill small" id="paymentTab" role="tablist">
                <?php if (strpos($payment_method, 'qris') === false) : ?>
                  <li class="nav-item">
                    <button class="nav-link active" id="m-banking-tab" data-bs-toggle="tab" data-bs-target="#m-banking" type="button">M-Banking</button>
                  </li>
                  <li class="nav-item">
                    <button class="nav-link" id="atm-tab" data-bs-toggle="tab" data-bs-target="#atm" type="button">ATM</button>
                  </li>
                <?php endif; ?>
              </ul>

              <div class="tab-content mt-3 small" id="paymentTabContent">
                <div class="tab-pane fade show active" id="m-banking">
                  <ol>
                    <?php if (strpos($payment_method, 'bca') !== false) : ?>
                      <li>Buka aplikasi <strong>BCA Mobile</strong>.</li>
                      <li>Pilih menu <strong>m-BCA</strong>, masukkan PIN m-BCA.</li>
                      <li>Pilih <strong>m-Transfer</strong> > <strong>BCA Virtual Account</strong>.</li>
                      <li>Masukkan nomor <strong><?= $method['payment_id'] ?></strong> dan tekan <strong>OK</strong>.</li>
                      <li>Periksa detail pembayaran lalu tekan <strong>Ya</strong>.</li>
                    <?php elseif (strpos($payment_method, 'bri') !== false) : ?>
                      <li>Buka aplikasi <strong>BRImo</strong>.</li>
                      <li>Pilih menu <strong>Transfer</strong>.</li>
                      <li>Pilih <strong>BRIVA</strong>.</li>
                      <li>Masukkan nomor <strong><?= $method['payment_id'] ?></strong> dan tekan <strong>OK</strong>.</li>
                      <li>Periksa detail pembayaran lalu tekan <strong>Ya</strong>.</li>
                    <?php elseif (strpos($payment_method, 'bni') !== false) : ?>
                      <li>Buka aplikasi <strong>BNI Mobile Banking</strong>.</li>
                      <li>Pilih menu <strong>Transfer</strong>.</li>
                      <li>Pilih <strong>Virtual Account Billing</strong>.</li>
                      <li>Masukkan nomor <strong><?= $method['payment_id'] ?></strong> dan tekan <strong>OK</strong>.</li>
                      <li>Periksa detail pembayaran lalu tekan <strong>Ya</strong>.</li>
                    <?php elseif (strpos($payment_method, 'mandiri') !== false) : ?>
                      <li>Buka aplikasi <strong>M-banking</strong>.</li>
                      <li>Pilih menu <strong>Transfer</strong>.</li>
                      <li>Pilih <strong>Multipayment</strong>.</li>
                      <li>Masukkan nomor <strong><?= $method['payment_id'] ?></strong>.</li>
                      <li>Masukkan jumlah nominal : <?= 'Rp ' . number_format($invoice['order_price'], 0, ',', '.') ?></li>
                      <li>Periksa detail pembayaran lalu tekan <strong>Ya</strong>.</li>
                    <?php elseif (strpos($payment_method, 'qris') !== false) : ?>
                      <li>Login ke aplikasi mobile banking (BCA, BRImo, Livin') atau dompet digital Anda (GoPay, OVO, DANA, dll.) yang mendukung QRIS.</li>
                      <li>Cari dan ketuk menu <strong>Bayar/Scan QRIS</strong> atau ikon QR.</li>
                      <li>Arahkan kamera ke kode QR yang disediakan penerima (di layar HP, struk, atau kode statis).</li>
                      <li>Periksa detail pembayaran dan tekan <strong>Ya</strong>.</li>
                      <li>Masukkan jumlah uang yang akan dikirim <?= 'Rp ' . number_format($invoice['order_price'], 0, ',', '.') ?></li>
                      <li>Periksa detail transaksi (nama penerima, nominal). Klik <strong>Lanjut</strong> atau <strong>Konfirmasi</strong>.</li>
                      <li>Masukkan PIN transaksi Anda untuk menyelesaikan.</li>
                      <li>Tunggu notifikasi transaksi berhasil dan simpan bukti transaksi.</li>
                    <?php else : ?>
                      <li>Buka aplikasi mobile banking bank Anda.</li>
                      <li>Pilih menu transfer ke rekening virtual account.</li>
                      <li>Masukkan nomor <strong><?= $method['payment_id'] ?></strong>.</li>
                      <li>Periksa detail pembayaran lalu konfirmasi.</li>
                    <?php endif; ?>
                  </ol>
                </div>
                <div class="tab-pane fade" id="atm">
                  <ol>
                    <?php if (strpos($payment_method, 'bca') !== false) : ?>
                      <li>Masukkan kartu ATM BCA dan PIN Anda.</li>
                      <li>Pilih <strong>Transaksi Lainnya</strong> > <strong>Transfer</strong> > <strong>Ke Rekening BCA Virtual Account</strong>.</li>
                      <li>Masukkan nomor <strong><?= $method['payment_id'] ?></strong>.</li>
                      <li>Periksa detail pembayaran dan tekan <strong>Ya</strong>.</li>
                    <?php elseif (strpos($payment_method, 'bri') !== false) : ?>
                      <li>Masukkan kartu ATM BRI dan PIN Anda.</li>
                      <li>Pilih menu <strong>Transaksi Lainnya</strong> > <strong>Pembayaran</strong> > <strong>BRIVA</strong>.</li>
                      <li>Masukkan nomor <strong><?= $method['payment_id'] ?></strong>.</li>
                      <li>Periksa detail pembayaran dan tekan <strong>Ya</strong>.</li>
                    <?php elseif (strpos($payment_method, 'bni') !== false) : ?>
                      <li>Masukkan kartu ATM BNI dan PIN Anda.</li>
                      <li>Pilih menu <strong>Transfer</strong> > <strong>Virtual Account Billing</strong>.</li>
                      <li>Masukkan nomor <strong><?= $method['payment_id'] ?></strong>.</li>
                      <li>Periksa detail pembayaran dan tekan <strong>Ya</strong>.</li>
                    <?php elseif (strpos($payment_method, 'mandiri') !== false) : ?>
                      <li>Masukkan kartu ATM Mandiri dan PIN Anda.</li>
                      <li>Pilih menu <strong>Transfer </strong></li>
                      <li>Masukkan kode perusahaan <strong>008</strong> dan nomor <strong><?= $method['payment_id'] ?></strong>.</li>
                      <li>Periksa detail pembayaran dan tekan <strong>Ya</strong>.</li>
                    <?php else : ?>
                      <li>Masukkan kartu ATM bank Anda dan PIN.</li>
                      <li>Pilih menu transfer ke virtual account.</li>
                      <li>Masukkan nomor <strong><?= $method['payment_id'] ?></strong>.</li>
                      <li>Periksa detail pembayaran dan konfirmasi.</li>
                    <?php endif; ?>
                  </ol>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

  <?php endif; ?>
  <!-- Total Pembayaran -->
  <div class="card p-3 text-center mb-2">
    <?php
    $metode = strtolower($method['method_name']);
    if (str_contains($metode, 'qris') && $order['status'] == 'unpaid') : ?>
      <div class="d-flex justify-content-center">
        <div class="col-lg-5 col-12">
          <div class="method-qris py-2 px-5">
            <img src="<?= base_url() ?>dist/img/<?= $payment_method_img ?>" alt="" style="width:100%;">
          </div>
        </div>
      </div>
    <?php elseif (str_contains($metode, 'transfer')) : ?>
      <div class="d-flex justify-content-center">
        <div class="col text-center mb-4 p-2">
          <h4 class="mb-1"><?= $method['payment_id'] ?></h4>
          <span>A.N. Muhana Sano Esensi</span>
        </div>
      </div>
    <?php endif; ?>

    <div class="text-muted mb-1">Total Pembayaran</div>
    <div class="h4 fw-bold color-esensia mb-0"><?= 'Rp ' . number_format($invoice['order_price'], 0, ',', '.') ?></div>
    <?php if ($order['status'] == 'unpaid') : ?>
      <span class="py-1">Masukkan sesuai nominal tertera</span>
    <?php endif; ?>
  </div>

  <form action="<?= base_url() ?>/invoice/uploadBuktiTf" method="POST" onsubmit="return validateUpload()">
    <?php
    $image = $invoice['bukti_transfer'];

    $foto_bukti_transfer = empty($image) ? base_url() . 'dist/img/uploads/bukti_transfer/default_image.png' : $image;
    if ($invoice['status'] == 'paid') {
    ?>
      <input type="hidden" name="foto_product" value="<?= $foto_bukti_transfer ?>">
    <?php }
    ?>

    <input type="hidden" name="id" value="<?= $invoice['id'] ?? '' ?>">
    <input type="hidden" name="order_id" value="<?= $invoice['order_id'] ?? '' ?>">

    <div class="d-flex justify-content-center">
      <div class="uploadcms mb-3 upload-tf-container" style="min-height: 290px;width:95%; position: relative;">
        <div class="mb-2" style="display: contents;">
          <img class="rounded-15 mb-4" src="<?= $foto_bukti_transfer ?>" alt="" id="photo_product" style="position:absolute;width:276px;height:200px;">
          <div class="border-upload text-center">
            <input type="hidden" name="base64_input" id="base64_input">
            <input class="file-input" type="file" name="foto" accept="image/*" hidden>
            <!-- <i class="fa-solid fa-image" style="font-size: 40px; color: #989898; margin-left: -7%;"></i> -->
            <p style="color: #989898; margin-left: -7%;">Pilih Foto</p>
          </div>
        </div>
        <div style="position:absolute ; bottom:20px">
          <h5>Upload Bukti Transfer</h5>
        </div>
      </div>
    </div>

    <!-- Tombol Aksi -->
    <?php if ($order['status'] == 'unpaid') : ?>
      <div class="d-flex justify-content-center">
        <button type="submit" class="btn btn-success rounded-15 btn-sm p-2 col col-lg-4">Saya Sudah Bayar</button>
      </div>
    <?php else: ?>
      <div class="d-flex justify-content-center">
        <a href="<?= base_url() ?>" class="btn btn-primary rounded-15 btn-sm p-2 col col-lg-4 text-light">Back to Home</a>
      </div>
    <?php endif; ?>
  </form>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
  function copyVA() {
    const va = "123456789012345";
    navigator.clipboard.writeText(va);
    alert("Nomor VA disalin: " + va);
  }
</script>

<script>
  // Countdown timer for payment due
  (function() {
    const el = document.getElementById('due_countdown');
    if (!el) return;

    // Read due time from data-due attribute (ISO 8601). Fallback to innerText parse.
    const dueAttr = el.getAttribute('data-due');
    let dueDate = null;
    if (dueAttr) {
      dueDate = new Date(dueAttr);
    } else {
      // try parsing displayed text (best-effort)
      dueDate = new Date(el.innerText);
    }

    if (!dueDate || isNaN(dueDate.getTime())) {
      el.textContent = 'Tanggal jatuh tempo tidak valid';
      return;
    }
    console.log(dueDate)

    function formatRemaining(ms) {
      if (ms <= 0) return 'Waktu Habis';
      const totalSeconds = Math.floor(ms / 1000);
      const days = Math.floor(totalSeconds / 86400);
      const hours = Math.floor((totalSeconds % 86400) / 3600);
      const minutes = Math.floor((totalSeconds % 3600) / 60);
      const seconds = totalSeconds % 60;
      const pad = (n) => String(n).padStart(2, '0');
      return (days > 0 ? days + ' hari ' : '') + pad(hours) + ':' + pad(minutes) + ':' + pad(seconds);
    }

    function update() {
      const now = new Date();
      const diff = dueDate.getTime() - now.getTime();
      if (diff <= 0) {
        el.textContent = 'Waktu Habis';
        clearInterval(timer);
        return;
      }
      el.textContent = 'Sisa waktu: ' + formatRemaining(diff) + ' (berakhir: ' + dueDate.toLocaleString() + ')';
    }

    update();
    const timer = setInterval(update, 1000);
  })();
</script>

<script>
  function validateUpload() {
    const fileInput = document.querySelector('.file-input');
    if (fileInput.files.length === 0) {
      alert('Silakan upload foto bukti pembayaran terlebih dahulu.');
      return false;
    }
    return true;
  }
</script>