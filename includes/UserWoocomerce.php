<?php
class UserWoocommerceCustom
{
    public function __construct()
    {
        add_filter('woocommerce_locate_template', array($this, 'adn_custom__checkout', 20, 3));
        add_filter('woocommerce_form_field_args', array($this, 'adn_custom_woocommerce_input_class', 10, 3));
        add_action('woocommerce_order_status_completed', array($this, 'adn__check_enable_registration'));
        add_action('template_redirect', array($this,'adn__add_product_checkout'));
        add_action('woocommerce_thankyou', array($this, 'adn_status__cheque', 10, 1));
    }

    public function adn_custom__checkout($template, $template_name, $template_path)
    {
        if ('checkout/form-checkout.php' == $template_name) {
            $template = plugin_dir_path(__FILE__) . 'templates/checkout/form-checkout.php';
        }
        if ('checkout/review-order.php' == $template_name) {
            $template = plugin_dir_path(__FILE__) . 'templates/checkout/review-order.php';
        }
        return $template;
    }

    public function adn_custom_woocommerce__input_class($args, $key, $value)
    {

        if ($key === 'billing_states') {
            $args['input_class'] = array('form-select');
        } elseif (in_array($key, array('billing_first_name', 'billing_last_name', 'billing_city', 'billing_postcode', 'billing_phone', 'billing_email', 'billing_address_1'))) {
            $args['input_class'][] = 'form-control';
        }
        return $args;
    }

    public function adn_custom_checkout__user_fullfil($fields)
    {

        if (is_user_logged_in()) {
            $current_user = wp_get_current_user();

            $fields['billing']['billing_first_name']['default'] = $current_user->first_name;
            $fields['billing']['billing_last_name']['default'] = $current_user->last_name;
            $fields['billing']['billing_email']['default'] = $current_user->user_email;
            $fields['billing']['billing_phone']['default'] = get_user_meta($current_user->ID, 'billing_phone', true);
            $fields['billing']['billing_address_1']['default'] = get_user_meta($current_user->ID, 'billing_address_1', true);
            $fields['billing']['billing_city']['default'] = get_user_meta($current_user->ID, 'billing_city', true);
            $fields['billing']['billing_postcode']['default'] = get_user_meta($current_user->ID, 'billing_postcode', true);
            $fields['billing']['billing_state']['default'] = get_user_meta($current_user->ID, 'billing_state', true);
        
        }

        unset($fields['billing']['billing_country']);
        unset($fields['shipping']['shipping_country']);

        return $fields;
    }

    public function adn_status__cheque($order_id)
    {
        if (!$order_id) {
            return;
        }

        $order = wc_get_order($order_id);
        if ($order->get_payment_method() === 'cheque') {
            $order->update_status('completed');
        }
    }

    public function adn_add__product_checkout()
    {
        if (isset($_POST['product_id'])) {
            if (class_exists('WooCommerce')) {
                if (is_admin() || is_ajax() || is_post_type_archive('product') || is_singular('product')) {
                    return;
                }

                global $woocommerce;

                $woocommerce->cart->empty_cart();

                $product_id = intval($_POST['product_id']);
                $woocommerce->cart->add_to_cart($product_id);

                wp_redirect(wc_get_checkout_url());
                exit;
            }
        }
    }

    public function adn__check_enable_registration($order_id)
    {
        $product_ids = array(110, 109, 26, 203);
        $order = wc_get_order($order_id);

        if ($order) {
            $user_id = $order->get_customer_id();

            foreach ($order->get_items() as $item_id => $item) {
                if (in_array($item->get_product_id(), $product_ids)) {
                    update_user_meta($user_id, 'can_register_users', true);
                    break;
                }
            }
        }
    }
}

new UserWoocommerceCustom();