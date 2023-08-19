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
 * Enqueue scripts based on the page being viewed.
 */
function adn_scripts()
{
    wp_enqueue_style('stylecss', plugins_url('assets/css/style.css', __FILE__), array(), '1.0.0', false);
    
    if (is_page(18)) {
        wp_enqueue_script('utilsjs', plugins_url('assets/js/users-related/user-utils.js', __FILE__), '1.0.0', true);
        wp_enqueue_script('userrelatedjs', plugins_url('assets/js/users-related/user-related.js', __FILE__), '1.0.0', true);

    }
    if (is_page(11)) {
        wp_enqueue_script('createuserjs', plugins_url('assets/js/users/user-create.js', __FILE__), '1.0.0', true);
    }

    //Bootstrap
    wp_enqueue_script('bootstrapbundlejs', plugins_url('assets/lib/bootstrap/bootstrap.bundle.js', __FILE__), '5.0.2', true);
    
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

/**
 * Include user roles
 */
require_once plugin_dir_path(__FILE__) . 'includes/roles.php';

/**
 * Include Meta Custom User.
 */
require_once plugin_dir_path(__FILE__) . 'includes/MetaCustomUser.php';

// /**
//  * Include Custom Header.
//  */
// include_once plugin_dir_path(__FILE__) . 'templates/header-custom.php';
