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
                delete_user_meta($user_id, 'confirmation_token');
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
            "SELECT ID, user_email FROM $wpdb->users WHERE user_nicename = %s",
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
                                                                            bgcolor="inherit">Você redefiniu sua senha!
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
                                                                                            <p style="margin: 0 0 38px;">Para entrar na plataforma vá para o login e utilize o token abaixo:</p>
                                                                                            <p style="margin: 0 0 60px;font-size:30px;">[TOKEN]</p>
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
