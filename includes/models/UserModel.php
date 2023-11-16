<?php
require_once plugin_dir_path(__FILE__) . '../TextProcessor.php';

class UserModel
{
    private $textProcessor;

    public function __construct()
    {
        $this->textProcessor = new TextProcessor();
    }

    /**
     * Create a new user in WordPress database.
     *
     * @return int|WP_Error The user ID if successful, or WP_Error object on failure.
     */

    public function createUser($name, $email, $billing_data, $user_role, $password)
    {

        $user_name = $this->textProcessor->sanitizeText($billing_data);

        $userdata = array(
            'user_login' => $user_name,
            'user_pass' => md5($password),
            'user_email' => $email,
            'display_name' => $name,
            'nickname' => $name,
            'first_name' => $name,
            'role' => $user_role,
            'show_admin_bar_front' => false,
        );

        $user_id = wp_insert_user($userdata);

        return $user_id;
    }

    public function updateUser($name, $email, $user_id)
    {

        $userdata = array(
            'ID' => $user_id,
            'user_login' => $name,
            'user_email' => $email,
            'display_name' => $name,
            'nickname' => $name,
            'first_name' => $name,
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
        );

        return $user_data;
    }

    public function getLatestOrders($id)
    {
        if (class_exists('WooCommerce')) {
            $order_args = array(
                'numberposts' => 15,
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
    public function handleAvatarUpload($file, $post_id, $user_id)
    {
        if (isset($file, $post_id)) {
            require_once ABSPATH . 'wp-admin/includes/image.php';
            require_once ABSPATH . 'wp-admin/includes/file.php';
            require_once ABSPATH . 'wp-admin/includes/media.php';

            $attachment_id = media_handle_upload('avatar_file', $post_id);

            if (!is_wp_error($attachment_id)) {

                // $avatar_url = wp_get_attachment_image_url($attachment_id, '');
                return $attachment_id;

            } else {

                return "Não foi possível enviar arquivo";

            }
        }
    }

    public function getTermsAndServices($user_id, $current_user_id)
    {
        add_user_meta($user_id, 'connected_user', $current_user_id);

        return $user_id;
    }

}
