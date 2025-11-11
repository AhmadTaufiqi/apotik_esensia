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
    <div class="fw-bold text-success mb-1">Menunggu Pembayaran</div>
    <div class="text-muted mb-1">Bayar sebelum</div>
    <div class="fw-semibold text-danger">12 November 2025 • 23:59 WIB</div>
  </div>

  <!-- Metode Pembayaran -->
  <div class="card p-3 mb-2">
    <div class="fw-bold mb-2">Metode Pembayaran</div>
    <div class="d-flex align-items-center mb-2">
      <img src="https://upload.wikimedia.org/wikipedia/commons/6/6b/BCA_logo.svg" width="45" class="me-2" alt="BCA">
      <div>
        <div class="fw-semibold">Bank BCA - Virtual Account</div>
        <div class="d-flex align-items-center mt-1">
          <span class="va-number me-2" style="font-weight: 500;">123456789012345</span>
          <button class="btn btn-sm btn-success py-0" onclick="copyVA()">Salin</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Total Pembayaran -->
  <div class="card p-3 text-center mb-2">
    <div class="text-muted mb-1">Total Pembayaran</div>
    <div class="h4 fw-bold color-esensia mb-0">Rp 1.250.000</div>
  </div>

  <!-- Petunjuk Pembayaran -->
  <div class="card p-3 mb-2">
    <div class="fw-bold mb-3">Petunjuk Pembayaran</div>

    <ul class="nav nav-tabs nav-fill small" id="paymentTab" role="tablist">
      <li class="nav-item">
        <button class="nav-link active" id="m-banking-tab" data-bs-toggle="tab" data-bs-target="#m-banking" type="button">M-Banking</button>
      </li>
      <li class="nav-item">
        <button class="nav-link" id="i-banking-tab" data-bs-toggle="tab" data-bs-target="#i-banking" type="button">iBanking</button>
      </li>
      <li class="nav-item">
        <button class="nav-link" id="atm-tab" data-bs-toggle="tab" data-bs-target="#atm" type="button">ATM</button>
      </li>
    </ul>

    <div class="tab-content mt-3 small" id="paymentTabContent">
      <div class="tab-pane fade show active" id="m-banking">
        <ol>
          <li>Buka aplikasi BCA Mobile dan pilih menu <strong>m-BCA</strong>.</li>
          <li>Pilih <strong>m-Transfer</strong> &gt; <strong>BCA Virtual Account</strong>.</li>
          <li>Masukkan nomor <strong>123456789012345</strong> dan tekan <strong>OK</strong>.</li>
          <li>Periksa detail pembayaran lalu tekan <strong>Ya</strong>.</li>
        </ol>
      </div>

      <div class="tab-pane fade" id="i-banking">
        <ol>
          <li>Login ke <strong>klikBCA.com</strong>.</li>
          <li>Pilih menu <strong>Transfer Dana</strong> &gt; <strong>Ke BCA Virtual Account</strong>.</li>
          <li>Masukkan nomor <strong>123456789012345</strong>.</li>
          <li>Konfirmasi dan selesaikan transaksi.</li>
        </ol>
      </div>

      <div class="tab-pane fade" id="atm">
        <ol>
          <li>Masukkan kartu ATM BCA dan PIN Anda.</li>
          <li>Pilih <strong>Transaksi Lainnya</strong> &gt; <strong>Transfer</strong> &gt; <strong>Ke Rekening BCA Virtual Account</strong>.</li>
          <li>Masukkan nomor <strong>123456789012345</strong>.</li>
          <li>Periksa detail pembayaran dan tekan <strong>Ya</strong>.</li>
        </ol>
      </div>
    </div>
  </div>

  <!-- Tombol Aksi -->
  <div class="d-flex">
    <button class="btn btn-success rounded-15 btn-sm p-2 col">Saya Sudah Bayar</button>
  </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
  function copyVA() {
    const va = "123456789012345";
    navigator.clipboard.writeText(va);
    alert("Nomor VA disalin: " + va);
  }
</script>