<?php
require_once plugin_dir_path(__FILE__) . '../TextProcessor.php';
// require_once 'wp-load.php';

class UserModel
{
    private $textProcessor;

    public function __construct()
    {
        $this->textProcessor = new TextProcessor;
    }

    /**
     * Create a new user in WordPress database.
     *
     * @return int|WP_Error The user ID if successful, or WP_Error object on failure.
     */

    public function createUser($user_data)
    {
        $user_name = $this->textProcessor->sanitizeText($user_data['billing_data']);
        $current_timestamp = current_time('timestamp');
        $current_datetime = date('Y-m-d H:i:s', $current_timestamp);
        $confirmation_token = wp_generate_password(32, false);

        $data = array(
            'user_login' => $user_name,
            'user_pass' => sanitize_text_field($user_data['password']),
            'user_email' => sanitize_email($user_data['email']),
            'display_name' => sanitize_text_field($user_data['name']),
            'nickname' => sanitize_text_field($user_data['name']),
            'first_name' => sanitize_text_field($user_data['name']),
            'role' => sanitize_text_field($user_data['role']),
            'show_admin_bar_front' => 'false',
            'meta_input' => [
                'billing_first_name' => sanitize_text_field($user_data['name']),
                'billing_phone' => sanitize_text_field($user_data['phone']),
                'billing_city' => sanitize_text_field($user_data['city']),
                'first_login' => $current_datetime,
                'confirmation_token' => sanitize_text_field($confirmation_token),
                'confirm_terms_services' => sanitize_text_field($user_data['termsAndServices']),
                'billing_avatar' => '143',
            ],
        );

        $user_id = wp_insert_user(wp_slash($data));

        $confirmation_email_sent = $this->sendEmailConfirmation($user_data, $confirmation_token, $user_id);

        $this->newUserExpired($user_id);

        if (!$user_id || !$confirmation_email_sent) {

            return false;
        }

        return $user_id;
    }

    private function sendEmailConfirmation($user_data, $confirmation_token, $user_id)
    {
        $name = sanitize_text_field($user_data['name']);
        $email = sanitize_text_field($user_data['email']);

        // Construa o link de confirmação com o token
        $confirmation_link = 'https://lellyoliver.com.br/academiadaneurociencia/email-confirmation?token=' . $confirmation_token . '&key=' . $user_id;

        // Construa o conteúdo do e-mail
        $subject = 'Confirmação de E-mail';
        $body = '<div width="100%" style="font-family: Arial; padding:20px;">
        <div style="margin-top:10px;margin-bottom:10px;">
            <img src="" alt="logo-academia.png" title="Academia da neurociência"/>
        </div>
        <div style="margin-top:30px; margin-bottom:10px;">
        <h2 style="color:#00A9E7; text-transform:uppercase;">Confirme sua solicitação<br>
        de encaminhamento de e-mail</h2>
        </div>
        <div style="color:#1D1D1D;">
        <p>Para começar a encaminhar e-mails, você precisa verificar <br>sua solicitação.
        <br><br>
        Clique no botão abaixo para concluir o processo e <br>começar a encaminhar seus e-mails.</p>
        </div>
        <div style="margin-top:60px;"><a href="[CONFIRMATION_LINK]" title="Verificar" style="border-radius: 16px; background: #00a9e7; padding:20px 60px;  text-decoration:none; color:#ffffff;"><b>VERIFICAR</b></a></div>
        <div style="width: 600px;height: 100px; background: #d1d1d1; margin-top:60px;"></div>
        </div>';

        $body = str_replace('[CONFIRMATION_LINK]', $confirmation_link, $body);

        $headers = array('Content-Type: text/html; charset=UTF-8');

        $envio = wp_mail($email, $subject, $body, $headers);

        if ($envio === true) {
            return true;
        } else {
            return false;
        }
    }

    public function updateUser($name, $email, $password, $user_id)
    {

        $token = sanitize_text_field($password);
        
        wp_set_password($token, $user_id);
        wp_set_auth_cookie($user_id);

        $userdata = array(
            'ID' => $user_id,
            'user_email' => sanitize_email($email),
            'display_name' => sanitize_text_field($name),
            'nickname' => sanitize_text_field($name),
            'first_name' => sanitize_text_field($name),
        );

        $user_updated = wp_update_user($userdata);

        return $user_updated;
    }

    /**
     * Update user meta fields in WordPress database.
     *
     * @param array $meta_fields An array of user meta fields to be updated.
     * @param int $user_id The ID of the user whose meta data will be updated.
     * @return array An array containing the updated user meta data.
     */
    public function updateMeta($meta_fields, $user_id)
    {
        foreach ($meta_fields as $key => $value) {
            update_user_meta($user_id, $key, $value);
        }

        return get_user_meta($user_id);
    }

    /**
     * Get user details by ID.
     *
     * @param int $id The ID of the user.
     * @return array|WP_Error The user details or an error response.
     */
    public function getUserById($id)
    {
        $user = get_userdata($id);

        if (!$user) {
            return new WP_Error('user_not_found', 'User not found', array('status' => 404));
        }

        $user_data = array(
            'ID' => $user->ID,
            'user_email' => $user->user_email,
            'user_login' => $user->user_login,
            'billing_first_name' => $user->billing_first_name,
            'billing_phone' => $user->billing_phone,
            'billing_postcode' => $user->billing_postcode,
            'billing_address_1' => $user->billing_address_1,
            'billing_state' => $user->billing_state,
            'billing_city' => $user->billing_city,
            'billing_avatar' => wp_get_attachment_image_url($user->billing_avatar, ''),
            'user_pass' => $user->user_pass,
        );

        return $user_data;
    }

    public function getLatestOrders($id)
    {
        if (class_exists('WooCommerce')) {
            $order_args = array(
                'numberposts' => 5,
                'post_type' => 'shop_order',
                'post_status' => 'wc-completed',
                'meta_key' => '_customer_user',
                'meta_value' => $id,
                'orderby' => 'date',
                'order' => 'DESC',
            );

            $orders = get_posts($order_args);

            return $orders;
        }
    }

    /**
     * Handle avatar upload.
     *
     */
    public function handleAvatarUpload($file, $post_id)
    {
        if (isset($file, $post_id)) {
            require_once ABSPATH . 'wp-admin/includes/image.php';
            require_once ABSPATH . 'wp-admin/includes/file.php';
            require_once ABSPATH . 'wp-admin/includes/media.php';

            $attachment_id = media_handle_upload('avatar_file', $post_id);

            if (!is_wp_error($attachment_id)) {
                $avatar_url = wp_get_attachment_image_url($attachment_id, '');
                return $attachment_id;

            } else {
                return false;
            }
        }
    }

    public function getUserExpired()
    {
        $current_user_id = get_current_user_id();

        $result = array();

        $connected_user_meta = get_user_meta($current_user_id, 'connected_user', true);

        if (!empty($connected_user_meta)) {
            $user_id_related = $connected_user_meta;
            $meta_values = get_user_meta($user_id_related, $current_user_id . "_user_expired", false);
        } else {
            $meta_values = get_user_meta($current_user_id, $current_user_id . '_user_expired', false);
        }

        if (!empty($meta_values)) {
            foreach ($meta_values as $meta_value) {
                $meta_object = json_decode($meta_value);

                if ($meta_object !== null) {
                    $result[] = $meta_object;
                } else {
                    echo 'Falha ao decodificar JSON: ' . json_last_error_msg();
                }
            }
        }

        return $result;
    }

    public function userExpiredData()
    {
        $func_meta = $this->getUserExpired();

        $result = array();

        foreach ($func_meta as $meta_value) {
            $expiration_date = strtotime($meta_value->expiration_date);
            $current_date = strtotime('now'); // Obtém a data atual

            $status = '';

            if ($current_date < strtotime('+1 day', $expiration_date)) {
                $status = true;
            } else {
                $status = false;
            }

            $result[] = array(
                'user_related' => $meta_value->user_related,
                'status' => $status,
            );
        }

        return $result;
    }

    public function newUserExpired($user_id)
    {
        // Crie um novo objeto de pedido
        $order = wc_create_order();

        $product_id = 361;
        $order->add_product(get_product($product_id), 1);

        $order->set_customer_id($user_id);

        $order->calculate_totals();

        $order->save();

        $order_id = $order->get_id();

        $product_data = array(
            361 => '+7 days',
        );

        $order = wc_get_order($order_id);

        if ($order) {
            $order_date = $order->get_date_created()->format('Y-m-d'); // Data da compra

            foreach ($order->get_items() as $item_id => $item) {

                if (array_key_exists($product_id, $product_data)) {
                    $expiration_date = date('Y-m-d', strtotime($order_date . $product_data[$product_id]));

                    $response_data = array(
                        'order_id' => $order_id,
                        'order_date' => $order_date,
                        'user_id' => $user_id,
                        'expiration_date' => $expiration_date,
                    );

                    $json_response = json_encode($response_data);

                    update_user_meta($user_id, $user_id . '_user_expired', $json_response);

                    $order->update_status('completed');

                    break;
                }
            }
        }
    }
}
