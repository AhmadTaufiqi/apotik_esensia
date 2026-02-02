<aside class="sidebar-left border-right bg-white shadow" id="leftSidebar" data-simplebar="init">
  <div class="simplebar-wrapper" style="margin: 0px;">
    <div class="simplebar-height-auto-observer-wrapper">
      <div class="simplebar-height-auto-observer"></div>
    </div>
    <div class="simplebar-mask">
      <div class="simplebar-offset" style="right: 0px; bottom: 0px;">
        <div class="simplebar-content-wrapper" style="height: 100%; overflow: hidden;">
          <div class="simplebar-content" style="padding: 0px;">
            <nav class="vertnav navbar navbar-light">
              <!-- nav bar -->
              <div class="w-100 mb-4 d-flex">
                <a class="navbar-brand mx-auto text-center" href="<?= base_url()?>admin/dashboard">
                  <img class="logo1" width="120" src="<?= base_url()?>dist/img/logo-esensia-full.png" alt="">
                  <img class="logo2" width="50" src="<?= base_url()?>dist/img/logo.png" alt="">
                </a>
              </div>
              <ul class="navbar-nav flex-fill w-100 mb-2" style="border-bottom:solid 1px #e9e9e9">
                <li class="nav-item w-100 <?= $this->uri->segment(1) == 'dashboard' ? 'active' : ''?>">
                  <a href="<?= base_url()?>dashboard" class="nav-link">
                    <i class="fas fa-th fa-lg"></i>
                    <span class="ml-2 item-text">Dashboard</span>
                  </a>
                </li>
              </ul>
              <ul class="navbar-nav flex-fill w-100 mb-2">
                <li class="nav-item w-100 <?= $this->uri->segment(1) == 'admin_products' ? 'active' : ''?>">
                  <a href="<?= base_url()?>admin_products" class="nav-link">
                    <i class="fas fa-boxes-stacked fa-lg"></i>
                    <span class="ml-2 item-text">Produk</span>
                  </a>
                </li>
              </ul>
              <ul class="navbar-nav flex-fill w-100 mb-2">
                <li class="nav-item w-100 <?= $this->uri->segment(1) == 'admin_cat' ? 'active' : ''?>">
                  <a href="<?= base_url()?>admin_cat" class="nav-link">
                    <i class="fas fa-boxes-stacked fa-lg"></i>
                    <span class="ml-2 item-text">Kategori Produk</span>
                  </a>
                </li>
              </ul>
              <ul class="navbar-nav flex-fill w-100 mb-2">
                <li class="nav-item w-100 <?= $this->uri->segment(1) == 'admin_orders' ? 'active' : ''?>">
                  <a href="<?= base_url()?>admin_orders" class="nav-link">
                    <i class="fas fa-boxes-stacked fa-lg"></i>
                    <span class="ml-2 item-text">Pesanan</span>
                  </a>
                </li>
              </ul>
              <ul class="navbar-nav flex-fill w-100 mb-2">
                <li class="nav-item w-100 <?= $this->uri->segment(1) == 'admin_user' ? 'active' : ''?>">
                  <a href="<?= base_url()?>admin_user" class="nav-link">
                    <i class="fas fa-users fa-lg"></i>
                    <span class="ml-2 item-text">Manajemen User</span>
                  </a>
                </li>
              </ul>
              <div class="btn-box w-100 mb-1 text-center" style="margin-top:50%;">
                <a href="<?= base_url()?>admin/auth/logout" class="btn btn-light p-3 rounded-2">
                  <i class="fas fa-power-off fa-2x"></i>
                </a>
              </div>
            </nav>
          </div>
        </div>
      </div>
    </div>
    <div class="simplebar-placeholder" style="width: 223px; height: 784px;"></div>
  </div>
  <div class="simplebar-track simplebar-horizontal" style="visibility: hidden;">
    <div class="simplebar-scrollbar" style="width: 0px; display: none;"></div>
  </div>
  <div class="simplebar-track simplebar-vertical" style="visibility: hidden;">
    <div class="simplebar-scrollbar" style="height: 0px; display: none;"></div>
  </div>
</aside>