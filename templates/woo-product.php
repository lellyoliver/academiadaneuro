<?php
/**
 * Template Name: WooProduct
 */

include_once plugin_dir_path(__FILE__) . 'header-custom.php';

if (have_posts()):
    while (have_posts()):
        the_post();

        $product_id = get_the_ID();

        $product = wc_get_product($product_id);

        if ($product):
            echo '<h1>' . esc_html($product->get_name()) . '</h1>';
            echo '<div class="product-description">' . wp_kses_post($product->get_description()) . '</div>';
            echo '<p>Preço: ' . wc_price($product->get_price()) . '</p>';
            echo '<div class="add-to-cart-button">';
            woocommerce_template_loop_add_to_cart(array('product_id' => $product_id));
            echo '</div>';

        else:
            echo 'Produto não encontrado.';
        endif;

    endwhile;
endif;

get_footer();