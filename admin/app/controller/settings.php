<?php
/**
***************************************************************************************************
 * @Software    AjaxMint Gallery
 * @Author      Rajapandian - arajapandi@gmail.com
 * @Copyright   Copyright (c) 2010-2011. All Rights Reserved.
 * @License     GNU GENERAL PUBLIC LICENSE
 **************************************************************************************************
 This source code is licensed under the terms of the GNU GENERAL PUBLIC LICENSE
 http://www.gnu.org/licenses/gpl.html
 **************************************************************************************************
 Copyright (c) 2010-2011 http://ajaxmint.com. All Rights Reserved.
 **************************************************************************************************
**/
  
class ControllerSettings extends Controller {

    function __construct() {
        $this->db = Registry::get('db');
        $this->id = 'content';
        $this->layout   = 'layout';
        $this->table   = DB_PREFIX.'setting';
        $this->template = $this->config->get('config_template') . 'settings.php';
        $this->load->model('settings');
    }    
    
    function index() {
        $this->data['fvalue'] = $this->model_settings->getSettings();
        $this->data['yn_dropdown'] = array('config_error_log','config_error_display','config_seo_url');;
        $this->render();
    }        
    
    function save() {
            
        $fvalue = $this->request->post['fvalue'];
        if(is_array($fvalue)) {
            $fvalue = $this->model_settings->saveSettings($fvalue);
            $fvalue['msg'] = "Mandatory Fields Missing";
            $this->index();
        }    
    }    
}
?>
