<?php
require_once plugin_dir_path(__FILE__) . '../TextProcessor.php';

class UserRelatedModel
{
    public function createUser($user_data)
    {

        $data = array(
            'user_login' => sanitize_text_field($user_data['name']),
            'user_pass' => $user_data['password'],
            'user_email' => sanitize_email($user_data['email']),
            'display_name' => sanitize_text_field($user_data['name']),
            'nickname' => sanitize_text_field($user_data['name']),
            'first_name' => sanitize_text_field($user_data['name']),
            'role' => 'coachingRelation',
            'show_admin_bar_front' => 'false',
            'description' => $user_data['description'],
            'meta_input' => [
                'billing_first_name' => sanitize_text_field($user_data['name']),
                'billing_phone' => sanitize_text_field($user_data['phone']),
                'billing_avatar' => '143',
            ],
        );

        $user_id = wp_insert_user($data);

        return $user_id;
    }

    public function updateUser($name, $email, $user_id, $password, $description)
    {

        $userdata = array(
            'ID' => $user_id,
            'user_login' => $name,
            'user_pass' => $password,
            'user_email' => $email,
            'display_name' => $name,
            'nickname' => $name,
            'first_name' => $name,
            'description' => $description,
        );

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

    public function getUserById($id)
    {
        $user = get_userdata($id);

        if (!$user) {
            return new WP_Error('user_not_found', 'User not found', array('status' => 404));
        }

        $user_data = array(
            'ID' => $user->ID,
            'user_pass' => $user->user_pass,
            'user_email' => $user->user_email,
            'description' => $user->description,
            'billing_first_name' => $user->billing_first_name,
            'billing_phone' => $user->billing_phone,
        );

        return $user_data;
    }

    public function getUserExpired()
    {
        $current_user_id = get_current_user_id();

        $user_ids = $this->getListUserRelated($current_user_id);
        $result = array(); // Defina o array $result fora do loop

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
            );
        }

        return $result;
    }

}
