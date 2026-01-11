<body>
  <div class="mobile-container">
    <div class="carousel">
      <div class="navbar px-2 bg-dark">
        <a href="<?= isset($back_url) ? $back_url: base_url('home') ?>" class="card text-center justify-content-center rounded-circle border-0 me-2" style="height: 40px; width:40px;">
          <i class="fas fa-angle-left fa-xl color-esensia fw-bold"></i>
        </a>
        <div class="col pe-2">
          <h5 class="color-esensia text-center mb-0 fw-bold"><?= $title?></h5>
        </div>
        <a href="#" class="btn bg-white rounded-circle px-1" style="height: 40px; width:40px;">
          <i class="fas fa-info fa-xl color-esensia"></i>
        </a>
      </div>
    </div>