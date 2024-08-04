<?php
require_once plugin_dir_path(__FILE__) . '../services/CustomerSupportService.php';

class CustomerSupportController
{
    private $customerSupportService;

    public function __construct()
    {
        $this->customerSupportService = new CustomerSupportService();
    }

    public function create($request){
        $comment_support = $request->get_param('comment_support');
        $user_id = $request->get_param('user_id');

        $comment_data = [
            'comment_support' => $comment_support,
            'user_id' => $user_id,
        ];

        $post_id = $this->customerSupportService->createSupport($comment_data);
        $protocolo = get_the_title($post_id);

        if ($post_id) {
            $response = array(
                'status' => 'sucesso',
                'mensagem' => 'Usuário criado com sucesso',
                'protocolo' => $protocolo,
            );

            return new WP_REST_Response($response, 200);
        }

        $response = array(
            'status' => 'erro',
            'mensagem' => 'Não foi possível criar o usuário',
        );
        return new WP_REST_Response($response, 500);
    }

    public function show()
    {
        if (!is_user_logged_in()) {
            wp_redirect(site_url('/login', 'https'));
            exit;
        }
        $supports = $this->getSupportID();
        ob_start();
        require_once plugin_dir_path(__FILE__) . '../views/customerSupport/CustomerSupportView.php';
        $output = ob_get_contents();
        ob_end_clean();
        return $output;
    }

    public function getSupportID() {
        $user_id = get_current_user_id();
        return $this->customerSupportService->getSupportID($user_id);
    }
}
