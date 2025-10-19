<nav class="topnav navbar fixed-top bg-white">
  <button type="button" class="navbar-toggler mt-2 p-0 mr-3 collapseSidebar">
    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" class="iconify iconify--jam flip_icon" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="-5 -7 24 24" data-icon="jam:menu" style="font-size: 38px;">
      <path fill="currentColor" d="M1 0h5a1 1 0 1 1 0 2H1a1 1 0 1 1 0-2m7 8h5a1 1 0 0 1 0 2H8a1 1 0 1 1 0-2M1 4h12a1 1 0 0 1 0 2H1a1 1 0 1 1 0-2"></path>
    </svg>
  </button>
  <?php
  if (isset($navbar_element)) {
    $this->load->view("layouts/navbar_element/$navbar_element");
  } ?>
  <ul class="nav ml-auto">
    <li class="nav-item">
      <a class="btn bg-light text-muted my-2 p-2" href="<?= base_url('admin/profile') ?>">
        <span class="fa fa-gear d-block"></span>
      </a>
    </li>
    <li class="nav-item">
      <div class="nav-link text-muted pr-2">
        <!-- <span class="avatar avatar-sm"> -->
        <div class="avatar rounded" style="width: 32px;height:32px; overflow:hidden;">
          <img src="<?= base_url('dist/img/uploads/users/' . $this->session->userdata('foto_akun')) ?>" alt="..." class="avatar-img" width="115%" style="text-align:center;margin-left:-3px;">
        </div>
        <!-- </span> -->
      </div>
    </li>
  </ul>
</nav>