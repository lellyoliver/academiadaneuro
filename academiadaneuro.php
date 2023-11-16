<?php
/**
 * Plugin Name: Academia da Neuro
 * Description: Plataforma de Neurociência
 * Version: 1.0.0
 * Author: <a href="https://github.com/lellyoliver/academiadaneuro">Lelly Oliver</a>
 * URL: https://github.com/lellyoliver/academiadaneuro
 *
 * This is the main file of the Academia da Neuro plugin. It defines plugin settings and functionality.
 */

if (!defined('ABSPATH')) {
    exit; // Prevents direct access to the file.
}

/**
 * Includes plugin endpoints.
 */
require_once plugin_dir_path(__FILE__) . 'includes/init.php';

function adn_scripts()
{
    wp_enqueue_style('stylecss', plugins_url('assets/css/style.css', __FILE__), array(), '1.0.0', false);
    wp_enqueue_script('utilsjs', plugins_url('assets/js/utils.js', __FILE__), '1.0.0', true);

    if (is_page(18)) {
        wp_enqueue_script('userrelatedutilsjs', plugins_url('assets/js/users-related/user-related-utils.js', __FILE__), '1.0.0', true);
        wp_enqueue_script('userRelatedjs', plugins_url('assets/js/users-related/user-related.js', __FILE__), '1.0.0', true);
        wp_enqueue_style('sweetAlert2Mincss', plugins_url('assets/lib/sweet-alert-2/sweetalert2.min.css', __FILE__), array(), '11.7.31', false);
        wp_enqueue_script('sweetAlert2Minjs', plugins_url('assets/lib/sweet-alert-2/sweetalert2.all.min.js', __FILE__), '11.7.31', false);

    }
    if (is_page(11)) {
        wp_enqueue_script('userjs', plugins_url('assets/js/users/user.js', __FILE__), '1.0.0', true);
    }
    if (is_page(44)) {
        wp_enqueue_script('userjs', plugins_url('assets/js/users/user.js', __FILE__), '1.0.0', true);
        wp_enqueue_style('sweetAlert2Mincss', plugins_url('assets/lib/sweet-alert-2/sweetalert2.min.css', __FILE__), array(), '11.7.31', false);
        wp_enqueue_script('sweetAlert2Minjs', plugins_url('assets/lib/sweet-alert-2/sweetalert2.all.min.js', __FILE__), '11.7.31', false);

    }
    if (is_page(154)) {
        wp_enqueue_script('userTrainingjs', plugins_url('assets/js/training/user-training.js', __FILE__), '1.0.0', true);
        wp_enqueue_style('sweetAlert2Mincss', plugins_url('assets/lib/sweet-alert-2/sweetalert2.min.css', __FILE__), array(), '11.7.31', false);
        wp_enqueue_script('sweetAlert2Minjs', plugins_url('assets/lib/sweet-alert-2/sweetalert2.all.min.js', __FILE__), '11.7.31', false);

    }
    if (is_single() && 'training' == get_post_type()) {
        wp_enqueue_script('userMyTrainingjs', plugins_url('assets/js/training/user-myTraining.js', __FILE__), '1.0.0', true);
        //sweet-alert-2
        wp_enqueue_style('sweetAlert2Mincss', plugins_url('assets/lib/sweet-alert-2/sweetalert2.min.css', __FILE__), array(), '11.7.31', false);
        wp_enqueue_script('sweetAlert2Minjs', plugins_url('assets/lib/sweet-alert-2/sweetalert2.all.min.js', __FILE__), '11.7.31', false);
        
        //plyr
        wp_enqueue_style('sweetAlert2Mincss', plugins_url('assets/lib/plyr/plyr.css', __FILE__), array(), '3.6.8', false);
        wp_enqueue_script('sweetAlert2Minjs', plugins_url('assets/lib/plyr/plyr.js', __FILE__), '3.6.8', false);

    }

    //Bootstrap
    wp_enqueue_script('bootstrapbundlejs', plugins_url('assets/lib/bootstrap/bootstrap.bundle.js', __FILE__), '5.0.2', true);
    wp_enqueue_script('popperjs', plugins_url('assets/lib/bootstrap/popper.min.js', __FILE__), '2.9.2', true);

    //Bootstrap-table
    if (is_page(18)) {
        wp_enqueue_style('bootstraptablemincss', plugins_url('assets/lib/bootstrap-table/bootstrap-table.min.css', __FILE__), array(), '1.22.1', false);
        wp_enqueue_script('bootstraptableminjs', plugins_url('assets/lib/bootstrap-table/bootstrap-table.min.js', __FILE__), '1.22.1', true);
    }
}
add_action('wp_enqueue_scripts', 'adn_scripts');

/**
 * Override template for user registration page.
 */
function adn_page_register_user_related($template)
{
    if (get_the_ID() == 18) {
        $template_user_create_related = plugin_dir_path(__FILE__) . 'templates/user-create-related.php';
        if (file_exists($template_user_create_related)) {
            return $template_user_create_related;
        }
    }
    return $template;
}
add_filter('page_template', 'adn_page_register_user_related');

function adn_page_register_user($template)
{
    if (get_the_ID() == 11) {
        $template_user_create = plugin_dir_path(__FILE__) . 'templates/user-create.php';
        if (file_exists($template_user_create)) {
            return $template_user_create;
        }
    }
    return $template;
}
add_filter('page_template', 'adn_page_register_user');

/**
 * Override template for user perfil.
 */
function adn_page_perfil_user($template)
{
    if (get_the_ID() == 44) {
        $template_user_perfil = plugin_dir_path(__FILE__) . 'templates/user-perfil.php';
        if (file_exists($template_user_perfil)) {
            return $template_user_perfil;
        }
    }
    return $template;
}
add_filter('page_template', 'adn_page_perfil_user');

/**
 * Override template for dashboard page.
 */
function adn_page_dashboard($template)
{
    if (get_the_ID() == 30) {
        $template_dashboard = plugin_dir_path(__FILE__) . 'templates/dashboard.php';
        if (file_exists($template_dashboard)) {
            return $template_dashboard;
        }
    }
    return $template;
}
add_filter('page_template', 'adn_page_dashboard');

function adn_page_training($template)
{
    if (get_the_ID() == 154) {
        $current_user = wp_get_current_user();
        $allowed_roles_2 = ['coach', 'health-pro', 'administrator'];
        if (!array_intersect($allowed_roles_2, $current_user->roles)) {
            $template_training = plugin_dir_path(__FILE__) . 'templates/user-training.php';
        }else{
            $template_training = plugin_dir_path(__FILE__) . 'templates/user-training-choice.php';
        }
        if (file_exists($template_training)) {
            return $template_training;
        }
    }
    return $template;
}
add_filter('page_template', 'adn_page_training');

function adn_page_Mytraining($template)
{
    if (get_the_ID() == 114) {
        $template_Mytraining = plugin_dir_path(__FILE__) . 'templates/user-myTraining.php';
        if (file_exists($template_Mytraining)) {
            return $template_Mytraining;
        }
    }
    return $template;
}
add_filter('page_template', 'adn_page_Mytraining');

function adn_product_woo($template)
{
    if (is_singular('product')) {
        $template_wootemplate = plugin_dir_path(__FILE__) . 'templates/woo-product.php';

        if (file_exists($template_wootemplate)) {
            return $template_wootemplate;
        }
    }
    return $template;
}
add_filter('template_include', 'adn_product_woo');

function adn_training_single($template)
{
    if (is_singular('training')) {
        $template_wootemplate = plugin_dir_path(__FILE__) . 'templates/single-training.php';

        if (file_exists($template_wootemplate)) {
            return $template_wootemplate;
        }
    }
    return $template;
}
add_filter('template_include', 'adn_training_single');

/**
 * Page post_type "training" blocked
 */

function adn_training_single_blocked()
{
    if (!is_user_logged_in()) {
        if (is_singular('training')) {
            wp_redirect('/academiadaneurociencia/login/');
            exit;

        }
    }
}
add_action('template_redirect', 'adn_training_single_blocked');

/**
 * Include user roles
 */
require_once plugin_dir_path(__FILE__) . 'includes/Roles.php';

/**
 * Include Meta Custom User.
 */
require_once plugin_dir_path(__FILE__) . 'includes/MetaCustomUser.php';

/**
 * Include Meta Custom User.
 */
require_once plugin_dir_path(__FILE__) . 'includes/MetaCustomTraining.php';

/**
 * Include post_type.
 */
require_once plugin_dir_path(__FILE__) . 'includes/PostType.php';

/**
 * Compras
 */

function check_and_enable_registration($order_id)
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
add_action('woocommerce_order_status_completed', 'check_and_enable_registration');

/**
 * Create data Table
 */
function adn_activate_db()
{
    $dbCustom = new DBCustom();
    $dbCustom->createTableTrainingReplies();
    $dbCustom->createTableTrainingProgress();
}

register_activation_hook(__FILE__, 'adn_activate_db');

/**
 * Include Rewrite
 */

require_once plugin_dir_path(__FILE__) . 'includes/RewriteRules.php';

function adn_add_product_checkout()
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

add_action('template_redirect', 'adn_add_product_checkout');

function custom_login_redirect($redirect_to, $request, $user)
{
    if (is_a($user, 'WP_User')) {
        $user_roles = $user->roles;
        $dashboard_roles = array('health-pro', 'Coach');

        if (array_intersect($user_roles, $dashboard_roles)) {
            return home_url('/dashboard');
        } else {
            return home_url('/meus-treinamentos');
        }
    }
    return $redirect_to;
}
add_filter('login_redirect', 'custom_login_redirect', 10, 3);

/**
 * Woocomerce
 */

add_filter('woocommerce_locate_template', 'adn_custom__checkout', 20, 3);

function adn_custom__checkout($template, $template_name, $template_path)
{
    if ('checkout/form-checkout.php' == $template_name) {
        $template = plugin_dir_path(__FILE__) . 'templates/checkout/form-checkout.php';
    }
    if ('checkout/review-order.php' == $template_name) {
        $template = plugin_dir_path(__FILE__) . 'templates/checkout/review-order.php';
    }
    return $template;
}

function adn_custom_woocommerce_input_class($args, $key, $value)
{

    if ($key === 'billing_states') {
        $args['input_class'] = array('form-select');
    } elseif (in_array($key, array('billing_first_name', 'billing_last_name', 'billing_city', 'billing_postcode', 'billing_phone', 'billing_email', 'billing_address_1'))) {
        $args['input_class'][] = 'form-control';
    }
    return $args;
}

add_filter('woocommerce_form_field_args', 'adn_custom_woocommerce_input_class', 10, 3);

function adn_custom_checkout_user_fullfil($fields)
{
    // Verifique se o usuário está logado.
    if (is_user_logged_in()) {
        $current_user = wp_get_current_user();

        // Preencha os campos de endereço de faturamento com as informações do usuário atual.
        $fields['billing']['billing_first_name']['default'] = $current_user->first_name;
        $fields['billing']['billing_last_name']['default'] = $current_user->last_name;
        $fields['billing']['billing_email']['default'] = $current_user->user_email;
        $fields['billing']['billing_phone']['default'] = get_user_meta($current_user->ID, 'billing_phone', true);
        $fields['billing']['billing_address_1']['default'] = get_user_meta($current_user->ID, 'billing_address_1', true);
        $fields['billing']['billing_city']['default'] = get_user_meta($current_user->ID, 'billing_city', true);
        $fields['billing']['billing_postcode']['default'] = get_user_meta($current_user->ID, 'billing_postcode', true);
        $fields['billing']['billing_state']['default'] = get_user_meta($current_user->ID, 'billing_state', true);
        $fields['billing']['billing_country']['default'] = get_user_meta($current_user->ID, 'billing_country', true);
    }

    return $fields;
}
add_filter('woocommerce_checkout_fields', 'adn_custom_checkout_user_fullfil');
