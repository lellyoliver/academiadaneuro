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
        $confirmation_link = site_url('', 'https') . '/email-confirmation?token=' . $confirmation_token . '&key=' . $user_id;

        // Construa o conteúdo do e-mail
        $subject = 'Confirmação de E-mail';
        $body = '<table width="100%" id="outer_wrapper" style="background-color: #f7f7f7;" bgcolor="#f7f7f7">
        <tbody>
            <tr>
                <td><!-- Deliberately empty to support consistent sizing and layout across multiple email clients. -->
                </td>
                <td width="600">
                    <div id="wrapper" dir="ltr"
                        style="margin: 0 auto; padding: 70px 0; width: 100%; max-width: 600px; -webkit-text-size-adjust: none;"
                        width="100%">
                        <table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%">
                            <tbody>
                                <tr>
                                    <td align="center" valign="top">
                                        <div id="template_header_image" style="margin-bottom:38px;">
                                            <img src="https://cdn.institutodeneurociencia.com.br/image/logo-vertical.svg" alt="Logo" width="200">
                                        </div>
                                        <table border="0" cellpadding="0" cellspacing="0" width="100%"
                                            id="template_container"
                                            style="background-color: #fff; border: 1px solid #dedede; box-shadow: 0 1px 4px rgba(0,0,0,.1); border-radius: 3px;"
                                            bgcolor="#fff">
                                            <tbody>
                                                <tr>
                                                    <td align="center" valign="top">
                                                        <!-- Header -->
                                                        <table border="0" cellpadding="0" cellspacing="0" width="100%"
                                                            id="template_header"
                                                            style="background-color: #00a9e7; color: #fff; border-bottom: 0; font-weight: bold; line-height: 100%; vertical-align: middle; font-family: Helvetica Neue,Helvetica,Roboto,Arial,sans-serif; border-radius: 3px 3px 0 0;"
                                                            bgcolor="#00a9e7">
                                                            <tbody>
                                                                <tr>
                                                                    <td id="header_wrapper"
                                                                        style="padding: 36px 48px; display: block;">
                                                                        <h1 style="font-family: Helvetica Neue,Helvetica,Roboto,Arial,sans-serif; font-size: 30px; font-weight: 300; line-height: 150%; margin: 0; text-align: left; text-shadow: 0 1px 0 #33baec; color: #fff; background-color: inherit;"
                                                                            bgcolor="inherit">Obrigado por se cadastrar!
                                                                        </h1>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                        <!-- End Header -->
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td align="center" valign="top">
                                                        <!-- Body -->
                                                        <table border="0" cellpadding="0" cellspacing="0" width="100%"
                                                            id="template_body">
                                                            <tbody>
                                                                <tr>
                                                                    <td valign="top" id="body_content"
                                                                        style="background-color: #fff;" bgcolor="#fff">
                                                                        <!-- Content -->
                                                                        <table border="0" cellpadding="20"
                                                                            cellspacing="0" width="100%">
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td valign="top"
                                                                                        style="padding: 48px 48px 32px;">
                                                                                        <div id="body_content_inner"
                                                                                            style="color: #636363; font-family: Helvetica Neue,Helvetica,Roboto,Arial,sans-serif; font-size: 14px; line-height: 150%; text-align: left;"
                                                                                            align="left">
                                                                                            <h2 style="color: #00a9e7; display: block; font-family: Helvetica Neue,Helvetica,Roboto,Arial,sans-serif; font-size: 18px; font-weight: bold; line-height: 130%; margin: 0 0 18px; text-align: left;">
                                                                                                Confirme sua senha e mantenha sua conta segura!</h2>
                                                                                            <p style="margin: 0 0 16px;">Estamos comprometidos em garantir a segurança de sua conta e queremos garantir que você tenha acesso fácil e seguro.</p>
                                                                                            <p style="margin: 0 0 32px;">Para confirmar sua senha e garantir a proteção de sua conta, por favor, siga as etapas simples abaixo:</p>
                                                                                            <a href="[CONFIRMATION_LINK]" title="Verificar" style="border-radius: 7px;background:#00a9e7;padding: 16px 60px;text-decoration:none;color:#ffffff;" target="_blank"><b>Verificar</b></a>
                                                                                            <p style="margin: 0 0 38px;"></p>
                                                                                        </div>
                                                                                    </td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                        <!-- End Content -->
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td valign="top" id="body_content"
                                                                        style="background-color: #fff;" bgcolor="#fff">
                                                                        <table border="0" cellpadding="20"
                                                                            cellspacing="0" width="100%">

                                                                            <tr style="background-color: #E7E7E7;">
                                                                                <td valign="top"
                                                                                    style="padding: 48px 48px 32px;">
                                                                                    <div id="body_content_inner"
                                                                                        style="color: #636363; font-family: Helvetica Neue,Helvetica,Roboto,Arial,sans-serif; font-size: 14px; line-height: 150%; text-align: left;"
                                                                                        align="left">
                                                                                        <ul style="font-size:13px;list-style: none;margin-left: -33px;">
                                                                                            <li>Instituto de Neurociencia Comportamental</li>
                                                                                            <li>Rua Sao Gabriel, 1555 - Sala 104 Andar 1</li>
                                                                                            <li>Vila Belvedere - 13473-000</li>
                                                                                            <li>Americana / São Paulo</li>
                                                                                        </ul>
                                                                                    </div>
                                                                                </td>
                                                                                <td valign="top"
                                                                                    style="padding: 48px 48px 32px;">
                                                                                    <div id="body_content_inner"
                                                                                        style="color: #636363; font-family: Helvetica Neue,Helvetica,Roboto,Arial,sans-serif; font-size: 14px; line-height: 150%; text-align: left;"
                                                                                        align="left">
                                                                                        <ul style="list-style: none;">
                                                                                            <li style="display: inline;margin-right: 10px;">
                                                                                                <a href="https://www.facebook.com/institutodeneurocienciacomportamental" title="facebook" alt="facebook"><img src="https://cdn.institutodeneurociencia.com.br/image/icon-facebook.svg" alt="facebook" title="facebook" width="20" height="20"></a>
                                                                                            </li>
                                                                                            <li style="display: inline;margin-right: 10px;">
                                                                                                <a href="#" title="facebook" alt=""><img src="https://cdn.institutodeneurociencia.com.br/image/icon-instagram.svg" alt="Instagram" title="Instagram" width="20" height="20"></a>
                                                                                            </li>
                                                                                            <li style="display: inline;margin-right: 10px;">
                                                                                                <a href="https://wp.me/+551936044798" title="whatsapp" alt="Whatsapp"><img src="https://cdn.institutodeneurociencia.com.br/image/icon-whatsapp.svg" alt="Instagram" title="Instagram" width="20" height="20"></a>
                                                                                            </li>

                                                                                        </ul>
                                                                                    </div>
                                                                                </td>
                                                                            </tr>

                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                        <!-- End Body -->
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="center" valign="top">
                                        <!-- Footer -->
                                        <table border="0" cellpadding="10" cellspacing="0" width="100%"
                                            id="template_footer">
                                            <tbody>
                                                <tr>
                                                    <td valign="top" style="padding: 0; border-radius: 6px;">
                                                        <table border="0" cellpadding="10" cellspacing="0" width="100%">
                                                            <tbody>
                                                                <tr>
                                                                    <td colspan="2" valign="middle" id="credit"
                                                                        style="border-radius: 6px; border: 0; color: #8a8a8a; font-family: Helvetica Neue,Helvetica,Roboto,Arial,sans-serif; font-size: 12px; line-height: 150%; text-align: center; padding: 24px 0;"
                                                                        align="center">
                                                                        <p style="margin: 0 0 16px;">Academia da
                                                                            Neurociência</p>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <!-- End Footer -->
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </td>
                <td><!-- Deliberately empty to support consistent sizing and layout across multiple email clients. -->
                </td>
            </tr>
        </tbody>
    </table>';

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
            'user_nicename' => $user->user_nicename,
            'billing_first_name' => $user->billing_first_name,
            'billing_phone' => $user->billing_phone,
            'billing_postcode' => $user->billing_postcode,
            'billing_address_1' => $user->billing_address_1,
            'billing_state' => $user->billing_state,
            'billing_city' => $user->billing_city,
            'billing_avatar' => wp_get_attachment_image_url($user->billing_avatar, ''),
        );

        return $user_data;
    }

    public function getLatestOrders($id)
    {
        if (class_exists('WooCommerce')) {
            $order_args = array(
                'numberposts' => 10,
                'post_type' => 'shop_order',
                'post_status' => array('wc-completed', 'wc-processing', 'wc-refunded'),
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
                'user_id' => $meta_value->user_id,
                'status' => $status,
            );
        }

        return $result;
    }

    public function newUserExpired($user_id)
    {
        $order = wc_create_order();

        $product_id = 127;
        $order->add_product(get_product($product_id), 1);

        $order->set_customer_id($user_id);

        $order->calculate_totals();

        $order->save();

        $order_id = $order->get_id();

        $product_data = array(
            127 => '+7 days',
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
                        'product_id' => $product_id,
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

    public function orderRefunded($order_id)
    {

        // $order = wc_get_order($order_id);

        // $comment_content = 'Pedido de reembolso';
        // $order->add_order_note($comment_content);
        // $comment_success = $order->save();

        // if ($comment_success) {
        //     return $comment_success;
        // }

        // return false;

        // Obtém o objeto WC_Order pelo ID do pedido

        $order = wc_get_order($order_id);

        if ($order && $order->get_status() === 'completed') {

            $refund_amount = $order->get_total();

            $refund_note = 'Pedido de Reembolso';
            $order->add_order_note($refund_note);

            $refund_id = wc_create_refund(
                array(
                    'amount' => $refund_amount,
                    'reason' => $refund_note,
                    'order_id' => $order_id,
                    'line_items' => $order->get_items(),
                    'refund_payment' => true, // Defina como true se quiser reembolsar também o pagamento
                )
            );

            $order->update_status('refunded');

            $order->add_order_note('Cliente notificado sobre o reembolso.');

            $comment_success = $order->save();
            
            if ($comment_success) {
                return $comment_success;
            }

        }

    }

}
