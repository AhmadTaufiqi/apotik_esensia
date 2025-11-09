<div class="d-flex flex-column">
  <form method="POST" action="<?= base_url() ?>profile/save" enctype="multipart/form-data">

    <?php if (key_exists('id', $address)) : ?>
      <input type="hidden" name="address[id]" value="<?= $address['id'] ?>">
    <?php endif; ?>
    <input type="hidden" name="address[user_id]" value="<?= $user_id ?>">
    <div class="content p-2">

      <div class="card card-product-cart mb-2 p-2">
        <div class="d-flex">
          <div class="avatar d-flex align-items-center px-2 p-4">
            <div class="profile-pic-div add-shadow" style="width: 120px; height: 120px;">
              <img src="<?= base_url() ?>dist/img/uploads/users/<?= $foto_akun != '' ? $foto_akun : 'default.png' ?>" id="photo" style="object-fit: cover; object-position: 100% 0;">
              <input type="file" id="file" name="file" max="2000" accept=".jpg,.jpeg,.png">
              <label for="file" id="uploadBtn" style="height:40px">Pilih Foto</label>
            </div>
            <input type="hidden" id="foto_base64" name="foto_base64" max="2000">
          </div>
          <div class="col py-4">
            <div class="mb-2">
              <span class="fw-bold"><?= $email ?></span>
            </div>
            <div class="form-group mb-2">
              <input type="text" class="form-control form-control-sm" name="name" value="<?= $name ?? $name ?>">
            </div>
            <div class="form-group mb-2">
              <input type="text" class="form-control form-control-sm" name="telp" value="<?= $hp_akun ?? $hp_akun ?>">
            </div>
          </div>
        </div>
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
          <input type="hidden" id="address_long" name="address[long]" value="<?= $address['long'] ?? $address['long'] ?>">
          <input type="hidden" id="address_lat" name="address[lat]" value="<?= $address['lat'] ?? $address['lat'] ?>">

          <div id="map" style="height: 150px;">
          </div>
          <div class="card mb-2 flex-row py-2 px-3 mt-1" style="user-select: none;" data-bs-toggle="offcanvas" data-bs-target="#offcanvasSetLocation" aria-controls="offcanvasBottom">
            <!-- <div class="d-flex"> -->
            <div class="col d-flex flex-column">
              <div class="d-flex align-items-center">
                <i class="fas fa-location-dot color-esensia"></i>
                <h6 class="mb-0 ms-1" id="address_name"><?= $name ?></h6>
                <span class="ms-2 small" id="address_phone_number"><?= $hp_akun ?></span>
              </div>
              <span>
                <?= $address['jalan'] . ' ' . $address['kode_pos'] . ', ' . $address['kelurahan'] . ', ' . $address['kecamatan'] . ', ' . $address['kota'] . ', ' . $address['provinsi'] ?>
              </span>
            </div>
            <div class="text-end align-self-center">
              <i class="fas fa-pencil fa-lg text-muted"></i>
            </div>
            <!-- </div> -->
          </div>
        </div>
        <div class="col text-end">
          <button class="btn rounded-4 btn-sm bg-esensia text-light ms-1">Simpan</button>
        </div>

      </div>
    </div>
  </form>

</div>

<div class="offcanvas offcanvas-bottom" tabindex="-1" id="offcanvasSetLocation" aria-labelledby="offcanvasBottomLabel" style="height: 58vh;">
  <div class="offcanvas-header pb-0 py-2">
    <div>
      <h5 class="offcanvas-title mb-0" id="offcanvasBottomLabel">Tentukan Titik Lokasi</h5>
      <small>Geser untuk mengubah titik lokasi</small>
    </div>
    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body small">
    <div id="map2" style="height: 300px;" class="mb-2">
    </div>
    <input type="hidden" name="long" id="long_maps_point">
    <input type="hidden" name="lat" id="lat_maps_point">
    <input type="hidden" name="ongkir" id="ongkir_count">
    <button class="btn btn-sm btn-primary" id="find_current_location">Cari Lokasi Saya</button>
    <span>distance: <span id="distance"></span></span>
  </div>
  <div class="modal-footer text-end py-2">
    <button class="btn btn-sm btn-success" id="save_location_modal">Simpan</button>
  </div>
</div>

<script>
  document.addEventListener("DOMContentLoaded", function() {

    var my_home_loc = [-7.045362120452517, 110.42101321590506];
    var loc_esensia = ['-6.996813464846989', '110.47300506227707'];
    var loc_esensia = {
      lat: -6.996813464846989,
      lng: 110.47300506227707
    };
    var map = L.map('map').setView(my_home_loc, 13);


    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
      maxZoom: 19,
      attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(map);

    var map1_marker = L.marker(my_home_loc, {
      title: 'customer',
    }).addTo(map);


    var map2 = L.map('map2').setView(my_home_loc, 14);

    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
      maxZoom: 19,
      attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(map2);

    // var marker = L.marker(loc_esensia, {
    //   title: 'customer',
    //   draggable: true,
    // }).addTo(map2)

    $('.leaflet-control-container .leaflet-top.leaflet-right').hide()
    $('.leaflet-control-container .leaflet-bottom.leaflet-right').hide()

    var routingcontrol = L.Routing.control({
      createMarker: function(i, wp) {
        var draggable = true;

        if (wp.latLng.lat === loc_esensia.lat && wp.latLng.lng === loc_esensia.lng) {
          draggable = false;
        }

        var options = {
            draggable
          },
          marker = L.marker(wp.latLng, options);

        return marker;
      },
      addWaypoints: false,
      waypoints: [
        L.latLng(loc_esensia),
        L.latLng(my_home_loc)
      ],
      // draggableWaypoints:false
      // routeWhileDragging: true
    }).addTo(map2);

    routingcontrol.on('routesfound', function(e) {
      var destination = e.waypoints[e.waypoints.length - 1].latLng;
      // var distance = e.routes.summary.totalDistance / 1000 + ' km';
      var distance = e.routes[0].summary.totalDistance / 1000 + ' km';

      $('#long_maps_point').val(destination.lng);
      $('#lat_maps_point').val(destination.lat);
      $('#distance').html(distance);
    })

    $('#find_current_location').on('click', function() {

      if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(findCurrentLocation, error);
      } else {
        x.innerHTML = "Geolocation is not supported by this browser.";
      }
    })

    $('#save_location_modal').on('click', function() {
      var lng = $('#long_maps_point').val();
      var lat = $('#lat_maps_point').val();

      $('#address_long').val(lng);
      $('#address_lat').val(lat);

      map1_marker.setLatLng({
        lng,
        lat
      });

      $('#offcanvasSetLocation').offcanvas('hide');
    })

    function findCurrentLocation(position) {
      var coords = position.coords

      routingcontrol.setWaypoints([
        loc_esensia,
        {
          lng: coords.longitude,
          lat: coords.latitude
        }
      ]);

      // x.innerHTML = "Latitude: " + position.coords.latitude +
      //   "<br>Longitude: " + position.coords.longitude;
    }

    function error(error) {
      // alert("Sorry, no position available.");
      alert(error.message);
    }
  })
</script>