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
            'user_pass' => $password,
            'user_email' => $email,
            'display_name' => $name,
            'nickname' => $name,
            'first_name' => $name,
            'role' => $user_role,
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
            // 'user_pass' => $user->user_pass,
            'user_email' => $user->user_email,
            'user_login' => $user->user_login,
            'billing_first_name' => $user->billing_first_name,
            'billing_phone' => $user->billing_phone,
            'billing_postcode' => $user->billing_postcode,
            'billing_address_1' => $user->billing_address_1,
            'billing_state' => $user->billing_state,
            'billing_city' => $user->billing_city,

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

}
