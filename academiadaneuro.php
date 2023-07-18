<?php
/**
 * Plugin Name: Academia da Neurociência
 * Description: Academia da Neurociência é uma plataforma de treinamento cognitivo.
 * Version: 1.0.0
 * Author: Lelly Oliver
 * URL: https://github.com/lellyoliver/academiadaneuro
 */

// Evita acesso direto ao arquivo
if (!defined('ABSPATH')) {
    exit;
}
// // Verifica se a constante WPINC está definida
// if ( ! defined( 'WPINC' ) ) {
//     die;
// }

// Inclua o arquivo de inicialização do plugin
require_once plugin_dir_path(__FILE__) . 'includes/init.php';

/**
 * Scripts Plugin
 */
function adn_scripts()
{
    if(is_user_logged_in()){
        if (is_page(252)) {
            wp_enqueue_script('login', plugins_url('assets/js/auth/auth-user.js', __FILE__), '1.0.0', true);
            wp_enqueue_style('logincss', plugins_url('assets/css/style-login.css', __FILE__), array(), '1.0.0', 'all');
        }
        if (is_page(13)) {
            wp_enqueue_script('createuserjs', plugins_url('assets/js/users/create-user.js', __FILE__), '1.0.0', true);
        }
    }
}
add_action('wp_enqueue_scripts', 'adn_scripts');

/**
 * Template Para página de cadastro
 */

function adn_page_login($template)
{
    if (get_the_ID() == 252) {
        $template_login = plugin_dir_path(__FILE__) . 'templates/auth/login.php';
        if (file_exists($template_login)) {
            return $template_login;
        }
    }
    return $template;
}
add_filter('page_template', 'adn_page_login');

function adn_page_register_user($template)
{
    if (get_the_ID() == 13) {
        $template_user_create = plugin_dir_path(__FILE__) . 'templates/user-create.php';
        if (file_exists($template_user_create)) {
            return $template_user_create;
        }
    }
    return $template;
}
add_filter('page_template', 'adn_page_register_user');

/**
 * Custom Fields
 */

require_once plugin_dir_path(__FILE__) . 'includes/UserCustomFields.php';
