<?php
include_once plugin_dir_path(__FILE__) . 'db.php';

class AcademiaPluginInstaller
{
    public function __construct()
    {
        register_activation_hook(__FILE__, array($this, 'activate'));
    }

    public function activate()
    {
        $this->createPages();
        $this->createDatabaseTables();
        // Adicione outras ações ou configurações necessárias após a ativação do plugin aqui
    }

    private function createPages()
    {
        $pages = array(
            'dashboard' => 'Dashboard',
            'meus-treinamentos' => 'Meus Treinamentos',
            'meus-pacientes' => 'Meus Pacientes',
            'meu-perfil' => 'Meu Perfil',
            'register' => 'Register',
            'email-confirmation' => 'Email Confirmation',
            'login' => 'Login',
            'novo-treinamento' => 'Novo Treinamento'
        );

        foreach ($pages as $slug => $title) {
            $page = get_page_by_path($slug);

            if (!$page) {
                $page_data = array(
                    'post_title' => $title,
                    'post_name' => $slug,
                    'post_status' => 'publish',
                    'post_type' => 'page',
                );

                wp_insert_post($page_data);
            }
        }
    }

    private function createDatabaseTables()
    {
        $dbCustom = new DBCustom();

        if (!$dbCustom->doesTableExist('training_replies')) {
            $dbCustom->createTableTrainingReplies();
        }

        if (!$dbCustom->doesTableExist('training_progress')) {
            $dbCustom->createTableTrainingProgress();
        }
    }
}

new AcademiaPluginInstaller();