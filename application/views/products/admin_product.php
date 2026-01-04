<main role="main" class="main-content" style="margin-top: 64px;">
  <div class="d-flex mb-3">
    <h4 class="mb-0"><?= $title ?></h4>
    <button class="btn btn-success text-light ms-auto me-2 py-2" data-bs-toggle="modal" data-bs-target="#importExcelModal"><i class="fas fa-download text-green me-1"></i>Import</button>
    <a href="<?= base_url() ?>admin/product/create" class="btn btn-primary text-light" style="align-content:center;">
      <i class="fas fa-plus me-1"></i>
      Tambah Produk
    </a>
  </div>

  <div class="card mb-3">
    <div class="card-body">
      <form method="GET" action="<?= base_url('admin/product') ?>">
        <div class="row g-2">
          <div class="col-md-5 px-1">
            <input type="search" name="search" value="<?= htmlspecialchars($filters['search'] ?? '') ?>" class="form-control" placeholder="Cari nama atau SKU">
          </div>
          <div class="col-md-3 px-1">
            <select name="category" class="form-control">
              <option value="">Semua Kategori</option>
              <?php foreach (($categories ?? []) as $cat) : ?>
                <option value="<?= $cat->id ?>" <?= (isset($filters['category']) && $filters['category'] == $cat->id) ? 'selected' : '' ?>><?= htmlspecialchars($cat->category) ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="col-md-3 px-1">
            <input type="text" id="date_range" class="form-control" placeholder="Pilih rentang tanggal" value="<?php if (!empty($filters['date_from']) && !empty($filters['date_to'])) echo htmlspecialchars($filters['date_from'] . ' - ' . $filters['date_to']); ?>">
            <input type="hidden" name="date_from" id="date_from" value="<?= htmlspecialchars($filters['date_from'] ?? '') ?>">
            <input type="hidden" name="date_to" id="date_to" value="<?= htmlspecialchars($filters['date_to'] ?? '') ?>">
          </div>
          <!-- <div class="col-2"></div> -->
          <div class="col-md-2 g-3">
            <div class="d-flex">
              <button class="btn btn-primary me-2" type="submit">Filter</button>
              <a href="<?= base_url('admin/product') ?>" class="btn btn-light">Reset</a>
            </div>

          </div>
        </div>
      </form>
    </div>
  </div>
  <?= $this->session->flashdata('message') ?>
  <div class="card">
    <div class="card-body">
      <div class="table-responsive">
        <table class="table datatable">
          <thead>
            <tr>
              <th>Sku</th>
              <th>Nama</th>
              <th>Harga Rp.</th>
              <th>Stok</th>
              <th>Kategori</th>
              <th>Diskon</th>
              <th width="10%">Action</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($data as $prod) : ?>
              <tr>
                <td><?= $prod->sku ?></td>
                <td><?= $prod->name ?></td>
                <td><?= number_format(empty($prod->price) ? 0 : $prod->price, 0, ',', '.') ?></td>
                <td><?= $prod->stock ?></td>
                <td><?= $prod->t_category ?></td>
                <td><?= $prod->discount ?> %</td>
                <td>
                  <button class="btn btn-sm" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-ellipsis-vertical"></i>
                  </button>
                  <div class="dropdown-menu">
                    <a href="<?= base_url('admin/product/detail/' . $prod->id) ?>" class="dropdown-item">
                      <span class="iconify mr-2" data-icon="ci:show"></span>Lihat Detail</a>
                    <a class="dropdown-item" href="<?= base_url('admin/product/edit/' . $prod->id) ?>">
                      <span class="iconify mr-2" data-icon="material-symbols:edit-square-outline-rounded"></span>Edit</a>
                    <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#hapusModal" onclick="$('#hapus_id').val('<?= $prod->id ?>')">
                      <span class="iconify mr-2" data-icon="fluent:delete-48-regular"></span>Hapus</button>
                  </div>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</main>

<!-- Modal Hapus-->
<div class="modal fade" id="hapusModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form action="<?= base_url() ?>/admin/product/delete" method="POST">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Hapus Produk</h5>
          <button class="close" type="button" data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <input type="hidden" name="id" id="hapus_id">
        <div class="modal-body">Apakah Anda yakin ingin menghapus produk ini?</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Batal</button>
          <button type="submit" id="btn-hapus" class="btn btn-primary" href="#">Hapus</button>
        </div>
      </div>
    </form>
  </div>
</div>

<!-- Modal import excel-->
<div class="modal fade" id="importExcelModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form action="<?= base_url() ?>/admin/product/importExcel" method="POST" enctype="multipart/form-data" id="form_import_excel">
      <!-- <div class="div" id="import_form"> -->
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Import Excel</h5>
          <button class="close" type="button" data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
          <input type="file" class="form-control mb-2" name="import_excel_file" id="import_excel_file">
          <div class="progress" id="import-progress-bar">
            <div class="progress-bar" role="progressbar" style="width: 4%" aria-valuenow="4" aria-valuemin="0" aria-valuemax="100"></div>
          </div>
        </div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Batal</button>
          <button type="button" id="btn_import_excel" class="btn btn-primary" href="#">Import</button>
        </div>
      </div>
    </form>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    if (typeof $ === 'undefined' || typeof $.fn.daterangepicker === 'undefined') return;

    var start = $('#date_from').val() || '';
    var end = $('#date_to').val() || '';

    $('#date_range').daterangepicker({
      autoUpdateInput: false,
      locale: {
        format: 'YYYY-MM-DD',
        cancelLabel: 'Clear'
      },
      opens: 'left'
    });

    if (start !== '' && end !== '') {
      $('#date_range').data('daterangepicker').setStartDate(start);
      $('#date_range').data('daterangepicker').setEndDate(end);
      $('#date_range').val(start + ' - ' + end);
    }

    $('#date_range').on('apply.daterangepicker', function(ev, picker) {
      $('#date_from').val(picker.startDate.format('YYYY-MM-DD'));
      $('#date_to').val(picker.endDate.format('YYYY-MM-DD'));
      $(this).val(picker.startDate.format('YYYY-MM-DD') + ' - ' + picker.endDate.format('YYYY-MM-DD'));
    });

    $('#date_range').on('cancel.daterangepicker', function(ev, picker) {
      $('#date_from').val('');
      $('#date_to').val('');
      $(this).val('');
    });

    $('#btn_import_excel').on('click', function() {
      var form = $('#form_import_excel');
      var form_data = new FormData(form[0]);
      var progress_bar = $('#import-progress-bar .progress-bar');

      form_data.append('action', 'start');
      // console.log(form_data)
      // console.log('"' + form.attr('action') + '"');

      $.ajax({
        url: form.attr('action'),
        type: 'POST',
        data: form_data,
        processData: false,
        contentType: false,
        xhr: function() {
          var xhr = new window.XMLHttpRequest();
          xhr.upload.addEventListener('progress', function(evt) {
            console.log(evt);
            if (evt.lengthComputable) {
              var percentComplete = ((evt.loaded / evt.total) * 100) - 30;
              console.log(percentComplete);
              progress_bar.width(percentComplete + '%');
              progress_bar.html(percentComplete + '%');
            }
          }, false);
          return xhr;
        },
        beforeSend: function() {
          progress_bar.width('0%');
          $('#uploadStatus').html('<img src="loading.gif"/>');
        },
        success: function(response) {
          progress_bar.width(100 + '%');
          progress_bar.html(100 + '%');

          // Handle success response
          // location.reload();
        },
        error: function(jqXHR, textStatus, errorThrown) {
          // Handle error response
          alert('Error importing file: ' + errorThrown);
        }
      })


      // var progressInterval = setInterval(function() {
      //   form_data.set('action', 'get_progress');
      //   // console.log(form.attr('action'));
      //   $.ajax({

      //     url: form.attr('action'),
      //     type: 'POST',
      //     data: form_data,
      //     processData: false,
      //     contentType: false,
      //     success: function(response) {
      //       console.log(response)
      //       if (response.progress) {
      //         // $('#progressBar').width(response.progress + '%');
      //         // $('#progressText').text(response.progress + '%');
      //         if (response.progress >= 100) {
      //           clearInterval(progressInterval);
      //         }
      //       }
      //     }
      //   });
      // }, 1000);
      // $('#form_import_excel').submit();
    })
  });
</script>