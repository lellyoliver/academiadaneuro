<?php
class PostType
{
    public function __construct()
    {
        add_action('init', array($this, 'TraningQuestionPostType'));
        add_action('init', array($this, 'BrainGroupTaxonomy'));
        add_action('init', array($this, 'BrainCategoryTaxonomy'));

    }

    public function TraningQuestionPostType()
    {
        $labels = array(
            'name' => _x('Teste para Estimulação Cerebral', 'post type general name', 'adn-plugin'),
            'singular_name' => _x('Teste para Estimulação Cerebral', 'post type singular name', 'adn-plugin'),
            'menu_name' => _x('Training Questions', 'admin menu', 'adn-plugin'),
            'name_admin_bar' => _x('Training Question', 'add new on admin bar', 'adn-plugin'),
            'add_new' => _x('Add New', 'training question', 'adn-plugin'),
            'add_new_item' => __('Add New Training Question', 'adn-plugin'),
            'new_item' => __('New Training Question', 'adn-plugin'),
            'edit_item' => __('Edit Training Question', 'adn-plugin'),
            'view_item' => __('View Training Question', 'adn-plugin'),
            'all_items' => __('Teste para Estimulação Cerebral', 'adn-plugin'),
            'search_items' => __('Search Training Questions', 'adn-plugin'),
            'parent_item_colon' => __('Parent Training Questions:', 'adn-plugin'),
            'not_found' => __('No training questions found.', 'adn-plugin'),
            'not_found_in_trash' => __('No training questions found in Trash.', 'adn-plugin'),
        );

        $args = array(
            'labels' => $labels,
            'description' => __('Training Questions', 'adn-plugin'),
            'public' => true,
            'publicly_queryable' => true,
            'show_ui' => true,
            'show_in_menu' => true,
            'query_var' => true,
            'rewrite' => array('slug' => 'training-question'),
            'capability_type' => 'post',
            'has_archive' => true,
            'hierarchical' => false,
            'menu_position' => null,
            'supports' => array('title', 'author', 'custom-fields'),
            'menu_icon' => 'dashicons-feedback',
        );

        register_post_type('traningQuestion', $args);
    }
    public function BrainGroupTaxonomy() {
        $labels = array(
            'name'                       => _x('Grupo Cerebral', 'taxonomy general name', 'adn-plugin'),
            'singular_name'              => _x('Grupo Cerebral', 'taxonomy singular name', 'adn-plugin'),
            'search_items'               => __('Pesquisar Grupo Cerebral', 'adn-plugin'),
            'popular_items'              => __('Grupo Cerebral Populares', 'adn-plugin'),
            'all_items'                  => __('Todas os Grupos Cerebrais', 'adn-plugin'),
            'parent_item'                => null,
            'parent_item_colon'          => null,
            'edit_item'                  => __('Editar', 'adn-plugin'),
            'update_item'                => __('Atualizar', 'adn-plugin'),
            'add_new_item'               => __('Adicionar Novo', 'adn-plugin'),
            'new_item_name'              => __('Novo Grupo Cerebral', 'adn-plugin'),
            'separate_items_with_commas' => __('Separe os Grupos Cerebrais por vírgulas', 'adn-plugin'),
            'add_or_remove_items'        => __('Adicionar ou remover Grupos Cerebrais', 'adn-plugin'),
            'choose_from_most_used'      => __('Escolha entre os Grupos Cerebrais mais usados', 'adn-plugin'),
            'not_found'                  => __('Nenhum Grupo foi encontrado.', 'adn-plugin'),
            'menu_name'                  => __('Grupo Cerebral', 'adn-plugin'),
        );

        $args = array(
            'hierarchical'      => true,
            'labels'            => $labels,
            'show_ui'           => true,
            'show_admin_column' => true,
            'query_var'         => true,
            'rewrite'           => array('slug' => 'brain-group'),
        );

        register_taxonomy('brainGroup', 'traningquestion', $args);
    }

    public function BrainCategoryTaxonomy() {
        $labels = array(
            'name'                       => _x('Categorias Cerebral', 'taxonomy general name', 'adn-plugin'),
            'singular_name'              => _x('Categorias Cerebral', 'taxonomy singular name', 'adn-plugin'),
            'search_items'               => __('Pesquisar Categoria Cerebral', 'adn-plugin'),
            'popular_items'              => __('Categoria Cerebral Populares', 'adn-plugin'),
            'all_items'                  => __('Todas os Categorias Cerebrais', 'adn-plugin'),
            'parent_item'                => null,
            'parent_item_colon'          => null,
            'edit_item'                  => __('Editar', 'adn-plugin'),
            'update_item'                => __('Atualizar', 'adn-plugin'),
            'add_new_item'               => __('Adicionar Nova', 'adn-plugin'),
            'new_item_name'              => __('Nova Categoria Cerebral', 'adn-plugin'),
            'separate_items_with_commas' => __('Separe as Categorias Cerebrais por vírgulas', 'adn-plugin'),
            'add_or_remove_items'        => __('Adicionar ou remover Categorias Cerebrais', 'adn-plugin'),
            'choose_from_most_used'      => __('Escolha entre as Categorias Cerebrais mais usados', 'adn-plugin'),
            'not_found'                  => __('Nenhuma Categoria foi encontrada.', 'adn-plugin'),
            'menu_name'                  => __('Categorias Cerebral', 'adn-plugin'),
        );

        $args = array(
            'hierarchical'      => false,
            'labels'            => $labels,
            'show_ui'           => true,
            'show_admin_column' => true,
            'query_var'         => true,
            'rewrite'           => array('slug' => 'brain-category'),
        );

        register_taxonomy('brainCategory', 'traningquestion', $args);
    }
}
new PostType();