<?php
class CustomerSupport
{
    public function __construct()
    {
        add_action('init', array($this, 'customerSupportPostType'));
        add_action('init', array($this, 'customerSupportTaxonomy'));
    }

    public function customerSupportPostType()
    {
        $labels = array(
            'name' => _x('Suportes Abertos', 'post type general name', 'adn-plugin'),
            'singular_name' => _x('Suporte ao Cliente', 'post type singular name', 'adn-plugin'),
            'menu_name' => _x('Suporte ao Cliente', 'adn-plugin'),
            'name_admin_bar' => _x('Suporte cliente', 'adn-plugin'),
            'add_new' => _x('Add Novo', 'adn-plugin'),
            'add_new_item' => __('Novo Suporte', 'adn-plugin'),
            'new_item' => __('Novo Suporte', 'adn-plugin'),
            'edit_item' => __('Editar Suporte', 'adn-plugin'),
            'view_item' => __('Ver Suporte', 'adn-plugin'),
            'all_items' => __('Todos', 'adn-plugin'),
            'search_items' => __('Procurar Suportes', 'adn-plugin'),
            'parent_item_colon' => __('Perguntas:', 'adn-plugin'),
            'not_found' => __('Nenhum suporte encontrado', 'adn-plugin'),
            'not_found_in_trash' => __('Nenhuma pergunta encontrada na Lixeira.', 'adn-plugin'),
        );

        $args = array(
            'labels' => $labels,
            'description' => __('Dashboard para Suporte ao cliente', 'adn-plugin'),
            'public' => false,
            'publicly_queryable' => true,
            'show_ui' => true,
            'show_in_menu' => true,
            'query_var' => true,
            'rewrite' => array('slug' => 'customer-support'),
            'capability_type' => 'post',
            'has_archive' => true,
            'hierarchical' => false,
            'menu_position' => null,
            'supports' => array('title', 'author', 'editor', 'comments'),
            'menu_icon' => 'dashicons-testimonial',
        );

        register_post_type('customer-support', $args);
    }

    public function customerSupportTaxonomy()
    {
        $labels = array(
            'name' => _x('Categoria do Suporte', 'taxonomy general name', 'adn-plugin'),
            'singular_name' => _x('Categoria do Suporte', 'taxonomy singular name', 'adn-plugin'),
            'search_items' => __('Pesquisar Categoria', 'adn-plugin'),
            'popular_items' => __('Categoria Populares', 'adn-plugin'),
            'all_items' => __('Todas as categorias', 'adn-plugin'),
            'parent_item' => null,
            'parent_item_colon' => null,
            'edit_item' => __('Editar', 'adn-plugin'),
            'update_item' => __('Atualizar', 'adn-plugin'),
            'add_new_item' => __('Adicionar Nova', 'adn-plugin'),
            'new_item_name' => __('Nova Categoria', 'adn-plugin'),
            'separate_items_with_commas' => __('Separe as categorias por vírgulas', 'adn-plugin'),
            'add_or_remove_items' => __('Adicionar ou remover Categorias', 'adn-plugin'),
            'choose_from_most_used' => __('Escolha entre as Categorias mais usadas', 'adn-plugin'),
            'not_found' => __('Nenhuma Categoria foi encontrada.', 'adn-plugin'),
            'menu_name' => __('Categorias do Suporte', 'adn-plugin'),
        );

        $args = array(
            'hierarchical' => true,
            'labels' => $labels,
            'show_ui' => true,
            'show_admin_column' => true,
            'query_var' => true,
            'rewrite' => array('slug' => 'customer-support-category'),
        );

        register_taxonomy('customer-support-category', 'customer-support', $args);
    }

}
new CustomerSupport();