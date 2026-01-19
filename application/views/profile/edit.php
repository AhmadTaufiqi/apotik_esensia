<div class="container px-0">
  <div class="d-flex flex-column">
    <form method="POST" id="form_address" action="<?= base_url() ?>profile/save" enctype="multipart/form-data">

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
                <input type="file" id="file_profile" name="foto" max="2000" accept=".jpg,.jpeg,.png">
                <label for="file_profile" id="uploadBtn" style="height:40px">Pilih Foto</label>
              </div>
              <input type="hidden" id="foto_base64" name="foto_base64" max="2000">
            </div>
            <div class="col col-lg-6 py-4 px-1">
              <div class="mb-2">
                <span class="fw-bold"><?= $email ?></span>
              </div>
              <div class="form-group mb-2">
                <input type="text" class="form-control form-control-sm" name="name" value="<?= $name ?? $name ?>" required>
              </div>
              <div class="form-group mb-2">
                <input type="tel" pattern="^(\\+62|62|0)8[1-9][0-9]{6,10}$" title="Nomor telepon Indonesia, contoh: 08123456789 atau +628123456789" maxlength="15" class="form-control form-control-sm" name="telp" value="<?= $hp_akun ?? $hp_akun ?>" required>
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
              <input type="text" class="form-control form-control-sm" name="address[kota]" value="Semarang" readonly>
            </div>
            <div class="form-group mb-2">
              <label class="form-label" for="">Kecamatan</label>
              <input type="text" class="form-control form-control-sm" name="address[kecamatan]" value="<?= $address['kecamatan'] ?? $address['kecamatan'] ?>" required>
              <small class="text-danger warning ms-1" hidden>Kecamatan tidak ditemukan</small>
            </div>
            <div class="form-group mb-2">
              <label class="form-label" for="">Kelurahan</label>
              <input type="text" class="form-control form-control-sm" name="address[kelurahan]" value="<?= $address['kelurahan'] ?? $address['kelurahan'] ?>" required>
              <small class="text-danger warning ms-1" hidden>Kelurahan tidak ditemukan</small>
            </div>
            <div class="form-group mb-2">
              <label class="form-label" for="">Kode Pos</label>
              <input type="text" class="form-control form-control-sm" name="address[kode_pos]" value="<?= $address['kode_pos'] ?? $address['kode_pos'] ?>" required>
              <small class="text-danger warning ms-1" hidden>Kode pos tidak ditemukan</small>
            </div>
            <div class="form-group mb-2">
              <label class="form-label" for="">Catatan</label>
              <textarea class="form-control form-control-sm" name="address[catatan]" placeholder="tuliskan nama jalan, nomor rumah, atau patokan" required><?= $address['catatan'] ?? $address['catatan'] ?></textarea>
            </div>
            <input type="hidden" id="address_long" name="address[long]" value="<?= $address['long'] ?? $address['long'] ?>">
            <input type="hidden" id="address_lat" name="address[lat]" value="<?= $address['lat'] ?? $address['lat'] ?>">
            <input type="hidden" id="address_jarak" name="address[jarak]" value="<?= $address['jarak'] ?? $address['jarak'] ?>">

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
                <span id="btn_address_text">
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
    <div id="map2" style="height: 89%;" class="mb-2">
    </div>
    <input type="hidden" name="long" id="long_maps_point" value="<?= $address['long'] ?>">
    <input type="hidden" name="lat" id="lat_maps_point" value="<?= $address['lat'] ?>">
    <input type="hidden" name="addresses" id="addresses_temp">
    <input type="hidden" name="ongkir" id="distance_temp">
    <button class="btn btn-sm btn-primary" id="find_current_location">Cari Lokasi Saya</button>
    <span>distance: <span id="distance"></span></span>
  </div>
  <div class="modal-footer text-end py-2">
    <button class="btn btn-sm btn-success" id="save_location_modal">Simpan</button>
  </div>
</div>

<script>
  const http = new XMLHttpRequest();

  document.addEventListener("DOMContentLoaded", function() {

    input_long = $('#address_long').val();
    input_lat = $('#address_lat').val();

    var my_home_loc = [input_lat, input_long];

    if (input_long.length == 0 || input_lat.length == 0) {
      my_home_loc = [-6.997386756897924, 110.47300043164309];
    }

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
      var raw_distance = e.routes[0].summary.totalDistance / 1000;
      var distance = raw_distance + ' km';

      // const bcdAPI = `https://api.bigdatacloud.net/data/reverse-geocode-client?latitude=${destination.lat}&longitude=${destination.lng}`;
      const bcdAPI = `https://geocode.maps.co/reverse?lat=${destination.lat}&lon=${destination.lng}&api_key=6914a50a41402699635321jrhda0799`;
      var api = getAPI(bcdAPI);

      $('#long_maps_point').val(destination.lng);
      $('#lat_maps_point').val(destination.lat);
      $('#distance').html(distance);
      $('#distance_temp').val(raw_distance);
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
      var distance = $('#distance_temp').val();
      var addresses = JSON.parse($('#addresses_temp').val()).address;

      $('#address_long').val(lng);
      $('#address_lat').val(lat);
      $('#address_jarak').val(distance);

      var input_kecamatan = $('#form_address input[name="address[kecamatan]"]')
      var input_kelurahan = $('#form_address input[name="address[kelurahan]"]')
      var input_kodepos = $('#form_address input[name="address[kode_pos]"]')
      var input_catatan = $('#form_address input[name="address[catatan]"]')
      var btn_address_text = $('#btn_address_text')

      console.log(addresses);

      if (addresses.hasOwnProperty('city_district')) {
        input_kecamatan.val(addresses.city_district);
      } else {
        input_kecamatan.val('');
        input_kecamatan.siblings('.warning').attr('hidden', false);
      }

      if (addresses.hasOwnProperty('village')) {
        input_kelurahan.val(addresses.village);
      } else {
        input_kelurahan.val('');
        input_kelurahan.siblings('.warning').attr('hidden', false);
      }

      if (addresses.hasOwnProperty('postcode')) {
        input_kodepos.val(addresses.postcode);
      } else {
        input_kodepos.siblings('.warning').attr('hidden', false);
      }

      if (addresses.hasOwnProperty('road')) {
        input_catatan.html(addresses.road);
      }

      var address_string = input_kodepos.val() + ', ' + input_kelurahan.val() + ', ' + input_kecamatan.val() + ', Semarang, Jawa Tengah';
      btn_address_text.html(address_string);

      map1_marker.setLatLng({
        lng,
        lat
      });

      $('#offcanvasSetLocation').offcanvas('hide');
    })

    // hide warning on input change or keyup
    $('#form_address input').on('change keyup', function() {
      $(this).siblings('.warning').attr('hidden', true);
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

      // Move the small map view and the modal map to the user's current position
      try {
        var userLatLng = [coords.latitude, coords.longitude];

        // also move the larger modal map
        if (typeof map2 !== 'undefined' && map2) {
          map2.setView(userLatLng, 14);
        }
      } catch (err) {
        console.warn('Could not move map view to current location', err);
      }

      // x.innerHTML = "Latitude: " + position.coords.latitude +
      //   "<br>Longitude: " + position.coords.longitude;
    }

    function error(error) {
      // alert("Sorry, no position available.");
      alert(error.message);
    }

  })

  function getAPI(url) {
    http.open('GET', url);
    http.send()
    var address = http.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        var addr = JSON.parse(this.responseText).address
        if (!addr) {
          alert('Alamat tidak ditemukan!');
        }

        var input_addresses = $('#addresses_temp').val(this.responseText);
      }
    }
  }
</script>