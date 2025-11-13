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
    <!-- Due datetime is stored in data-due as ISO 8601 with timezone. Update this value server-side if needed. -->
    <div id="due_countdown" class="fw-semibold text-danger" data-due="2025-11-13T23:59:00+07:00">12 November 2025 • 23:59 WIB</div>
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

<script>
  // Countdown timer for payment due
  (function () {
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