<?php
/**
***************************************************************************************************
 * @Software    AjaxMint Gallery
 * @Author      Rajapandian - arajapandi@gmail.com
 * @Copyright	Copyright (c) 2010-2011. All Rights Reserved.
 * @License		GNU GENERAL PUBLIC LICENSE
 **************************************************************************************************
 This source code is licensed under the terms of the GNU GENERAL PUBLIC LICENSE
 http://www.gnu.org/licenses/gpl.html
 **************************************************************************************************
 Copyright (c) 2010-2011 http://ajaxmint.com. All Rights Reserved.
 **************************************************************************************************
**/

final class HelperUser {
    private $user_id;
    private $username;
      private $permission = array();

      public function __construct() {
        $this->db = Registry::get('db');
        $this->request = Registry::get('request');
        $this->session = Registry::get('session');
        
        if (isset($this->session->data['user_id'])) {
            $user_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "user WHERE user_id='" . (int)$this->db->escape($this->session->data['user_id']) . "'");
            
            if ($user_query->num_rows) {
                $this->user_id = $user_query->row['user_id'];
                $this->username = $user_query->row['username'];
                
                  $this->db->query("UPDATE " . DB_PREFIX . "user SET ip='" . $this->db->escape($this->request->server['REMOTE_ADDR']) . "',last_login=NOW() WHERE user_id = '" . (int)$this->session->data['user_id'] . "'");

            } else {
                $this->logout();
            }
        }
      }
        
      public function login($username, $password) {
        $user_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "user WHERE username='" . $this->db->escape($username) . "' AND password = '" . md5($this->db->escape($password)) . "'");

        if ($user_query->num_rows) {
            $this->session->data['user_id'] = $user_query->row['user_id'];
            
            $this->user_id = $user_query->row['user_id'];
            $this->username = $user_query->row['username'];
        
              return true;
        } else {
              return false;
        }
      }

      public function logout() {
        unset($this->session->data['user_id']);    
        $this->user_id = '';
        $this->username = '';
      }

      public function hasPermission() {
        if ($this->user_id) {
              return TRUE;
        } else {
              return FALSE;
        }
      }
  
      public function isLogged() {
        return $this->user_id;
      }
  
      public function getId() {
        return $this->user_id;
      }
    
      public function getUserName() {
        return $this->username;
      }    
}
?>
