<?php

class Roles
{
    public function __construct()
    {
        add_action('init', array($this, 'createRoles'));
    }

    public function createRoles()
    {
        if (get_role('coach')) {
            remove_role('coach');
        }
        //Professores/Escolas
        if (get_role('coach') === null) {
            add_role('coach', 'Professores e Escolas', array(
                'read' => true,
                'edit_posts' => true,
                'delete_posts' => true,
                'publish_posts' => true,
                'upload_files' => true,
                'manage_links' => true,
                'edit_others_posts' => true,
                'delete_others_posts' => true,
                'edit_published_posts' => true,
                'delete_published_posts' => true,
                'edit_private_posts' => true,
                'delete_private_posts' => true,
                'read_private_posts' => true,
                'edit_users' => true,
                'list_users' => true,
                'promote_users' => true,
                'create_users' => true,
                'delete_users' => true,
                'manage_options' => true,
            ));
        }
        //Usuário para treinamento
        if (get_role('training')) {
            remove_role('training');
        }
        if (get_role('training') === null) {
            add_role('training', 'Treinamento', array(
                'read' => true,
                'edit_posts' => true,
                'delete_posts' => true,
                'publish_posts' => true,
                'upload_files' => true,
                'manage_links' => true,
                'edit_others_posts' => true,
                'delete_others_posts' => true,
                'edit_published_posts' => true,
                'delete_published_posts' => true,
                'edit_private_posts' => true,
                'delete_private_posts' => true,
                'read_private_posts' => true,
                'edit_users' => true,
                'list_users' => true,
                'promote_users' => true,
                'create_users' => true,
                'delete_users' => true,
                'manage_options' => true,
            ));
        }

        //Professores/Escolas
        if (get_role('health-pro') === null) {
            add_role('health-pro', 'Profissionais da Saúde', array(
                'read' => true,
                'edit_posts' => true,
                'delete_posts' => true,
                'publish_posts' => true,
                'upload_files' => true,
                'manage_links' => true,
                'edit_others_posts' => true,
                'delete_others_posts' => true,
                'edit_published_posts' => true,
                'delete_published_posts' => true,
                'edit_private_posts' => true,
                'delete_private_posts' => true,
                'read_private_posts' => true,
                'edit_users' => true,
                'list_users' => true,
                'promote_users' => true,
                'create_users' => true,
                'delete_users' => true,
                'manage_options' => true,
            ));
        }
        
        //usuário relacional
        if (get_role('coachingRelation')) {
            remove_role('coachingRelation');
        }
        if (get_role('coachingRelation') === null) {
            add_role('coachingRelation', 'Usuário Relacionado', array(
                'read' => true,
                'publish_posts' => true,
                'upload_files' => true,
                'edit_private_posts' => true,
                'read_private_posts' => true,
            ));
        }
    }
}
new Roles();
