<main role="main" class="main-content" style="margin-top: 64px;">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0"><?= $title ?></h4>
    <a href="<?= base_url('admin/orders') ?>" class="btn btn-secondary text-light">
      <i class="fas fa-arrow-left me-2"></i>Kembali
    </a>
  </div>

  <!-- Order Information Card -->
  <div class="card mb-3">
    <div class="card-header bg-primary text-white">
      <h5 class="mb-0"><i class="fas fa-shopping-cart me-2"></i>Informasi Pesanan</h5>
    </div>
    <div class="card-body">
      <div class="row">
        <div class="col-md-6">
          <table class="table table-borderless">
            <tr>
              <td width="40%" class="fw-bold">Order ID</td>
              <td width="5%">:</td>
              <td>#<?= $order['id'] ?></td>
            </tr>
            <tr>
              <td class="fw-bold">Tanggal Order</td>
              <td>:</td>
              <td><?= date('d F Y H:i', strtotime($order['created_at'])) ?></td>
            </tr>
            <tr>
              <td class="fw-bold">Status Pesanan</td>
              <td>:</td>
              <td class="order_status"><?= $order['status'] ?></td>
            </tr>
            <tr>
              <td class="fw-bold">Total Harga</td>
              <td>:</td>
              <td class="text-success fw-bold">Rp <?= number_format($order['cost_price'], 0, ',', '.') ?></td>
            </tr>
            <tr>
              <td class="fw-bold">Harga Asli</td>
              <td>:</td>
              <td>Rp <?= number_format($order['raw_cost_price'], 0, ',', '.') ?></td>
            </tr>
            <?php if ($order['cost_price'] < $order['raw_cost_price']) : ?>
              <tr>
                <td class="fw-bold">Diskon</td>
                <td>:</td>
                <td class="text-danger">Rp <?= number_format($order['raw_cost_price'] - $order['cost_price'], 0, ',', '.') ?></td>
              </tr>
            <?php endif; ?>
          </table>
        </div>
        <div class="col-md-6">
          <table class="table table-borderless">
            <tr>
              <td width="40%" class="fw-bold">Nama Customer</td>
              <td width="5%">:</td>
              <td><?= $order['customer_name'] ?></td>
            </tr>
            <tr>
              <td class="fw-bold">Email</td>
              <td>:</td>
              <td><?= $order['customer_email'] ?? '-' ?></td>
            </tr>
            <tr>
              <td class="fw-bold">No. Telepon</td>
              <td>:</td>
              <td><?= $order['customer_phone'] ?? '-' ?></td>
            </tr>
            <tr>
              <td class="fw-bold">Alamat</td>
              <td>:</td>
              <td>
                <?php if (!empty($order['address_kota']) || !empty($order['address_kecamatan'])) : ?>
                  <?php
                  $address_parts = [];
                  if (!empty($order['address_kelurahan'])) $address_parts[] = 'Kel. ' . $order['address_kelurahan'];
                  if (!empty($order['address_kecamatan'])) $address_parts[] = 'Kec. ' . $order['address_kecamatan'];
                  if (!empty($order['address_kota'])) $address_parts[] = $order['address_kota'];
                  if (!empty($order['address_provinsi'])) $address_parts[] = $order['address_provinsi'];
                  if (!empty($order['address_kode_pos'])) $address_parts[] = $order['address_kode_pos'];

                  echo implode(', ', $address_parts);

                  if (!empty($order['address_catatan'])) {
                    echo '<br><small class="text-muted">Catatan: ' . htmlspecialchars($order['address_catatan']) . '</small>';
                  }
                  ?>
                <?php else : ?>
                  <?= $order['customer_address'] ?? '-' ?>
                <?php endif; ?>
              </td>
            </tr>
            <tr>
              <td class="fw-bold">Link G-maps</td>
              <td>:</td>
              <td>
                <?php if (!empty($order['address_lat']) && !empty($order['address_long'])) : ?>
                  <a href="https://www.google.com/maps?q=<?= $order['address_lat'] ?>,<?= $order['address_long'] ?>" target="_blank" class="btn btn-sm btn-outline-primary">
                    <i class="fas fa-map-marker-alt me-1"></i>Lihat Lokasi
                  </a>
                <?php else : ?>
                  -
                <?php endif; ?>
              </td>
            </tr>
            <tr>
              <td colspan="3">
                <div id="map" style="height: 250px;">
                </div>
              </td>
            </tr>
          </table>
        </div>
      </div>
    </div>
  </div>

  <!-- Order Products Card -->
  <div class="card">
    <div class="card-header bg-info text-white">
      <h5 class="mb-0"><i class="fas fa-box me-2"></i>Produk yang Dipesan</h5>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-hover">
          <thead class="table-light">
            <tr>
              <th width="5%">No</th>
              <th width="10%">Gambar</th>
              <th width="30%">Nama Produk</th>
              <th width="15%">SKU</th>
              <th width="15%" class="text-end">Harga</th>
              <th width="10%" class="text-center">Qty</th>
              <th width="15%" class="text-end">Subtotal</th>
            </tr>
          </thead>
          <tbody>
            <?php if (!empty($order_products)) : ?>
              <?php
              $no = 1;
              $total = 0;
              foreach ($order_products as $item) :
                $subtotal = $item['price'] * $item['qty'];
                $total += $subtotal;
              ?>
                <tr>
                  <td><?= $no++ ?></td>
                  <td>
                    <?php if (!empty($item['image'])) : ?>
                      <img src="<?= base_url('dist/img/uploads/products/' . $item['image']) ?>" alt="<?= $item['name'] ?>" class="img-thumbnail" style="width: 60px; height: 60px; object-fit: cover;">
                    <?php else : ?>
                      <img src="<?= base_url('dist/img/uploads/products/default_image.png') ?>" alt="No Image" class="img-thumbnail" style="width: 60px; height: 60px; object-fit: cover;">
                    <?php endif; ?>
                  </td>
                  <td>
                    <div class="fw-bold"><?= $item['name'] ?></div>
                    <?php if (!empty($item['description'])) : ?>
                      <small class="text-muted"><?= substr($item['description'], 0, 50) ?>...</small>
                    <?php endif; ?>
                  </td>
                  <td><?= $item['sku'] ?></td>
                  <td class="text-end">Rp <?= number_format($item['price'], 0, ',', '.') ?></td>
                  <td class="text-center">
                    <span class="badge bg-secondary"><?= $item['qty'] ?></span>
                  </td>
                  <td class="text-end fw-bold">Rp <?= number_format($subtotal, 0, ',', '.') ?></td>
                </tr>
              <?php endforeach; ?>
              <tr class="table-active">
                <td colspan="6" class="text-end fw-bold">Total:</td>
                <td class="text-end fw-bold text-success fs-5">Rp <?= number_format($total, 0, ',', '.') ?></td>
              </tr>
            <?php else : ?>
              <tr>
                <td colspan="7" class="text-center text-muted py-4">
                  <i class="fas fa-inbox fa-3x mb-3"></i>
                  <p>Tidak ada produk dalam pesanan ini</p>
                </td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</main>

<script src="<?= base_url() ?>dist/leafletjs/leaflet.js"></script>
<script src="<?= base_url() ?>dist/leaflet-routing-machine/dist/leaflet-routing-machine.js"></script>

<script>
  document.addEventListener("DOMContentLoaded", function() {
    const populateUrl = '<?= base_url("kurir/orders/populateOrderStatus") ?>';

    // For the status cell, request the formatted HTML and replace the cell content
    const statusCell = document.querySelector('td.order_status');
    if (statusCell) {
      const raw = statusCell.textContent || statusCell.innerText || '';
      const status = raw.trim();
      if (status) {
        // AJAX GET request
        fetch(populateUrl + '?status=' + encodeURIComponent(status))
          .then(function(res) {
            return res.text();
          })
          .then(function(html) {
            // replace the cell innerHTML with returned HTML
            statusCell.innerHTML = html;
          })
          .catch(function(err) {
            console.error('Error fetching status HTML', err);
          });
      }
    }
  });
</script>

<script>
  document.addEventListener("DOMContentLoaded", function() {

    input_long = '<?= $order['address_long']?>';
    input_lat = '<?= $order['address_lat']?>';
    my_home_loc = [input_lat, input_long];
    console.log(my_home_loc);
    var map = L.map('map', {
      center: my_home_loc,
      zoom: 13
    });

    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
      maxZoom: 14,
      attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(map);

    var map1_marker = L.marker(my_home_loc, {
      title: 'customer',
    }).addTo(map);
    // console.log(map1_marker);
  });
</script>