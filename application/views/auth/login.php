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
  <link rel="stylesheet" href="<?= base_url() ?>dist/css/style.css">
  <link rel="stylesheet" href="<?= base_url() ?>dist/cropperjs/dist/cropper.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700" rel="stylesheet" />

  <title>Document</title>
  <link href="<?= base_url() ?>dist/img/logo.png" rel="icon">
</head>

<body class="vertical light">
  <div class="warapper">
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
    $(document).ready(function() {
      $('.qty_input').prop('disabled', true);

      $('.plus-btn').click(function(e) {
        const input = $(this).prev();
        input.val(parseInt(input.val()) + 1);
      });
      $('.minus-btn').click(function(e) {
        const input = $(this).next();
        input.val(parseInt(input.val()) - 1);
        if (input.val() == 0) {
          input.val(1);
        }

      });
    });
  </script>
</body>

</html>