<?php
class CreatePages
{
    public function create_pages()
    {
        $pages = array(
            'dashboard' => 'Dashboard',
            'meus-treinamentos' => 'Meus Treinamentos',
            'meus-pacientes' => 'Meus Pacientes',
            'meu-perfil' => 'Meu Perfil',
            'novo-treinamento' => 'Novo Treinamento',
            'new-order' => 'Solicitação de Novo Plano',
            'forgot-password' => 'Esqueci Minha Senha',
            'register' => 'Register',
            'email-confirmation' => 'Confirmação de E-mail',
            'login' => 'Login',
            'suporte-cliente' => 'Suporte ao Cliente',
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
