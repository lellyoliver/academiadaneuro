<?php
require_once plugin_dir_path(__FILE__) . '../models/UserModel.php';

class UserService
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function createUser($name, $email, $password)
    {
        return $this->userModel->createUser($name, $email, $password);
    }

    public function updateMetaUser($meta_fields, $user_id)
    {
        return $this->userModel->updateMeta($meta_fields, $user_id);
    }
    
    public function getCities()
    {
        global $wpdb;

        $results = $wpdb->get_results("SELECT DISTINCT city_name FROM wp9o_cities order by city_name ASC");

        $cities = array();
        foreach ($results as $result) {
            $city = $result->city_name;
            $cities[] = $city;
        }

        return $cities;
    }
    public function getStates()
    {
        global $wpdb;

        $results = $wpdb->get_results("SELECT DISTINCT state_code FROM wp9o_cities order by state_code ASC");

        $states = array();
        foreach ($results as $result) {
            $state = $result->state_code;
            $states[] = $state;
        }

        return $states;
    }
}
