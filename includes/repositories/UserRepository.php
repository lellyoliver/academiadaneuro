<?php

class UserRepository {
    // Método para obter um usuário por ID
    public function getUserId($user_id) {
      $user = get_userdata($user_id);
  
      if (!$user) {
        return false;
      }
  
      return array(
        'id' => $user_id,
        'name' => $user->display_name,
        'email' => $user->user_email
      );
    }
  }
  