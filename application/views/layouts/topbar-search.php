<body>
  <div class="mobile-container">
    <div class="carousel">
      <div class="navbar px-2 bg-dark">
        <div class="container">
          <div class="card p-1 rounded-circle border-0 me-2">
            <img src="<?= base_url() ?>dist/img/logo.png" alt="" height="30" class="rounded-circle">
          </div>
          <div class="col pe-2">
            <?php if ($this->uri->segment(1) == 'home' || $this->uri->segment(1) == '') : ?>
              <div class="search-container">
                <input type="text" class="form-control search-input" placeholder="Search...">
                <i class="fas fa-search search-icon"></i>
              </div>
            <?php else : ?>
              <h5 class="color-esensia text-center mb-0 fw-bold"><?= $title ?></h5>
            <?php endif; ?>
          </div>

          <?php
          $oncart_orders = 0;
          if (!empty($total_my_cart)) {
            $oncart_orders = $total_my_cart;
          }
          ?>

          <a href="<?= base_url('cart') ?>" id="cart" data-totalitems="<?= $oncart_orders ?>" class="btn bg-white rounded-circle px-1 me-1" style="height: 40px; width:40px;">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-basket2-fill color-esensia" viewBox="0 0 16 16">
              <path d="M5.929 1.757a.5.5 0 1 0-.858-.514L2.217 6H.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h.623l1.844 6.456A.75.75 0 0 0 3.69 15h8.622a.75.75 0 0 0 .722-.544L14.877 8h.623a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1.717L10.93 1.243a.5.5 0 1 0-.858.514L12.617 6H3.383zM4 10a1 1 0 0 1 2 0v2a1 1 0 1 1-2 0zm3 0a1 1 0 0 1 2 0v2a1 1 0 1 1-2 0zm4-1a1 1 0 0 1 1 1v2a1 1 0 1 1-2 0v-2a1 1 0 0 1 1-1" />
            </svg>
          </a>
          <a href="<?= base_url() ?>profile" class="btn bg-white rounded-circle px-1 me-1" style="height: 40px; width:40px;">
            <i class="fas fa-user color-esensia"></i>
          </a>
        </div>
      </div>
    </div>