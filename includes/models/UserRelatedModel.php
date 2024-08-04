<?php
require_once plugin_dir_path(__FILE__) . '../TextProcessor.php';

class UserRelatedModel
{
    private $textProcessor;

    public function __construct()
    {
        $this->textProcessor = new TextProcessor;
    }

    public function createUser($user_data)
    {
        $phone = $this->textProcessor->sanitizeText($user_data['phone']);

        $data = array(
            'user_login' => sanitize_text_field($user_data['name']),
            'user_pass' => sanitize_text_field($user_data['password']),
            'user_email' => sanitize_email($user_data['email']),
            'display_name' => sanitize_text_field($user_data['name']),
            'nickname' => sanitize_text_field($user_data['name']),
            'first_name' => sanitize_text_field($user_data['name']),
            'role' => 'coachingRelation',
            'show_admin_bar_front' => 'false',
            'description' => $user_data['description'],
            'meta_input' => [
                'billing_first_name' => sanitize_text_field($user_data['name']),
                'billing_phone' => $phone,
                'billing_avatar' => '145',
                'date_birth' => sanitize_text_field($user_data['date_birth']),
            ],
        );

        $user_id = wp_insert_user($data);

        if (is_wp_error($user_id)) {
            return false;
        }

        return $user_id;
    }

    public function updateUser($name, $email, $user_id, $password, $description)
    {

        $userdata = array(
            'ID' => $user_id,
            'user_login' => sanitize_text_field($name),
            'user_email' => sanitize_email($email),
            'display_name' => sanitize_text_field($name),
            'nickname' => sanitize_text_field($name),
            'first_name' => sanitize_text_field($name),
            'description' => sanitize_text_field($description),

        );
        
        if (!empty($password)) {
            wp_set_password($password, $user_id);
        }

        $user_updated = wp_update_user($userdata);

        return $user_updated;
    }

    public function updateMeta($meta_fields, $user_id)
    {
        foreach ($meta_fields as $key => $value) {
            update_user_meta($user_id, $key, $value);
        }

        return get_user_meta($user_id);
    }

    public function deleteUser($id)
    {
        global $wpdb;

        $wpdb->delete($wpdb->usermeta, array('user_id' => $id));
        $wpdb->delete($wpdb->users, array('ID' => $id));
        $wpdb->delete($wpdb->training_replies, array('user_id' => $id));
        $wpdb->delete($wpdb->training_progress, array('user_id' => $id));

        $deleted_user = get_user_by('ID', $id);

        if (!$deleted_user) {
            return true;
        } else {
            return false;
        }
    }

    public function createRelated($user_id, $current_user_id)
    {
        add_user_meta($user_id, 'connected_user', $current_user_id);

        return $user_id;
    }

    public function getListUserRelated($current_user_id)
    {
        $metadata = array(
            'meta_key' => 'connected_user',
            'meta_value' => $current_user_id,
            'fields' => 'all_with_meta',
            'orderby' => 'display_name',
            'order' => 'ASC',
        );

        $users_data = get_users($metadata);

        return $users_data;
    }

    public function getLatestOrders()
    {
        if (!class_exists('WooCommerce')) {
            return array();
        }

        $user_id = get_current_user_id();

        if (!$user_id) {
            return array();
        }

        $orders = wc_get_orders(array(
            'limit' => 10,
            'orderby' => 'date',
            'order' => 'DESC',
            'customer' => $user_id,
        ));

        $result_data = array();

        foreach ($orders as $order) {
            $order_id = $order->get_id();
            $items = $order->get_items();
            $product_names = array();
            $meta_order = get_post_meta($order_id, 'billing_user_related', true);

            foreach ($items as $item) {
                $product = $item->get_product();
                $product_names[] = $product->get_name();
            }

            $product_names_string = implode(', ', $product_names);
            $result_data[$meta_order] = $product_names_string;
        }

        return $result_data;
    }

    public function getUserById($id)
    {
        $user = get_userdata($id);

        if (!$user) {
            return new WP_Error('user_not_found', 'Usuário não encontrado', array('status' => 404));
        }

        $user_data = array(
            'ID' => $user->ID,
            'user_pass' => $user->user_pass,
            'user_email' => $user->user_email,
            'description' => $user->description,
            'billing_first_name' => $user->billing_first_name,
            'billing_phone' => $user->billing_phone,
            'date_birth' => $user->date_birth,
        );

        return $user_data;
    }

    public function newUserExpired($current_user_id, $user_id)
    {
        $free_trial = get_user_meta($current_user_id, 'free_trial', true);

        if ($free_trial) {
            $order = wc_create_order();
            $_plan_trial = get_option('_plan_trial');
            $product_id = $_plan_trial;
            $order->add_product(get_product($product_id), 1);

            $order->set_customer_id($current_user_id);

            $order->calculate_totals();

            $order->save();

            $order_id = $order->get_id();

            $product_data = array(
                $_plan_trial => '+7 days',
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

                        update_user_meta($current_user_id, $user_id . '_user_expired', $json_response);

                        $created_order = $order->update_status('completed');

                        if ($created_order) {
                            delete_user_meta($current_user_id, 'free_trial', true);
                        }

                        break;
                    }
                }
            }
        } else {
            return;
        }

    }

    public function getUserExpired()
    {
        $current_user_id = get_current_user_id();

        $user_ids = $this->getListUserRelated($current_user_id);
        $result = array();

        foreach ($user_ids as $user_id) {
            $meta_values = get_user_meta($current_user_id, $user_id->id . '_user_expired', false);

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
        }

        return $result;
    }

    public function userExpiredData()
    {
        $func_meta = $this->getUserExpired();

        $result = array();

        foreach ($func_meta as $meta_value) {
            $expiration_date = strtotime($meta_value->expiration_date);
            $order_date = strtotime($meta_value->order_date);
            $current_date = strtotime('now'); // Obtém a data atual

            $status = '';

            $time_difference = $expiration_date - $current_date;

            if ($current_date < strtotime('+1 day', $expiration_date)) { // Menos de 2 dias restantes (172800 segundos = 2 dias)
                $status = true;
            } else {
                $status = false;
            }

            $result[] = array(
                'user_id' => $meta_value->user_id,
                'status' => $status,
                'order_date' => date_i18n('d/m/Y',$order_date),
                'expiration_date' => date_i18n('d/m/Y',$expiration_date),
            );
        }

        return $result;
    }

}
