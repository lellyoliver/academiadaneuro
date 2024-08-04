<?php

class PostTypes
{
    public function __construct()
    {
        add_action('admin_menu', array($this, 'register_academia_menu'));
        add_action('init', array($this, 'post_type_academia'));
        add_action('init', array($this, 'taxonomy_academia'));
        add_action('add_meta_boxes', array($this, 'remove_custom_fields_meta_box'));
    }

    public function register_academia_menu()
    {
        add_menu_page(
            'Academia da Neuro',
            'Academia da Neuro',
            'manage_options',
            'academia_menu',
            '',
            'data:image/svg+xml;base64,' . base64_encode('<svg xmlns="http://www.w3.org/2000/svg" width="76" height="76" viewBox="0 0 76 76">
            <g id="adn_icon_favicon" transform="translate(1348 540)">
              <path id="icon-adn" d="M63,76H13A13,13,0,0,1,0,63V13A13,13,0,0,1,13,0H63A13,13,0,0,1,76,13V63A13,13,0,0,1,63,76Zm1.167-19.947h0a4.623,4.623,0,1,0,5.722-7.227c-2.289-3.507-8.329-7.887-16.572-12.017a65.5,65.5,0,0,0,8.073-5.966,4.569,4.569,0,0,0,2.048.478,4.623,4.623,0,0,0,3.474-7.673,4.021,4.021,0,0,0-.1-2.841,4.305,4.305,0,0,0-2.641-2.181A13.459,13.459,0,0,0,59.707,18a49.434,49.434,0,0,0-12.452,2.042,109.384,109.384,0,0,0-15.813,5.824c-1.1.5-2.208,1.02-3.293,1.549a65.155,65.155,0,0,0-13.909-2.251v-.01h-1.5v.011a18.907,18.907,0,0,0-2.653.245,3.995,3.995,0,1,0-4.071,6.874,20.986,20.986,0,0,0,5.278,5.369C5.429,42.323,3.031,46.3,4.358,49.171c.657,1.417,2.228,2.306,4.67,2.642a4.562,4.562,0,0,0,8.68-.466,80.943,80.943,0,0,0,12.411-3.37c1.453.608,2.974,1.212,4.523,1.795C45.2,53.735,55.631,56.1,62.549,56.1c.555,0,1.1-.016,1.618-.048Zm-1.461-2.974h-.157c-6.574,0-16.609-2.294-26.844-6.136-.539-.2-.982-.372-1.4-.533,1.777-.705,3.6-1.479,5.413-2.3a115.535,115.535,0,0,0,10.539-5.434,80.137,80.137,0,0,1,11.324,6.481,33.355,33.355,0,0,1,3.982,3.227,4.627,4.627,0,0,0-2.88,4.283c0,.138.006.278.019.415ZM8.972,48.742h0c-1.2-.225-1.757-.594-1.872-.841a1.676,1.676,0,0,1,.109-1.226c.694-1.871,3.059-4.422,6.657-7.182A90.246,90.246,0,0,0,25.985,46.16a72.841,72.841,0,0,1-8.534,2.16,4.562,4.562,0,0,0-8.479.421ZM30.2,44.733h0A95.116,95.116,0,0,1,16.481,37.6a101.768,101.768,0,0,1,11.985-6.969c3.838,1.027,7.847,2.323,11.917,3.852,2.213.83,4.4,1.72,6.5,2.644-2.665,1.483-5.5,2.906-8.411,4.231C35.733,42.6,32.95,43.737,30.2,44.733Zm-16.4-8.97h0a27.8,27.8,0,0,1-3.946-3.409,4,4,0,0,0,2.092-4.125c.49-.036,1.007-.053,1.538-.053a51.847,51.847,0,0,1,10.5,1.362,95.112,95.112,0,0,0-10.18,6.225Zm36.292-.5h0c-2.763-1.276-5.673-2.49-8.651-3.608s-5.966-2.13-8.844-2.994l.089-.041c10.32-4.685,20.672-7.6,27.017-7.6,2.848,0,4.163.62,4.352,1.037a.282.282,0,0,1,.021.06,4.624,4.624,0,0,0-4.813,6.571c-.255.225-.527.457-.833.713A68.882,68.882,0,0,1,50.1,35.259Z" transform="translate(-1348 -540)" fill="#1d1d1d"/>
            </g>
          </svg>
          '),
            6// Posição do menu
        );
    }

    public function post_type_academia()
    {
        register_post_type('questions', array(
            'labels' => array(
                'name' => 'Questões',
                'singular_name' => 'Questão',
                'menu_name' => 'Questões',
                'all_items' => 'Questões',
                'edit_item' => 'Editar Questão',
                'view_item' => 'Ver Questão',
                'view_items' => 'Ver Questões',
                'add_new_item' => 'Adicionar Nova Questão',
                'add_new' => 'Adicionar Nova',
                'new_item' => 'Nova Questão',
                'parent_item_colon' => 'Questão Ascendente:',
                'search_items' => 'Pesquisar Questões',
                'not_found' => 'Nenhuma Questão Encontrada',
                'not_found_in_trash' => 'Nenhuma Questão Encontrada na Lixeira',
                'archives' => 'Arquivos de Questões',
                'attributes' => 'Atributos de Questões',
                'insert_into_item' => 'Inserir na Questão',
                'uploaded_to_this_item' => 'Enviado para esta Questão',
                'filter_items_list' => 'Filtrar Lista de Questões',
                'filter_by_date' => 'Filtrar Questões por Data',
                'items_list_navigation' => 'Navegação na Lista de Questões',
                'items_list' => 'Lista de Questões',
                'item_published' => 'Questão Publicada.',
                'item_published_privately' => 'Questão Publicada Privadamente.',
                'item_reverted_to_draft' => 'Questão Revertida para Rascunho.',
                'item_scheduled' => 'Questão Agendada.',
                'item_updated' => 'Questão Atualizada.',
                'item_link' => 'Link da Questão',
                'item_link_description' => 'Um link para uma Questão.',
            ),
            'public' => true,
            'show_in_rest' => true,
            'supports' => array(
                'title'
            ),
            'rewrite' => array(
                'slug' => 'questoes',
            ),
            'delete_with_user' => false,
            'show_in_menu' => 'academia_menu', // Define o menu pai
        ));

        register_post_type('training', array(
            'labels' => array(
                'name' => 'Treinamentos',
                'singular_name' => 'Treinamento',
                'menu_name' => 'Treinamentos',
                'all_items' => 'Treinamentos',
                'edit_item' => 'Editar Treinamento',
                'view_item' => 'Ver Treinamento',
                'view_items' => 'Ver Treinamentos',
                'add_new_item' => 'Adicionar Novo Treinamento',
                'add_new' => 'Adicionar Novo',
                'new_item' => 'Novo Treinamento',
                'parent_item_colon' => 'Treinamento Ascendente:',
                'search_items' => 'Pesquisar Treinamentos',
                'not_found' => 'Nenhum Treinamento Encontrado',
                'not_found_in_trash' => 'Nenhum Treinamento Encontrado na Lixeira',
                'archives' => 'Arquivos de Treinamentos',
                'attributes' => 'Atributos de Treinamentos',
                'insert_into_item' => 'Inserir no Treinamento',
                'uploaded_to_this_item' => 'Enviado para este Treinamento',
                'filter_items_list' => 'Filtrar Lista de Treinamentos',
                'filter_by_date' => 'Filtrar Treinamentos por Data',
                'items_list_navigation' => 'Navegação na Lista de Treinamentos',
                'items_list' => 'Lista de Treinamentos',
                'item_published' => 'Treinamento Publicado.',
                'item_published_privately' => 'Treinamento Publicado Privadamente.',
                'item_reverted_to_draft' => 'Treinamento Revertido para Rascunho.',
                'item_scheduled' => 'Treinamento Agendado.',
                'item_updated' => 'Treinamento Atualizado.',
                'item_link' => 'Link do Treinamento',
                'item_link_description' => 'Um link para um Treinamento.',
            ),
            'public' => true,
            'show_in_rest' => true,
            'supports' => array(
                'title',
                'custom-fields',
                'thumbnail',
            ),
            'delete_with_user' => false,
            'show_in_menu' => 'academia_menu', // Define o menu pai
        ));
        register_post_type('customer-support', array(
            'labels' => array(
                'name' => 'Suporte ao Cliente',
                'singular_name' => 'Suporte ao Cliente',
                'menu_name' => 'Suporte ao Cliente',
                'all_items' => 'Suporte ao Cliente',
                'edit_item' => 'Editar Suporte ao Cliente',
                'view_item' => 'Ver Suporte ao Cliente',
                'view_items' => 'Ver Suportes ao Cliente',
                'add_new_item' => 'Adicionar Novo Suporte ao Cliente',
                'add_new' => 'Adicionar Novo',
                'new_item' => 'Novo Suporte ao Cliente',
                'parent_item_colon' => 'Suporte ao Cliente Ascendente:',
                'search_items' => 'Pesquisar Suportes ao Cliente',
                'not_found' => 'Nenhum Suporte ao Cliente Encontrado',
                'not_found_in_trash' => 'Nenhum Suporte ao Cliente Encontrado na Lixeira',
                'archives' => 'Arquivos de Suportes ao Cliente',
                'attributes' => 'Atributos de Suportes ao Cliente',
                'insert_into_item' => 'Inserir no Suporte ao Cliente',
                'uploaded_to_this_item' => 'Enviado para este Suporte ao Cliente',
                'filter_items_list' => 'Filtrar Lista de Suportes ao Cliente',
                'filter_by_date' => 'Filtrar Suportes ao Cliente por Data',
                'items_list_navigation' => 'Navegação na Lista de Suportes ao Cliente',
                'items_list' => 'Lista de Suportes ao Cliente',
                'item_published' => 'Suporte ao Cliente Publicado.',
                'item_published_privately' => 'Suporte ao Cliente Publicado Privadamente.',
                'item_reverted_to_draft' => 'Suporte ao Cliente Revertido para Rascunho.',
                'item_scheduled' => 'Suporte ao Cliente Agendado.',
                'item_updated' => 'Suporte ao Cliente Atualizado.',
                'item_link' => 'Link do Suporte ao Cliente',
                'item_link_description' => 'Um link para um Suporte ao Cliente.',
            ),
            'public' => true,
            'show_in_rest' => true,
            'supports' => array(
                'title',
                'custom-fields',
                'editor',
            ),
            'rewrite' => array(
                'slug' => 'suporte',
            ),
            'delete_with_user' => false,
            'show_in_menu' => 'academia_menu', // Define o menu pai
        ));
    }

    public function taxonomy_academia()
    {
        register_taxonomy('brainGroup', 'training', array(
            'labels' => array(
                'name' => 'Categorias Cerebrais',
                'singular_name' => 'Categoria Cerebral',
                'menu_name' => 'Categorias Cerebrais',
                'all_items' => 'Todas as Categorias',
                'edit_item' => 'Editar Categoria',
                'view_item' => 'Ver Categoria',
                'update_item' => 'Atualizar Categoria',
                'add_new_item' => 'Adicionar Nova Categoria',
                'new_item_name' => 'Nome da Nova Categoria',
                'search_items' => 'Buscar Categorias',
                'parent_item' => 'Categoria Pai',
                'parent_item_colon' => 'Categoria Pai:',
                'not_found' => 'Nenhuma categoria encontrada',
            ),
            'hierarchical' => true,
            'public' => true,
            'show_ui' => true,
            'show_admin_column' => true,
            'query_var' => true,
        ));

        register_taxonomy('customer-support-category', 'customer-support', array(
            'labels' => array(
                'name' => 'Categorias Cerebrais',
                'singular_name' => 'Categoria Cerebral',
                'menu_name' => 'Categorias Cerebrais',
                'all_items' => 'Todas as Categorias',
                'edit_item' => 'Editar Categoria',
                'view_item' => 'Ver Categoria',
                'update_item' => 'Atualizar Categoria',
                'add_new_item' => 'Adicionar Nova Categoria',
                'new_item_name' => 'Nome da Nova Categoria',
                'search_items' => 'Buscar Categorias',
                'parent_item' => 'Categoria Pai',
                'parent_item_colon' => 'Categoria Pai:',
                'not_found' => 'Nenhuma categoria encontrada',
            ),
            'hierarchical' => true,
            'public' => true,
            'show_ui' => true,
            'show_admin_column' => true,
            'query_var' => true,
        ));

        register_taxonomy('question-category', 'questions', array(
            'labels' => array(
                'name' => 'Categorias das Questões',
                'singular_name' => 'Categoria da Questão',
                'menu_name' => 'Categorias das Questões',
                'all_items' => 'Todas as Categorias',
                'edit_item' => 'Editar Categoria',
                'view_item' => 'Ver Categoria',
                'update_item' => 'Atualizar Categoria',
                'add_new_item' => 'Adicionar Nova Categoria',
                'new_item_name' => 'Nome da Nova Categoria',
                'search_items' => 'Buscar Categorias',
                'parent_item' => 'Categoria Pai',
                'parent_item_colon' => 'Categoria Pai:',
                'not_found' => 'Nenhuma categoria encontrada',
            ),
            'hierarchical' => true,
            'public' => true,
            'show_ui' => true,
            'show_admin_column' => true,
            'query_var' => true,
        ));
    }
    
    public function remove_custom_fields_meta_box()
    {
        $arr = [
            'customer-support', 'questions', 'training',
        ];
        foreach ($arr as $arrs) {
            remove_meta_box('postcustom', $arrs, 'normal');
        }
    }

}

new PostTypes();
