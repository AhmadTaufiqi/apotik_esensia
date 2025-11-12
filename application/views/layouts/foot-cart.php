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


    <!-- modal resizer profile image -->
    <div class="modal fade" id="modal_resizer" tabindex="-1" role="dialog" aria-labelledby="verticalModalTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document" style="max-width:350px">
        <div class="modal-content">
          <div class="modal-header">
            <h3>Potong foto profil</h3>
          </div>
          <div class="modal-body">
            <div class="row justify-content-center">
              <div class="col">
                <img src="" alt="" id="img_cropper" height="250px">
              </div>
            </div>
          </div>
          <div class="modal-footer py-1">
            <button id="submit_cropper" class="btn btn-primary rounded-2">Submit</button>
          </div>
        </div>
      </div>
    </div>
    <!-- end modal resizer image -->


    <!-- modal confirm delete -->
    <div id="modal_confirm_delete" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="verticalModalTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document" style="max-width:360px">
        <div class="modal-content rounded-2">
          <form action="<?= base_url() ?>cart/deleteProductCart" method="POST">
            <div class="modal-header bg-danger p-2" style="border-radius: 1rem 1rem 0 0;">
              <h5 class="text-white mb-0">Hapus Produk</h5>
            </div>
            <div class="modal-body">
              <h6>Hapus Produk Dari Keranjang?</h6>
              <input type="text" name="cart_product_id" id="confirm_cart_product_id">

            </div>
            <div class="modal-footer text-end p-2">
              <button class=" btn btn-secondary rounded-2" data-bs-dismiss="modal">Batal</button>
              <button type="submit" class="btn btn-primary rounded-2">Hapus</button>
            </div>

          </form>
        </div>
      </div>
    </div>
    <!-- end of modal confirm delete -->
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>

    <script src="<?= base_url() ?>dist/leafletjs/leaflet.js"></script>
    <script src="<?= base_url() ?>dist/leaflet-routing-machine/dist/leaflet-routing-machine.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>

    <script src="<?= base_url() ?>dist/cropperjs/dist/cropper.js"></script>
    <script src="<?= base_url() ?>dist/js/cart.js"></script>
    <script src="<?= base_url() ?>dist/js/app.js"></script>
    <script>
      $(document).ready(function() {

        $('.qty_input').prop('readonly', true);

        $('.plus-btn').click(function(e) {
          const input = $(this).prev();
          const cart_id = input.data('cart-id');
          input.val(parseInt(input.val()) + 1);
          updateQty(input.val(), cart_id);
        });
        $('.minus-btn').click(function(e) {
          const input = $(this).next();
          const cart_id = input.data('cart-id');
          input.val(parseInt(input.val()) - 1);

          if (input.val() == 0) {
            input.val(1);
          }
          updateQty(input.val(), cart_id);
        });
      });

      function updateQty(qty, cart_id) {

        $.post({
          url: 'updateProdQty',
          data: {
            cart_id,
            qty
          },
          success: function(result) {
            // console.log(result)
          }
        })
      }
    </script>
    </body>


    </html>