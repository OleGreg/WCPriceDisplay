//Update Woocommerce Product Page Price with Quantity
// we are going to hook this on priority 31, so that it would display below add to cart button.
add_action( 'woocommerce_single_product_summary', 'woocommerce_total_product_price', 35 );
function woocommerce_total_product_price() {
    global $woocommerce, $product;
    // let's setup our divs
    echo sprintf('<div id="product_total_price" style="margin-bottom:20px;">%s %s</div>',__('Product Total:','woocommerce'),'<span class="price">'.$product->get_price().'</span>');
//    echo sprintf('<div id="cart_total_price" style="margin-bottom:20px;display:none">%s %s</div>',__('Cart Total:','woocommerce'),'<span class="price">'.$product->get_price().'</span>');

    if( $product->is_type( 'simple' ) || $product->is_type( 'subscription' ) && $product->get_price()>0 ){
        // No variations to product
        ?>
            <script>

                jQuery(function($){
                    var price = <?php echo $product->get_price(); ?>,
                        current_cart_total = <?php echo $woocommerce->cart->cart_contents_total; ?>,
                        currency = '<?php echo get_woocommerce_currency_symbol(); ?>';

                    $('[name=quantity]').change(function(){
                        if (!(this.value < 1)) {
                            var product_total = parseFloat(price * this.value),
                                cart_total = parseFloat(product_total + current_cart_total);


                            $('#product_total_price .price').html( currency + product_total.toFixed(2));
                            $('#cart_total_price .price').html( currency + cart_total.toFixed(2));
                        }
//                        $('#product_total_price,#cart_total_price').toggle(!(this.value <= 1));

                    });

                });

                jQuery(function($) {


                    $('input.addon').click( function () {

                        setTimeout(function() {
                            var test = $('.product-addon-totals').length;
                                if ($('.product-addon-totals').length) {
                                    $('#product_total_price').slideUp(500);
                                }
                                else {
                                    $('#product_total_price').slideDown(500);
                                }

                        }, 10);
                    });

                });

            </script>
        <?php
    } elseif( $product->is_type( 'variable' ) && $product->get_price()>0 ){
        // Product has variations
        ?>
            <script>

                jQuery(function($){
                    var current_cart_total = <?php echo $woocommerce->cart->cart_contents_total; ?>,
                        currency = '<?php echo get_woocommerce_currency_symbol(); ?>';

                    $('input[name=quantity]').change(function(){
                        if (!(this.value < 1)) {
                            var number = jQuery('.woocommerce-variation-price .woocommerce-Price-amount').text();
                            var price = number.substr(1).replace(/,/g , '');
                            var product_total = parseFloat(price * this.value),
                                cart_total = parseFloat(product_total + current_cart_total);

                            $('#product_total_price .price').html( currency + product_total.toFixed(2));
                            $('#cart_total_price .price').html( currency + cart_total.toFixed(2));
                        }
//                        $('#product_total_price,#cart_total_price').toggle(!(this.value <= 1));

                    });

                });

                jQuery(function($){
                    var current_cart_total = <?php echo $woocommerce->cart->cart_contents_total; ?>,
                        currency = '<?php echo get_woocommerce_currency_symbol(); ?>';

                    $('select').click(function(){
//                        if (!(this.value < 1)) {
                            var number = jQuery('.woocommerce-variation-price .woocommerce-Price-amount').text();
                            var price = number.substr(1).replace(/,/g , '');
                            var product_total = parseFloat(price * $('input[name=quantity]').val()),
                                cart_total = parseFloat(product_total + current_cart_total);

                            $('#product_total_price .price').html( currency + product_total.toFixed(2));
                            $('#cart_total_price .price').html( currency + cart_total.toFixed(2));
//                        }
//                        $('#product_total_price,#cart_total_price').toggle(!(this.value <= 1));

                    });

                });

                jQuery(function($) {


                    $('input.addon').click( function () {

                        setTimeout(function() {
                            var test = $('.product-addon-totals').length;
                            if ($('.product-addon-totals').length) {
                                $('#product_total_price').hide();
                            }
                            else {
                                $('#product_total_price').show();
                            }

                        }, 10);
                    });

                });


            </script>
        <?php
    }

}
