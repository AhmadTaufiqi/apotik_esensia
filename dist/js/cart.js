$(document).ready(function() {
  $('.btn-add-to-cart').on('click', function() {
    var button = $(this);
    var cart = $('#cart');
    var cartTotal = cart.attr('data-totalitems');
    var product_id = button.attr('data-product-id');
    console.log(product_id);
    console.log('is_login='+is_login);

    var newCartTotal = parseInt(cartTotal) + 1;

    button.addClass('sendtocart');
    setTimeout(function() {
      button.removeClass('sendtocart');
      cart.addClass('shake').attr('data-totalitems', newCartTotal);
      setTimeout(function() {
        cart.removeClass('shake');
      }, 500)
    }, 200)
  })
})

function addtoCart($id){
  $.ajax({
    url: "/cart/add",
    data: {
      id
    },
    success: function( result ) {
      $( "#weather-temp" ).html( "<strong>" + result + "</strong> degrees" );
    }
  });
}