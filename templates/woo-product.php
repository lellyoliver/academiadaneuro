<?php
/**
 * Template Name: WooProduct
 */

 include_once plugin_dir_path(__FILE__) . 'header-custom.php';


 if (have_posts()) :
    while (have_posts()) :
        the_post();

        // Obtém o ID do produto atual
        $product_id = get_the_ID();

        // Obtém o objeto do produto
        $product = wc_get_product($product_id);

        if ($product) :
            // Exibe o título do produto
            echo '<h1>' . esc_html($product->get_name()) . '</h1>';

            // Exibe a descrição do produto
            echo '<div class="product-description">' . wp_kses_post($product->get_description()) . '</div>';

            // Exibe o preço do produto
            echo '<p>Preço: ' . wc_price($product->get_price()) . '</p>';

            // Exibe o botão Adicionar ao Carrinho
            echo '<div class="add-to-cart-button">';
            woocommerce_template_loop_add_to_cart(array('product_id' => $product_id));
            echo '</div>';

        else :
            echo 'Produto não encontrado.';
        endif;

    endwhile;
endif;

get_footer();
?>



