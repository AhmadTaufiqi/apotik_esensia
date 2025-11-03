<div class="d-flex flex-column">
  <form method="POST" action="<?= base_url() ?>profile/save" enctype="multipart/form-data">

    <?php if (key_exists('id', $address)) : ?>
      <input type="hidden" name="address[id]" value="<?= $address['id'] ?>">
    <?php endif; ?>
    <input type="hidden" name="address[user_id]" value="<?= $user_id ?>">
    <div class="content p-2">

      <div class="card card-product-cart mb-2 p-2">
        <div class="p-2">
          <h5></h5>
          <div class="form-group mb-2">
            <label class="form-label" for="">Negara</label>
            <input type="text" class="form-control form-control-sm" name="address[negara]" value="Indonesia" readonly>
          </div>
          <div class="form-group mb-2">
            <label class="form-label" for="">Provinsi</label>
            <input type="text" class="form-control form-control-sm" name="address[provinsi]" value="Jawa Tengah" readonly>
          </div>
          <div class="form-group mb-2">
            <label class="form-label" for="">Kota</label>
            <input type="text" class="form-control form-control-sm" name="address[kota]" value="<?= $address['kota'] ?? $address['kota'] ?>">
          </div>
          <div class="form-group mb-2">
            <label class="form-label" for="">Kecamatan</label>
            <input type="text" class="form-control form-control-sm" name="address[kecamatan]" value="<?= $address['kecamatan'] ?? $address['kecamatan'] ?>">
          </div>
          <div class="form-group mb-2">
            <label class="form-label" for="">Kelurahan</label>
            <input type="text" class="form-control form-control-sm" name="address[kelurahan]" value="<?= $address['kelurahan'] ?? $address['kelurahan'] ?>">
          </div>
          <div class="form-group mb-2">
            <label class="form-label" for="">Kode Pos</label>
            <input type="text" class="form-control form-control-sm" name="address[kode_pos]" value="<?= $address['kode_pos'] ?? $address['kode_pos'] ?>">
          </div>
          <div class="form-group mb-2">
            <label class="form-label" for="">Catatan</label>
            <textarea class="form-control form-control-sm" name="address[catatan]"><?= $address['catatan'] ?? $address['catatan'] ?></textarea>
          </div>
          <input type="text" id="address_long" name="address[long]" value="<?= $address['long'] ?? $address['long'] ?>">
          <input type="text" id="address_lat" name="address[lat]" value="<?= $address['lat'] ?? $address['lat'] ?>">

          <div id="map" style="height: 150px;">
          </div>
        </div>
        <div class="col text-end">
          <button class="btn rounded-4 btn-sm bg-esensia text-light ms-1">Simpan</button>
        </div>

      </div>
    </div>
  </form>

</div>

<script>
  document.addEventListener("DOMContentLoaded", function() {
    var map = L.map('map', {
      center: [-7.048313751822978, 110.4182835266355],
      zoom: 15
    });


    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
      maxZoom: 19,
      attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(map);
    var routingcontrol = L.Routing.control().addTo(map);

    map.on('click', function(e) {
      var lat = e.latlng.lat;
      var lng = e.latlng.lng;

      console.log(lat)

      routingcontrol.setWaypoints([
        L.latLng(-6.997068603811686, 110.47304414464678),
        L.latLng(lat, lng)
      ])
    });

  });
</script>