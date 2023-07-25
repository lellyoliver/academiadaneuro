<?php
/**
 * Plugin Name: Academia da Neuro
 * Description: Plataforma de neurociência
 * Version: 1.0.0
 * Author: <a href="https://github.com/lellyoliver/academiadaneuro">Lelly Oliver</a>
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
function brfng_scripts()
{
    if (is_page(11)) {
        wp_enqueue_script('createuserjs', plugins_url('assets/js/users/create-user.js', __FILE__), '1.0.0', true);
    }
}
add_action('wp_enqueue_scripts', 'brfng_scripts');

/**
 * Template Para página de cadastro
 */

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
 * Custom Fields
 */
require_once plugin_dir_path(__FILE__) . 'includes/UserCustomFields.php';
