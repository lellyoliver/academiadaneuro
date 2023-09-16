<?php
class PostType
{
    public function __construct()
    {
        add_action('init', array($this, 'TrainingPostType'));
    }

    public function TrainingPostType()
    {
        $labels = array(
            'name' => _x('Treinamentos', 'post type general name', 'adn-plugin'),
            'singular_name' => _x('treinamento: Estimulação Cerebral', 'post type singular name', 'adn-plugin'),
            'menu_name' => _x('Treinamentos', 'adn-plugin'),
            'name_admin_bar' => _x('Treinamentos', 'adn-plugin'),
            'add_new' => _x('Adicionar Novo', 'adn-plugin'),
            'add_new_item' => __('Adicionar Novo Treinamento', 'adn-plugin'),
            'new_item' => __('Novo Treinamento', 'adn-plugin'),
            'edit_item' => __('Editar Treinamento', 'adn-plugin'),
            'view_item' => __('Ver Treinamento', 'adn-plugin'),
            'all_items' => __('Todos Treinamentos', 'adn-plugin'),
            'search_items' => __('Procurar Treinamento', 'adn-plugin'),
            'parent_item_colon' => __('Parent Training Questions:', 'adn-plugin'),
            'not_found' => __('No training questions found.', 'adn-plugin'),
            'not_found_in_trash' => __('No training questions found in Trash.', 'adn-plugin'),
        );

        $args = array(
            'labels' => $labels,
            'description' => __('Treinamento', 'adn-plugin'),
            'public' => true,
            'publicly_queryable' => true,
            'show_ui' => true,
            'show_in_menu' => true,
            'query_var' => true,
            'rewrite' => array('slug' => 'training'),
            'capability_type' => 'post',
            'has_archive' => true,
            'hierarchical' => false,
            'menu_position' => null,
            'supports' => array('title', 'author', 'custom-fields'),
            'menu_icon' => 'dashicons-feedback',
        );

        register_post_type('training', $args);
    }

}
new PostType();