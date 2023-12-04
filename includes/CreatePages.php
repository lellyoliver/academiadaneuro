<?php
class CreatePages
{
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
            'novo-treinamento' => 'Novo Treinamento',
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
}

new CreatePages();
