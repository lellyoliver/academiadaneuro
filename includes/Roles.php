<?php

class Roles
{
    public function __construct()
    {
        add_action('init', array($this, 'createRoles'));
    }

    public function createRoles()
    {
        //Professores/Escolas
        if (get_role('coach')) {
            remove_role('coach');
        }
        if (get_role('coach') === null) {
            add_role('coach', 'Professores e Escolas', get_role('editor')->capabilities);
        }

        //Profissionais da Saúde
        if (get_role('health-pro')) {
            remove_role('health-pro');
        }
        if (get_role('health-pro') === null) {
            add_role('health-pro', 'Profissionais da Saúde', get_role('editor')->capabilities);
        }

        //Usuário para treinamento
        if (get_role('training')) {
            remove_role('training');
        }
        if (get_role('training') === null) {
            add_role('training', 'Treinamento', get_role('editor')->capabilities);
        }
        
        //usuário relacional
        if (get_role('coachingRelation')) {
            remove_role('coachingRelation');
        }
        if (get_role('coachingRelation') === null) {
            add_role('coachingRelation', 'Usuário Relacionado', get_role('editor')->capabilities);
        }
    }
}
new Roles();
