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
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    <script src="<?= base_url() ?>dist/js/cart.js"></script>
    <script>
      $(document).ready(function() {
        $('.qty_input').prop('readonly', true);

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