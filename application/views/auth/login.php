  <body>
    <div class="mobile-container">
      <div class="carousel">
        <div class="navbar px-2 bg-dark">
          <a class="card align-items-center justify-content-center rounded-circle border-0 me-2" style="height: 40px; width:40px;">
            <img class="rounded-circle" width="80%" src="<?= base_url() ?>dist/img/logo.png" alt="">
          </a>
          <div class="col pe-2">
            <h6 class="color-esensia text-center mb-0 fw-bold"><?= $title ?></h6>
          </div>
          <a href="#" class="btn bg-white rounded-circle px-1" style="height: 40px; width:40px;">
            <i class="fas fa-info fa-xl color-esensia"></i>
          </a>
        </div>
      </div>

      <div class="d-flex flex-column">
        <form method="POST" action="">

          <div class="content p-2 d-flex align-items-center">
            <div class="col-9 text-center mx-auto mb-5">
              <a href="<?= base_url('auth/login_google') ?>" class="rounded-15 btn btn-success px-3 mb-3 text-light">
                <img width="22" style="padding: 2px;" class="rounded-circle bg-white me-1" src="<?= base_url() ?>dist/img/google-logo.png" alt="">
                Masuk Dengan Google
              </a>
              <div class="form-group mb-3">
                <div class="d-flex align-items-center">
                  <input type="text" id="inputEmail" name="email" class="form-control form-control-lg rounded-15" placeholder="Masukkan Email Anda" required="" autofocus="" style="padding-left:35px; font-size: 14px;">
                  <i class="form-icon fe fe-user"></i>
                </div>
                <?= $this->session->flashdata('msg') ?>
              </div>
              <div class="form-group mb-4">
                <div class="d-flex align-items-center position-relative">
                  <input type="password" name="password" class="form-control form-control-lg rounded-15" placeholder="Password" required="" style="padding-left:35px; font-size: 14px;">
                  <i class="form-icon fe fe-key"></i>
                  <a role="button" class="password-show" data-show="0" style="color:#858585;right:5px;">
                    <i class="fe fe-eye-off" aria-hidden="true"></i>
                  </a>
                </div>
                <?= $this->session->flashdata('msg_pass') ?>
              </div>
              <button class="btn btn-success rounded-15 py-2 px-3 mb-3">Masuk</button>
              <div>
                <span>Belum punya akun?</span>
                <a href="auth/register" class="fw-bold text-success">Daftar Disini</a>
              </div>
            </div>
          </div>

        </form>
      </div>