<?php
/**
 * Plugin Name: Academia da Neuro
 * Description: Plataforma de Neurociência
 * Version: 1.0.0
 * Author: <a href="https://github.com/lellyoliver">Lelly Oliver</a>
 * URL: https://github.com/lellyoliver/academiadaneuro
 *
 * This is the main file of the Academia da Neuro plugin. It defines plugin settings and functionality.
 */

if (!defined('ABSPATH')) {
    exit; // Prevents direct access to the file.
}

define('ACADEMIA_DA_NEURO_VERSION', '1.0.0');

/**
 * Includes plugin endpoints.
 */

require_once plugin_dir_path(__FILE__) . 'includes/init.php';

require_once plugin_dir_path(__FILE__) . 'includes/Roles.php';

require_once plugin_dir_path(__FILE__) . 'includes/MetaCustomUser.php';

require_once plugin_dir_path(__FILE__) . 'includes/MetaCustomTraining.php';

require_once plugin_dir_path(__FILE__) . 'includes/TrainingPostType.php';

require_once plugin_dir_path(__FILE__) . 'includes/CustomerSupportPostType.php';

require_once plugin_dir_path(__FILE__) . 'includes/RewriteRules.php';

require_once plugin_dir_path(__FILE__) . 'includes/db.php';

require_once plugin_dir_path(__FILE__) . 'includes/CreatePages.php';

require_once plugin_dir_path(__FILE__) . 'includes/NotificationUser.php';

require_once plugin_dir_path(__FILE__) . 'includes/RefundedManager.php';

require_once plugin_dir_path(__FILE__) . 'includes/SettingsAcademia.php';


function adn_activate()
{
    $dbCustom = new DBCustom();
    $createPages = new CreatePages();
    $createPages->create_pages();
    $dbCustom->createTableTrainingReplies();
    $dbCustom->createTableTrainingProgress();
}

register_activation_hook(__FILE__, 'adn_activate');

function adn_scripts()
{

    wp_enqueue_style('stylecss', plugins_url('assets/css/style.css', __FILE__), array(), ACADEMIA_DA_NEURO_VERSION, false);
    wp_enqueue_script('utilsjs', plugins_url('assets/js/utils.js', __FILE__), ACADEMIA_DA_NEURO_VERSION, true);

    //Bootstrap
    wp_enqueue_script('bootstrapbundlejs', plugins_url('assets/lib/bootstrap/bootstrap.bundle.js', __FILE__), '5.0.2', true);
    wp_enqueue_script('popperjs', plugins_url('assets/lib/bootstrap/popper.min.js', __FILE__), '2.9.2', true);

    if (is_page('register')) {
        wp_enqueue_script('usercreatejs', plugins_url('assets/js/users/user-create.js', __FILE__), ACADEMIA_DA_NEURO_VERSION, true);
        wp_enqueue_script('userUtilsjs', plugins_url('assets/js/users/user-utils.js', __FILE__), ACADEMIA_DA_NEURO_VERSION, true);
        wp_enqueue_style('sweetAlert2Mincss', plugins_url('assets/lib/sweet-alert-2/sweetalert2.min.css', __FILE__), array(), '11.7.31', false);
        wp_enqueue_script('sweetAlert2Minjs', plugins_url('assets/lib/sweet-alert-2/sweetalert2.all.min.js', __FILE__), '11.7.31', false);
    }

    if (is_page('new-order')) {
        wp_enqueue_script('userjs', plugins_url('assets/js/users/user.js', __FILE__), ACADEMIA_DA_NEURO_VERSION, true);
        wp_enqueue_script('userUtilsjs', plugins_url('assets/js/users/user-utils.js', __FILE__), ACADEMIA_DA_NEURO_VERSION, true);
        wp_enqueue_style('sweetAlert2Mincss', plugins_url('assets/lib/sweet-alert-2/sweetalert2.min.css', __FILE__), array(), '11.7.31', false);
        wp_enqueue_script('sweetAlert2Minjs', plugins_url('assets/lib/sweet-alert-2/sweetalert2.all.min.js', __FILE__), '11.7.31', false);
    }

    if (is_page('email-confirmation') || is_page('login') || is_page('forgot-password')) {
        wp_enqueue_script('authjs', plugins_url('assets/js/auth/auth.js', __FILE__), ACADEMIA_DA_NEURO_VERSION, false);
    }

    if (is_page('novo-treinamento')) {
        wp_enqueue_script('userTrainingjs', plugins_url('assets/js/training/user-training.js', __FILE__), ACADEMIA_DA_NEURO_VERSION, true);
        wp_enqueue_style('sweetAlert2Mincss', plugins_url('assets/lib/sweet-alert-2/sweetalert2.min.css', __FILE__), array(), '11.7.31', false);
        wp_enqueue_script('sweetAlert2Minjs', plugins_url('assets/lib/sweet-alert-2/sweetalert2.all.min.js', __FILE__), '11.7.31', false);
    }

    if (is_single() && 'training' == get_post_type()) {
        wp_enqueue_script('userMyTrainingjs', plugins_url('assets/js/training/user-myTraining.js', __FILE__), ACADEMIA_DA_NEURO_VERSION, true);
        wp_enqueue_style('sweetAlert2Mincss', plugins_url('assets/lib/sweet-alert-2/sweetalert2.min.css', __FILE__), array(), '11.7.31', false);
        wp_enqueue_script('sweetAlert2Minjs', plugins_url('assets/lib/sweet-alert-2/sweetalert2.all.min.js', __FILE__), '11.7.31', false);
    }

    if (is_page('meus-pacientes')) {
        wp_enqueue_script('jquery');
        wp_enqueue_style('bootstraptablemincss', plugins_url('assets/lib/bootstrap-table/bootstrap-table.min.css', __FILE__), array(), '1.22.1', false);
        wp_enqueue_script('bootstraptableminjs', plugins_url('assets/lib/bootstrap-table/bootstrap-table.min.js', __FILE__), '1.22.1', true);
        wp_enqueue_script('userrelatedutilsjs', plugins_url('assets/js/users-related/user-related-utils.js', __FILE__), ACADEMIA_DA_NEURO_VERSION, true);
        wp_enqueue_script('userRelatedjs', plugins_url('assets/js/users-related/user-related.js', __FILE__), ACADEMIA_DA_NEURO_VERSION, true);
        wp_enqueue_style('sweetAlert2Mincss', plugins_url('assets/lib/sweet-alert-2/sweetalert2.min.css', __FILE__), array(), '11.7.31', false);
        wp_enqueue_script('sweetAlert2Minjs', plugins_url('assets/lib/sweet-alert-2/sweetalert2.all.min.js', __FILE__), '11.7.31', false);
    }

    if (is_page('meu-perfil')) {
        wp_enqueue_script('userjs', plugins_url('assets/js/users/user.js', __FILE__), ACADEMIA_DA_NEURO_VERSION, true);
        wp_enqueue_style('sweetAlert2Mincss', plugins_url('assets/lib/sweet-alert-2/sweetalert2.min.css', __FILE__), array(), '11.7.31', false);
        wp_enqueue_script('sweetAlert2Minjs', plugins_url('assets/lib/sweet-alert-2/sweetalert2.all.min.js', __FILE__), '11.7.31', false);
        wp_enqueue_script('compressorminjs', plugins_url('assets/lib/compressor/compressor.min.js', __FILE__), '1.0.7', false);
    }

    if (is_page('suporte-cliente')) {
        wp_enqueue_script('customerSupportjs', plugins_url('assets/js/customer-support/customer-support.js', __FILE__), ACADEMIA_DA_NEURO_VERSION, true);
        wp_enqueue_style('sweetAlert2Mincss', plugins_url('assets/lib/sweet-alert-2/sweetalert2.min.css', __FILE__), array(), '11.7.31', false);
        wp_enqueue_script('sweetAlert2Minjs', plugins_url('assets/lib/sweet-alert-2/sweetalert2.all.min.js', __FILE__), '11.7.31', false);
    }

    if(is_page('dashboard')){
        wp_enqueue_script('customerSupportjs', plugins_url('assets/js/dashboard/dashboard.js', __FILE__), ACADEMIA_DA_NEURO_VERSION, true);
    }

    if (is_checkout()) {
        wp_enqueue_script('checkoutjs', plugins_url('assets/js/checkout/checkout.js', __FILE__), ACADEMIA_DA_NEURO_VERSION, false);
    }

}
add_action('wp_enqueue_scripts', 'adn_scripts');

function roleRegistered()
{
    $current_user = wp_get_current_user();
    $allowed_roles_2 = ['training', 'coachingRelation'];
    if (array_intersect($allowed_roles_2, $current_user->roles)) {
        return true;
    }
    return false;
}

function adn_page_create_user_related($template)
{
    if (is_page('meus-pacientes')) {
        $template_user_create_related = plugin_dir_path(__FILE__) . 'templates/user-create-related.php';
        if (file_exists($template_user_create_related)) {
            return $template_user_create_related;
        }
    }
    return $template;
}
add_filter('page_template', 'adn_page_create_user_related');

function adn_page_create_user($template)
{
    if (is_page('register')) {
        $template_user_create = plugin_dir_path(__FILE__) . 'templates/user-create.php';
        if (file_exists($template_user_create)) {
            return $template_user_create;
        }
    }
    return $template;
}
add_filter('page_template', 'adn_page_create_user');

function adn_page_new_order_user($template)
{
    if (is_page('new-order')) {
        $template_new_order_user = plugin_dir_path(__FILE__) . 'templates/user-new-order.php';
        if (file_exists($template_new_order_user)) {
            return $template_new_order_user;
        }
    }
    return $template;
}
add_filter('page_template', 'adn_page_new_order_user');

function adn_page_perfil_user($template)
{
    if (is_page('meu-perfil')) {
        $template_user_perfil = plugin_dir_path(__FILE__) . 'templates/user-perfil.php';
        if (file_exists($template_user_perfil)) {
            return $template_user_perfil;
        }
    }
    return $template;
}
add_filter('page_template', 'adn_page_perfil_user');

function adn_page_dashboard($template)
{
    if (is_page('dashboard')) {
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
    if (is_page('novo-treinamento')) {
        $current_user = wp_get_current_user();
        $allowed_roles_2 = ['coach', 'health-pro', 'administrator'];
        if (!array_intersect($allowed_roles_2, $current_user->roles)) {
            $template_training = plugin_dir_path(__FILE__) . 'templates/user-training.php';
        } else {
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
    if (is_page('meus-treinamentos')) {
        $template_Mytraining = plugin_dir_path(__FILE__) . 'templates/user-myTraining.php';
        if (file_exists($template_Mytraining)) {
            return $template_Mytraining;
        }
    }
    return $template;
}
add_filter('page_template', 'adn_page_Mytraining');

function adn_page_authEmail($template)
{
    if (is_page('email-confirmation')) {
        $template_auth = plugin_dir_path(__FILE__) . 'templates/auth/auth-email.php';
        if (file_exists($template_auth)) {
            return $template_auth;
        }
    }
    return $template;
}
add_filter('page_template', 'adn_page_authEmail');

function adn_page_forgotPassword($template)
{
    if (is_page('forgot-password')) {
        $template_auth = plugin_dir_path(__FILE__) . 'templates/auth/auth-forgot-password.php';
        if (file_exists($template_auth)) {
            return $template_auth;
        }
    }
    return $template;
}
add_filter('page_template', 'adn_page_forgotPassword');

function adn_page_authLogin($template)
{
    if (is_page('login')) {
        $template_auth = plugin_dir_path(__FILE__) . 'templates/auth/auth-login.php';
        if (file_exists($template_auth)) {
            return $template_auth;
        }
    }
    return $template;
}
add_filter('page_template', 'adn_page_authLogin');

function adn_page_customerSupport($template)
{
    if (is_page('suporte-cliente')) {
        $template_customerSupport = plugin_dir_path(__FILE__) . 'templates/customer-support.php';
        if (file_exists($template_customerSupport)) {
            return $template_customerSupport;
        }
    }
    return $template;
}
add_filter('page_template', 'adn_page_customerSupport');

function adn_single_training($template)
{
    if (is_singular('training')) {

        $template_wootemplate = plugin_dir_path(__FILE__) . 'templates/single-training.php';

        if (file_exists($template_wootemplate)) {
            return $template_wootemplate;
        }
    }
    return $template;
}
add_filter('template_include', 'adn_single_training');

function adn_page_block()
{
    $current_user = wp_get_current_user();

    if (is_user_logged_in() && is_page(array('login', 'register', 'email-confirmation', 'forgot-password'))) {
        wp_redirect(site_url('/meu-perfil'));
        exit;
    }
    
    if (!is_user_logged_in() && !is_page(array('login', 'register', 'email-confirmation', 'forgot-password')) && !is_admin() && !is_front_page() && !is_product() && !is_single()) {
        wp_redirect(site_url('/login'));
        exit;
    }

    if (is_user_logged_in() && array_intersect(array('training', 'coachingRelation'), $current_user->roles)) {
        $allowed_pages = array('contato', 'shop', 'dashboard', 'meus-pacientes', 'my-account', 'cart');

        if (is_page($allowed_pages) || is_home() || is_front_page() || is_product()) {
            wp_redirect(site_url('/meus-treinamentos'));
            exit;
        }
    }

    if (is_user_logged_in() && array_intersect(array('coach', 'health-pro', 'administrator'), $current_user->roles)) {
        if (is_page(array('meus-treinamentos', 'training', 'my-account', 'cart')) || is_home() || is_front_page() || is_product()) {
            wp_redirect(site_url('/dashboard'));
            exit;
        }
    }
}

add_action('template_redirect', 'adn_page_block');

function adn_custom_login_redirect($redirect_to, $request, $user)
{
    $current_user = wp_get_current_user();
    $restricted_roles = array('coachingRelation', 'training');
    $restricted_roles_2 = array('coach', 'health-pro');

    if (array_intersect($restricted_roles, $current_user->roles)) {
        $redirect_to = site_url('/meus-treinamentos', 'https');
    } elseif (array_intersect($restricted_roles_2, $current_user->roles)) {
        $redirect_to = site_url('/dashboard', 'https');
    }

    return $redirect_to;
}
add_filter('login_redirect', 'adn_custom_login_redirect', 10, 3);

function restrict_admin_access()
{
    if (is_user_logged_in()) {
        $user = wp_get_current_user();
        $restricted_roles = array('coachingRelation', 'training');
        $restricted_roles_2 = array('coach', 'health-pro');
        $redirect_to = '';

        if (array_intersect($restricted_roles, $user->roles)) {
            $redirect_to = site_url('/meus-treinamentos', 'https');

        } elseif (array_intersect($restricted_roles_2, $user->roles)) {
            $redirect_to = site_url('/dashboard', 'https');
        }

        if (!empty($redirect_to)) {
            wp_redirect($redirect_to);
            exit;
        }
    }
}
add_action('admin_init', 'restrict_admin_access');

function adn_password_reset_notification($message, $user_login, $user_data)
{
    $message = '<div width="100%" style="font-family: Arial; padding:20px;">
        <div style="margin-top:10px;margin-bottom:10px;">
            <img src="" alt="logo-academia.png" title="Academia da neurociência"/>
        </div>
        <div style="margin-top:30px; margin-bottom:10px;">
        <h2 style="color:#00A9E7; text-transform:uppercase;">E-mail de Aviso!</h2>
        </div>
        <div style="color:#1D1D1D;">
        <p>Este aviso confirma que a sua senha foi alterada em <b>Academia da Neurociência</b><br><br>
        Caso você não tenha alterado sua senha, contate a equipe de suporte em <a href="mailto:contato@institutodeneurociencia.com.br">contato@institutodeneurociencia.com.br</a>
        </p>
        </div>
        Atenciosamente,

        Academia da Neurociência
        <div style="width: 600px;height: 100px; background: #d1d1d1; margin-top:60px;">
            <div style="padding:20px;color:#c1c1c1;">
            <p>Telefone: (19) 3604-4798</p>
            <p>Endereço: Rua São Gabriel, 1555<br>
            Sala 104 - Bairro Belvedere<br>
            Americana-SP</p>
            </div>
        </div>
        </div>';

    return $message;
}

add_filter('wp_password_change_notification_email', 'adn_password_reset_notification', 10, 3);

/**
 * Woocomerce
 */

function adn_custom__checkout($template, $template_name, $template_path)
{
    if ('checkout/form-checkout.php' == $template_name) {
        $template = plugin_dir_path(__FILE__) . 'templates/checkout/form-checkout.php';
    }
    if ('checkout/review-order.php' == $template_name) {
        $template = plugin_dir_path(__FILE__) . 'templates/checkout/review-order.php';
    }
    if ('checkout/thankyou.php' == $template_name) {
        $template = plugin_dir_path(__FILE__) . 'templates/checkout/thankyou.php';
    }
    return $template;
}
add_filter('woocommerce_locate_template', 'adn_custom__checkout', 20, 3);

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
    unset($fields['billing']['billing_company']);
    unset($fields['billing']['billing_address_2']);

    return $fields;
}
add_filter('woocommerce_checkout_fields', 'adn_custom_checkout_user_fullfil');

// function alterar_status_pedido_cheque($order_id)
// {
//     if (!$order_id) {
//         return;
//     }
//     $order = wc_get_order($order_id);
//     if ($order->get_payment_method() === 'cheque') {

//         $order->update_status('completed');
//     }
// }
add_action('woocommerce_thankyou', 'alterar_status_pedido_cheque', 10, 1);

function adn_add_product_checkout()
{
    //uso pessoal
    $_plan_mensal_training = get_option('_plan_mensal_training');
    $_plan_trimestral_training = get_option('_plan_trimestral_training');
    $_plan_semestral_training = get_option('_plan_semestral_training');

    //usuário relacionado
    $_plan_mensal_coachingRelation = get_option('_plan_mensal_coachingRelation');
    $_plan_trimestral_coachingRelation = get_option('_plan_trimestral_coachingRelation');
    $_plan_semestral_coachingRelation = get_option('_plan_semestral_coachingRelation');

    $product_adicional = array(
        $_plan_semestral_coachingRelation => '6',
        $_plan_trimestral_coachingRelation => '3',
        $_plan_mensal_coachingRelation => '1',
        $_plan_semestral_training => '6',
        $_plan_trimestral_training => '3',
        $_plan_mensal_training => '1',
    );
    
    if (isset($_POST['product_id'], $_POST['user_related_id'])) {
        $product_id = filter_var($_POST['product_id'], FILTER_VALIDATE_INT);
        $user_related_id = filter_var($_POST['user_related_id'], FILTER_VALIDATE_INT);

        if ($product_id !== false && $user_related_id !== false) {
            if (class_exists('WooCommerce') && !is_admin() && !is_ajax() && !is_post_type_archive('product') && !is_singular('product')) {
                global $woocommerce;

                $woocommerce->cart->empty_cart();

                $woocommerce->cart->add_to_cart($product_id);

                $quantidade_adicional = isset($product_adicional[$product_id]) ? $product_adicional[$product_id] : '1';

                foreach ($woocommerce->cart->get_cart() as $cart_item_key => $cart_item) {
                    if ($cart_item['product_id'] == $product_id) {
                        $woocommerce->cart->set_quantity($cart_item_key, $quantidade_adicional);
                        break;
                    }
                }

                $checkout_url = wc_get_checkout_url() . '?user_related=' . $user_related_id;
                wp_redirect($checkout_url);
                exit;
            }
        } else {
            wp_redirect(home_url('/404'));
            exit;
        }
    }
}
add_action('template_redirect', 'adn_add_product_checkout');

function add_custom_billing_field($fields)
{
    $fields['billing']['billing_user_related'] = array(
        'type' => 'hidden',
        'required' => false,
    );

    return $fields;
}
add_filter('woocommerce_checkout_fields', 'add_custom_billing_field');

function check_and_enable_registration($order_id)
{
    //uso pessoal
    $_plan_mensal_training = get_option('_plan_mensal_training');
    $_plan_trimestral_training = get_option('_plan_trimestral_training');
    $_plan_semestral_training = get_option('_plan_semestral_training');

    //usuário relacionado
    $_plan_mensal_coachingRelation = get_option('_plan_mensal_coachingRelation');
    $_plan_trimestral_coachingRelation = get_option('_plan_trimestral_coachingRelation');
    $_plan_semestral_coachingRelation = get_option('_plan_semestral_coachingRelation');

    $product_data = array(
        $_plan_semestral_coachingRelation => '+6 months',
        $_plan_trimestral_coachingRelation => '+3 months',
        $_plan_mensal_coachingRelation => '+1 month',
        $_plan_semestral_training => '+6 months',
        $_plan_trimestral_training => '+3 months',
        $_plan_mensal_training => '+1 month',
    );

    $order = wc_get_order($order_id);

    if ($order) {
        $user_id = $order->get_customer_id();

        $order_date = $order->get_date_created()->format('Y-m-d'); // Data da compra

        $user_related = get_user_meta($user_id, 'billing_user_related', true);

        foreach ($order->get_items() as $item_id => $item) {
            $product_id = $item->get_product_id();

            if (array_key_exists($product_id, $product_data)) {

                $expiration_date = date('Y-m-d', strtotime($order_date . $product_data[$product_id]));

                $response_data = array(
                    'order_id' => $order_id,
                    'order_date' => $order_date,
                    'user_id' => $user_related,
                    'expiration_date' => $expiration_date,
                );

                $json_response = json_encode($response_data);

                update_user_meta($user_id, $user_related . '_user_expired', $json_response);

                break;
            }
        }
    }
}
add_action('woocommerce_order_status_completed', 'check_and_enable_registration');

function adn_verify_completed($order_id)
{
    $pedido = wc_get_order($order_id);

    $order_notes = wc_get_order_notes(array(
        'order_id' => $order_id,
    ));

    $success_note_found = false;
    foreach ($order_notes as $note) {
        if ($note->content === "Rede[00]: Success.") {
            $success_note_found = true;
            break;
        }
    }

    if ($success_note_found) {
        $pedido->update_status('completed');
    }
}
add_action('woocommerce_thankyou', 'adn_verify_completed', 10, 1);