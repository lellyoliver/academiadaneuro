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

/**
 * Registers and queues plugin scripts.
 */
function adn_scripts()
{
    if (is_page(11) || is_page(18)) {
        wp_enqueue_script('createuserjs', plugins_url('assets/js/users/create-user.js', __FILE__), '1.0.0', true);
    }
}
add_action('wp_enqueue_scripts', 'adn_scripts');

/**
 * Defines the template for the user registration page.
 */
function adn_page_register_user($template)
{
    if (get_the_ID() == 11 || get_the_ID() == 18) {
        $template_user_create = plugin_dir_path(__FILE__) . 'templates/user-create.php';
        if (file_exists($template_user_create)) {
            return $template_user_create;
        }
    }
    return $template;
}
add_filter('page_template', 'adn_page_register_user');

/**
 * Include user roles
 */

require_once plugin_dir_path(__FILE__) . 'includes/roles.php';

require_once plugin_dir_path(__FILE__) . 'includes/MetaCustomUser.php';



