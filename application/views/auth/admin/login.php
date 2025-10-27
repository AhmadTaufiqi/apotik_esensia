<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

  <script src="https://code.iconify.design/2/2.2.1/iconify.min.js"></script>
  <link rel="stylesheet" href="<?= base_url() ?>dist/fontawesome/css/fontawesome.css" />
  <link rel="stylesheet" href="<?= base_url() ?>dist/fontawesome/css/brands.css" />
  <link rel="stylesheet" href="<?= base_url() ?>dist/fontawesome/css/solid.css" />
  <link rel="stylesheet" href="<?= base_url() ?>dist/fontawesome/css/regular.css" />
  <link rel="stylesheet" href="<?= base_url() ?>dist/css/feather.css" />

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.css">
  <link rel="stylesheet" href="<?= base_url() ?>dist/css/app-light.css">
  <link rel="stylesheet" href="<?= base_url() ?>dist/css/simplebar.css">
  <link rel="stylesheet" href="<?= base_url() ?>dist/css/login.css">
  <link rel="stylesheet" href="<?= base_url() ?>dist/cropperjs/dist/cropper.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700" rel="stylesheet" />

  <title>Document</title>
  <link href="<?= base_url() ?>dist/img/logo.png" rel="icon">
</head>

<body class="vertical light">
  <div class="wrapper">
    <div class="d-flex" style="height:100vh;">
      <div class="col-lg-5 d-flex flex-column justify-content-between p-3">
        <div class="d-flex align-items-center">
          <img class="mx-1" src="<?= base_url() ?>src/assets/images/semarang.png" alt="" height="50">
          <img class="mx-1" src="<?= base_url() ?>src/assets/images/dishub.png" alt="" height="50">
          <!-- <h3>Sistem Informasi Perparkiran Kota Semarang</h3> -->
        </div>

        <!-- Card Custom bg -->
        <div class="">
          <div class="w-50 mx-auto">
            <img width="160" src="<?= base_url() ?>src/assets/images/logo.png" alt="">
            <form class="mx-auto" method="POST" action="<?= base_url('admin/auth') ?>">
              <h2>Sign In</h2>
              <div class="form-group">
                <label for="inputEmail">Email</label>
                <div class="d-flex align-items-center">
                  <input type="text" id="inputEmail" name="email" class="form-control form-control-lg rounded-15" placeholder="Masukkan Email Anda" required="" autofocus="" style="padding-left:35px; font-size: 14px;">
                  <i class="form-icon fe fe-user"></i>
                </div>
                <?= $this->session->flashdata('msg') ?>
              </div>
              <div class="form-group">
                <label for="inputPassword">Password</label>
                <div class="d-flex align-items-center position-relative">
                  <input type="password" id="inputPassword" name="password" class="form-control form-control-lg rounded-15" placeholder="Password" required="" style="padding-left:35px; font-size: 14px;">
                  <i class="form-icon fe fe-key"></i>
                  <a role="button" class="password-show" data-show="0" style="color:#858585;right:5px;">
                    <i class="fe fe-eye-off" aria-hidden="true"></i>
                  </a>
                </div>
                <?= $this->session->flashdata('msg_pass') ?>
              </div>
              <!-- <div class="form-group d-flex">
              <input type="checkbox" class="custom_form_check" name="remember_me">
              <label for="checkbox">Ingat Saya</label>
            </div> -->
              <button class="btn btn-lg btn-primary btn-block rounded-2" type="submit">Masuk</button>
            </form>
            <div class="mt-4"><?= $this->session->flashdata('msg_login') ?></div>
          </div> <!-- .card -->
        </div>
        <!-- End Card Custom bg -->

        <div class="footer"><strong><?php echo (int)date('Y'); ?> </strong><span>© All Right reserved. CV Fun Teknologi</span></div>
      </div>
      <div class="col-lg-7 d-none d-lg-flex" style="background-image: url(<?= base_url() ?>dist/img/background_login.jpg);height: 100vh; background-size: cover; background-position: center;">
      </div>

    </div>
  </div>



  </main>
  <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
  <script src="<?= base_url() ?>dist/js/jquery.stickOnScroll.js"></script>
  <script src="<?= base_url() ?>dist/js/apps.js"></script>
  <script src="<?= base_url() ?>dist/js/app.js"></script>

  <script>
    $('.password-show').on('click', function() {
      if ($(this).attr('data-show') == 1) {
        $(this).attr('data-show', '0')
        $(this).siblings('input:first').attr("type", 'password')
        $(this).children('i').attr('class', 'fe fe-eye-off')
      } else {
        $(this).attr('data-show', '1')
        $(this).siblings('input:first').attr("type", 'text')
        $(this).children('i').attr('class', 'fe fe-eye')
      }
    })
  </script>
</body>

</html>