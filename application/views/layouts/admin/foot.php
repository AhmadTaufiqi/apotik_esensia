    </div>
    <div class="offcanvas offcanvas-end responsive rounded-4" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
      <div class="offcanvas-header pb-0 justify-content-start">
        <button type="button" class="btn-close text-reset me-2" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        <h5 id="offcanvasRightLabel" class="m-0">Keranjang Kamu <span>(2)</span></h5>
      </div>
      <div class="offcanvas-body">
        <div class="d-flex flex-column h-100">
          <div class="col-4 p-1">
            <div class="card card-product">
              <div>
                <div class="product-image">
                  <img src="<?= base_url() ?>dist/img/products/lacto-b.jpg" alt="">
                </div>
                <p class="product-name">Nama Obat</p>
              </div>
              <!-- kalau ada promo maka class .price-promo muncul -->
              <div class="px-2 pb-2">
                <?php $price = 9000 ?>
                <small class="price-promo">Rp. <?= number_format($price, 0, '', '.') ?></small>
                <p class="price">Rp.<?= number_format($price - ($price * 20 / 100), 0, '', '.') ?></p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- modal resizer image -->
    <div class="modal fade" id="modal_product_resizer" tabindex="-1" role="dialog" aria-labelledby="verticalModalTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document" style="max-width:700px">
        <div class="modal-content">
          <div class="modal-header">
            <h3>Potong Foto Produk</h3>
          </div>
          <div class="modal-body">
            <div class="row text-center">
              <div class="col">
                <img src="" alt="" id="img_product_cropper" height="250px">
              </div>
              <div class="col">
                <img src="" alt="" id="output_product_resizer" height="250px">
              </div>
            </div>
          </div>
          <div class="modal-footer py-1">
            <button id="btn_cropper" class="btn btn-success rounded-2 text-light">preview</button>
            <button id="submit_product_cropper" class="btn btn-primary rounded-2">Submit</button>
          </div>
        </div>
      </div>
    </div>
    <!-- end modal resizer image -->

    <!-- modal resizer profile image -->
    <div class="modal fade" id="modal_resizer" tabindex="-1" role="dialog" aria-labelledby="verticalModalTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document" style="max-width:700px">
        <div class="modal-content">
          <div class="modal-header">
            <h3>Potong foto profil</h3>
          </div>
          <div class="modal-body">
            <div class="row text-center">
              <div class="col">
                <img src="" alt="" id="img_cropper" height="250px">
              </div>
              <div class="col">
                <img src="" alt="" id="output_resizer" height="250px">
              </div>
            </div>
          </div>
          <div class="modal-footer py-1">
            <button id="btn_cropper" class="btn btn-success rounded-2 text-light">preview</button>
            <button id="submit_cropper" class="btn btn-primary rounded-2">Submit</button>
          </div>
        </div>
      </div>
    </div>
    <!-- end modal resizer image -->
    </main>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>
    <script src="<?= base_url() ?>dist/js/jquery.stickOnScroll.js"></script>
    <script src="<?= base_url() ?>dist/js/apps.js"></script>
    <script src="<?= base_url() ?>dist/cropperjs/dist/cropper.js"></script>
    <script src="<?= base_url() ?>dist/js/app.js"></script>
    <script src="<?= base_url() ?>dist/js/cart.js"></script>
    <script src="<?= base_url() ?>dist/js/uploadfile.js"></script>

    <?php if ($this->session->userdata('id_akun') == $this->session->userdata('msg_akun')) {
      if ($this->session->userdata('status') == 200) { ?>
        <script>
          $(function() {
            $('#sukses_simpan').modal('show')
          })
        </script>
      <?php } else if ($this->session->userdata('status') == 400) { ?>
        <script>
          $(function() {
            $('#gagal_simpan').modal('show')
          })
        </script>
    <?php }
    }
    $this->session->unset_userdata('status');
    $this->session->unset_userdata('message');
    $this->session->unset_userdata('msg_akun'); ?>

    <script>
      $(document).ready(function() {
        $('.datatable').DataTable({
          responsive: true,
          language: {
            url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json'
          }
        });

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

      $('.alert').delay(4000).slideUp(400, function() {
        $(this).alert('close');
      });
    </script>
    </body>

    </html>