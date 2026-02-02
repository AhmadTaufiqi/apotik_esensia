<?php $this->load->view('layouts/head') ?>
<?php $this->load->view('layouts/topbar-cart') ?>

<div class="container-fluid">
	<div class="row justify-content-center">
		<div class="col-md-6">
			<div class="card">
				<div class="card-header">
					<h4 class="card-title">Setup Password</h4>
				</div>
				<div class="card-body">
					<p>Silakan atur password untuk akun Anda.</p>
					<form id="form-set-password" method="post">
						<div class="form-group">
							<label for="password">Password</label>
							<input type="password" class="form-control" id="password" name="password" required>
						</div>
						<div class="form-group">
							<label for="confirm_password">Konfirmasi Password</label>
							<input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
						</div>
						<button type="submit" class="btn btn-primary">Simpan Password</button>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
	$(document).ready(function() {
		$('#form-set-password').on('submit', function(e) {
			e.preventDefault();

			var password = $('#password').val();
			var confirmPassword = $('#confirm_password').val();

			if (password !== confirmPassword) {
				alert('Password dan konfirmasi password tidak cocok');
				return;
			}

			if (password.length < 6) {
				alert('Password minimal 6 karakter');
				return;
			}

			$.ajax({
				url: '<?= base_url('profile/save_password') ?>',
				type: 'POST',
				data: $(this).serialize(),
				success: function(response) {
					alert('Password berhasil disimpan');
					window.location.href = '<?= base_url('home') ?>';
				},
				error: function(xhr, status, error) {
					alert('Terjadi kesalahan: ' + error);
				}
			});
		});
	});
</script>

<?php $this->load->view('layouts/foot') ?>
