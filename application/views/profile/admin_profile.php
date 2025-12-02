<main role="main" class="main-content" style="margin-top: 64px;">
	<div class="container-fluid px-0">
		<h3>Pengaturan</h3>
		<div class="card">
			<div class="card-body">
				<ul class="nav nav-tabs mb-3" id="myTab" role="tablist">
					<li class="nav-item">
						<a class="nav-link active" id="profile-tab" data-bs-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Profile</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" id="password-tab" data-bs-toggle="tab" href="#password" role="tab" aria-controls="password" aria-selected="false">Password</a>
					</li>
				</ul>
				<div class="tab-content" id="myTabContent">
					<div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="home-tab">
						<form action="<?= base_url('admin/profile/save') ?>" method="post" enctype="multipart/form-data">
							<div class="row p-2">
								<div class="col">
									<h5>Personal Info</h5>
									<p class="text-muted small">update your photo and personal details here</p>
									<h5>Your Level : <?= $role ?></h5>
									<h5 class="my-3">Your Photo</h5>
									<div class="avatar d-flex align-items-center mb-3">
										<div class="profile-pic-div">
											<img src="<?= base_url() ?>dist/img/uploads/users/<?= $foto != '' ? $foto : 'default.png' ?>" id="photo" style="object-fit: cover; object-position: 100% 0;">
											<input type="file" id="file" name="foto" max="2000" accept=".jpg,.jpeg,.png">

											<label for="file" id="uploadBtn">Pilih Foto</label>
										</div>
										<input type="hidden" id="foto_base64" name="foto_base64" max="2000">
									</div>
								</div>
								<div class="col text-right">
									<button type="reset" class="btn btn-large btn-light" style="border-radius: 33px;">Cancel</button>
									<button type="submit" class="btn btn-primary" style="border-radius: 33px;">Save Changes</button>
								</div>
							</div>
							<div class="form-profile">
								<div class="form-group">
									<label for="">Nama Lengkap</label>
									<input type="text" class="form-control rounded-15" id="nama" name="name" value="<?= $name ?>" required>
								</div>
								<div class="form-group">
									<label for="">Nomor Telepon</label>
									<input type="text" class="form-control rounded-15" id="telp" name="telp" placeholder="cth: 628579919291" value="<?= $telp ?>" pattern="[0-9]{12,13}" title="Hanya dapat diisi dengan angka" required>
								</div>
								<div class="form-group">
									<label for="">Email</label>
									<input type="text" class="form-control rounded-15" id="telp" name="email" value="<?= $email ?>" disabled>
								</div>
							</div>
						</form>
					</div>
					<div class="tab-pane fade" id="password">
						<form action="<?= base_url('profile/save_pass') ?>" method="post">
							<div class="row p-2">
								<div class="col">
									<h5>Change Password</h5>
									<p class="text-muted">Change your password here</p>
								</div>
								<div class="col text-right">
									<button type="reset" class="btn btn-large btn-light" style="border-radius: 33px;">Cancel</button>
									<button type="submit" class="btn btn-primary" style="border-radius: 33px;">Save Changes</button>
								</div>
							</div>
							<div class="password">
								<div class="form-group">
									<label for="">Password Lama</label>
									<div class="d-flex">
										<input type="password" id="old_pass" name="old_pass" class="form-control rounded-15" pattern="[A-Za-z0-9]{8,}" title="Kata sandi minimal 8 karakter, berisi huruf besar maupun kecil & angka" required>
										<a role="button" class="password-show" data-show="0">
											<i class="fe fe-eye-off" aria-hidden="true"></i>
										</a>
									</div>
								</div>
								<div class="form-group">
									<label for="">Password Baru</label>
									<div class="d-flex">
										<input type="password" id="new_pass" name="new_pass" class="form-control rounded-15" pattern="[A-Za-z0-9]{8,}" title="Kata sandi minimal 8 karakter, berisi huruf besar maupun kecil & angka" required>
										<a role="button" class="password-show" data-show="0">
											<i class="fe fe-eye-off" aria-hidden="true"></i>
										</a>
									</div>
								</div>
							</div>
						</form>
					</div>

				</div>
			</div>
		</div>
	</div> <!-- .container-fluid -->