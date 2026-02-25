<main role="main" class="main-content" style="margin-top: 64px;">
  <div class="d-flex mb-3 align-items-bottom">
    <div>
      <h4 class="mb-0"><?= $title ?></h4>
      <small class="text-muted">NB: Jika tidak di isi maka tidak ada ongkir</small>
    </div>
    <div class="ms-auto">
      <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-add-ongkir">
        <i class="fas fa-plus"></i>
        Tambah jarak ongkir
      </button>
    </div>
  </div>

  <?php if ($this->session->flashdata('success')) : ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      <i class="fas fa-check-circle me-2"></i>
      <?= $this->session->flashdata('success') ?>
      <button type="button" class="btn-close" style="padding:13px" data-bs-dismiss="alert"></button>
    </div>
  <?php endif; ?>

  <?php if ($this->session->flashdata('error')) : ?>
    <div class="alert alert-danger d-flex alert-dismissible fade show" role="alert">
      <i class="fas fa-exclamation-triangle me-2"></i>
        <?= $this->session->flashdata('error') ?>
      <button type="button" class="btn-close" style="padding:13px" data-bs-dismiss="alert"></button>
    </div>
  <?php endif; ?>

  <div class="card">
    <div class="card-body">
      <div class="table-responsive">
        <table class="table datatable">
          <thead>
            <tr>
              <th>Nominal</th>
              <th>Jarak awal</th>
              <th>Jarak akhir</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($data as $ongkir) : ?>
              <tr>
                <td><?= number_format($ongkir['nominal'], 0, ',', '.') ?></td>
                <td width="10%"><?= $ongkir['jarak_start'] ?></td>
                <td width="10%"><?= $ongkir['jarak_end'] ?></td>
                <td width="10%">
                  <button class="btn btn_edit_ongkir" data-bs-toggle="modal" data-bs-target="#editModal" data-ongkir='<?= json_encode($ongkir) ?>'>
                    <i class="fas fa-pencil text-info"></i>
                  </button>
                  <button class="btn" data-bs-toggle="modal" data-bs-target="#hapusModal" onclick="hapus(<?= $ongkir['id'] ?>)">
                    <i class="fas fa-trash text-danger"></i>
                  </button>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <!-- Edit Modal -->
  <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <form action="<?= base_url() ?>/admin/ongkir/update" method="POST" id="form_edit_ongkir">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Edit Ongkir</h5>
            <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <input type="hidden" name="id" id="edit_id">
            <div class="mb-3">
              <label class="form-label">KM Start</label>
              <input type="number" step="any" name="jarak_start" id="edit_jarak_start" class="form-control" required>
            </div>
            <div class="mb-3">
              <label class="form-label">KM End</label>
              <input type="number" step="any" name="jarak_end" id="edit_jarak_end" class="form-control" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Nominal (Rp)</label>
              <input type="number" name="nominal" id="edit_nominal" class="form-control" required>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-primary">Simpan</button>
          </div>
        </div>
      </form>
    </div>
  </div>

  <script>
    document.addEventListener("DOMContentLoaded", function() {

      $('.btn_edit_ongkir').on('click', function() {

        var data_ongkir = $(this).data('ongkir')
        $('#form_edit_ongkir').on('show.bs.modal', function() {})

        $('#form_edit_ongkir').on('hide.bs.modal', function() {
          $('#form_edit_ongkir').reset()
          console.log('hide')
        })
        document.getElementById('edit_id').value = data_ongkir.id;
        document.getElementById('edit_jarak_start').value = data_ongkir.jarak_start;
        document.getElementById('edit_jarak_end').value = data_ongkir.jarak_end;
        document.getElementById('edit_nominal').value = data_ongkir.nominal;
      });


    });
  </script>
</main>


<!-- Modal Hapus-->
<div class="modal fade" id="hapusModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form action="<?= base_url() ?>/admin/ongkir/delete" method="POST" id="form_hapus_ongkir">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Hapus Ongkir</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <p>Apakah Anda yakin ingin menghapus data ongkir ini?</p>
          <input type="hidden" name="id" id="hapus_id">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-danger">Hapus</button>
        </div>
      </div>
    </form>
  </div>
</div>

<script>
  function hapus(id) {
    var el = document.getElementById('hapus_id');
    if (el) el.value = id;
  }
</script>
<div class="modal fade" id="modal-add-ongkir" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form action="<?= base_url() ?>/admin/ongkir/create" method="POST">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Tambah Ongkir</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">KM Start</label>
            <input type="number" step="any" name="jarak_start" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">KM End</label>
            <input type="number" step="any" name="jarak_end" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Nominal (Rp)</label>
            <input type="number" name="nominal" class="form-control" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
      </div>
    </form>
  </div>
</div>