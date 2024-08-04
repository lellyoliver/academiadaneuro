<?php

require_once plugin_dir_path(__FILE__) . '../TextProcessor.php';

class AuthModel
{
    private $textProcessor;
    private $table_user;

    public function __construct()
    {
        global $wpdb;

        $this->textProcessor = new TextProcessor();
        $this->table_user = $wpdb->prefix . 'users';

    }

    public function sendEmail($user_id, $token)
    {

        if ($token && $user_id) {

            $meta_exist = get_user_meta($user_id, 'confirmation_token', $token);

            if ($meta_exist) {
                $email_confirmed = add_user_meta($user_id, 'email_confirmed', true);

                if ($email_confirmed) {
                    delete_user_meta($user_id, 'confirmation_token');
                }

                return true;
            }
        }
        return false;
    }

    public function processForgotPassword($data_register)
    {
        $user_login = $this->textProcessor->sanitizeText($data_register);
        $confirmation_token = wp_generate_password(8, false);

        global $wpdb;

        $query = $wpdb->prepare(
            "SELECT ID, user_email FROM $wpdb->users WHERE user_login = %s",
            $user_login
        );

        $result = $wpdb->get_results($query);

        if (!empty($result)) {
            $user_id = $result[0]->ID;
            $user_email = $result[0]->user_email;

            wp_set_password($confirmation_token, $user_id);

            $user_data = [
                'user_id' => $user_id,
                'user_email' => $user_email,
                'new_password' => $confirmation_token,
            ];

            $emailSanitizeAsterisk = $this->emailSanitizeAsterisk($user_email);

            $sendMail = $this->sendEmailConfirmation($user_data);

            return [$sendMail, $emailSanitizeAsterisk];

        } else {
            return "Não encontramos nenhum CPF/CNPJ cadastrado";
        }
    }

    private function sendEmailConfirmation($user_data)
    {
        $email = $user_data['user_email'];
        $token = $user_data['new_password'];

        $confirmation_link = site_url('/login', 'https');

        $subject = 'Confirmação de E-mail';
        $body = '<div width="100%" style="font-family: Arial; padding:20px;">
        <div style="margin-top:10px;margin-bottom:10px;">
            <img src="" alt="logo-academia.png" title="Academia da neurociência"/>
        </div>
        <div style="margin-top:30px; margin-bottom:10px;">
        <h2 style="color:#00A9E7; text-transform:uppercase;">Você redefiniu sua senha!</h2>
        </div>
        <div style="color:#1D1D1D;">
        <p>Para entrar na plataforma vá para o login e utilize o token abaixo:
        <br><br>
        <b>[TOKEN]</b></p>
        </div>
        <div style="margin-top:60px;"><a href="[CONFIRMATION_LINK]" title="Verificar" style="border-radius: 16px; background: #00a9e7; padding:20px 60px;  text-decoration:none; color:#ffffff;"><b>Fazer Login</b></a></div>
        <div style="width: 600px;height: 100px; background: #d1d1d1; margin-top:60px;"></div>
        </div>';

        $body = str_replace('[CONFIRMATION_LINK]', $confirmation_link, $body);
        $body = str_replace('[TOKEN]', $token, $body);

        $headers = array('Content-Type: text/html; charset=UTF-8');

        $envio = wp_mail($email, $subject, $body, $headers);

        if ($envio === true) {
            return true;
        } else {
            return false;
        }
    }

    private function emailSanitizeAsterisk($email)
    {
        $at_position = strpos($email, '@');

        $local_part = substr($email, 0, $at_position);
        $domain_part = substr($email, $at_position);
        $masked_local_part = $local_part[0] . str_repeat('*', strlen($local_part) - 1);

        $masked_email = $masked_local_part . $domain_part;

        return 'Foi enviada uma notificação para o email: ' . $masked_email;
    }
} 
