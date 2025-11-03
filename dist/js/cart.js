$(document).ready(function() {
  $('.btn-add-to-cart').on('click', function() {
    if (!is_login) {
      window.location = "auth/logout";
    }

    var button = $(this);
    var cart = $('#cart');
    var cartTotal = cart.attr('data-totalitems');
    var product_id = button.attr('data-product-id');

    var product_id = $(this).data('product-id');

    $.post({
      url: 'cart/addToCart',
      data: {
        'product_id': product_id
      },
      success: function(result) {
        var data = JSON.parse(result);
        if(data.success){
          var newCartTotal = parseInt(cartTotal) + 1;

          button.addClass('sendtocart');
          setTimeout(function() {
            button.removeClass('sendtocart');
            cart.addClass('shake').attr('data-totalitems', newCartTotal);
            setTimeout(function() {
              cart.removeClass('shake');
            }, 500)
          }, 200)
        }
      }
    })
  })

  $('.btn_delete_product_cart').on('click', function(){
    var cart_product_id = $(this).data('cartProductId');

    $('#confirm_cart_product_id').val(cart_product_id)

    $('#modal_confirm_delete').modal('show');
  })

  $('#select_all_product_cart').on('click', function(){

    if ($(this).is(':checked')) {
      $('#form_cart_products .cb_product_cart').prop('checked', true);
    } else {
      $('#form_cart_products .cb_product_cart').prop('checked', false);
    }

    setFinalPrices();
  })

  $('.card-product-cart').on('click', function(e){
    var prod_div = $(this);

      var qty = prod_div.find('.qty_input').val();
      var single_price = (prod_div.data('singlePrice') * qty).toLocaleString('id');
      var single_raw_price = (prod_div.data('singleRawPrice') * qty).toLocaleString('id');
      
      prod_div.find('.total_price').html('Rp. ' + single_price);
      prod_div.find('.raw_total_price').html('Rp. ' + single_raw_price);

      setFinalPrices();
  })

  $('.cb_product_cart').on('click', function(e){
    console.log($(this))
    var check = true;
    $('.cb_product_cart').each(function(e){
      var is_checked = $(this).is(':checked')

      if(!is_checked){
        check = false;
        return;
      }
    })
    console.log('check all= '+ check);
    console.log(check);
    $('#select_all_product_cart').prop('checked', check);

    setFinalPrices();
  })

  function setFinalPrices(){
    var total_price = 0;

    $('.cb_product_cart').each(function(e){
      var is_checked = $(this).is(':checked')
      
      if (is_checked) {
        var parent = $(this).parents('.card-product-cart');
        var qty_input = parent.find('.qty_input').val();
        total = parent.data('singlePrice');

        total_price = total_price + (total * qty_input);
      }
    })

    $('#total_price_cart').html('Rp. ' + total_price.toLocaleString('id'))
  }

  // $('.cb_product_cart').is(':checked', function(e){
  // })
})

// function addtoCart($id){
//   $.ajax({
//     url: "/cart/add",
//     data: {
//       id
//     },
//     success: function( result ) {
//       $( "#weather-temp" ).html( "<strong>" + result + "</strong> degrees" );
//     }
//   });
// }