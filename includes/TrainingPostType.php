<?php
class TrainingPostType
{
    public function __construct()
    {
        add_action('init', array($this, 'trainingPostType'));
        add_action('init', array($this, 'brainGroupTaxonomy'));
    }

    public function trainingPostType()
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
            'all_items' => __('Todos', 'adn-plugin'),
            'search_items' => __('Procurar Treinamento', 'adn-plugin'),
            'parent_item_colon' => __('Questões sobre treinamento:', 'adn-plugin'),
            'not_found' => __('Nenhum Treinamento encontrada.', 'adn-plugin'),
            'not_found_in_trash' => __('Nenhuma pergunta de treinamento encontrada na Lixeira.', 'adn-plugin'),
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

    public function brainGroupTaxonomy()
    {
        $labels = array(
            'name' => _x('Categorias Cerebrais', 'taxonomy general name', 'adn-plugin'),
            'singular_name' => _x('Categorias Cerebrais', 'taxonomy singular name', 'adn-plugin'),
            'search_items' => __('Pesquisar Categoria Cerebral', 'adn-plugin'),
            'popular_items' => __('Categoria Cerebral Populares', 'adn-plugin'),
            'all_items' => __('Todas os Categorias Cerebrais', 'adn-plugin'),
            'parent_item' => null,
            'parent_item_colon' => null,
            'edit_item' => __('Editar', 'adn-plugin'),
            'update_item' => __('Atualizar', 'adn-plugin'),
            'add_new_item' => __('Adicionar Nova', 'adn-plugin'),
            'new_item_name' => __('Nova Categoria Cerebral', 'adn-plugin'),
            'separate_items_with_commas' => __('Separe as Categorias Cerebrais por vírgulas', 'adn-plugin'),
            'add_or_remove_items' => __('Adicionar ou remover Categorias Cerebrais', 'adn-plugin'),
            'choose_from_most_used' => __('Escolha entre as Categorias Cerebrais mais usados', 'adn-plugin'),
            'not_found' => __('Nenhuma Categoria foi encontrada.', 'adn-plugin'),
            'menu_name' => __('Categorias Cerebrais', 'adn-plugin'),
        );

        $args = array(
            'hierarchical' => true,
            'labels' => $labels,
            'show_ui' => true,
            'show_admin_column' => true,
            'query_var' => true,
            'rewrite' => array('slug' => 'brain-group'),
        );

        register_taxonomy('brainGroup', 'training', $args);
    }

}
new TrainingPostType();