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

class ControllerIndex extends Controller {
    
    function __construct() {
        $this->id       = 'content';
        $this->layout   = 'layout';
        $this->template = $this->config->get('config_template') .'index.php';
        $this->load->model('gallery');
    }
    
    function index() {
        $this->data['fvalue'] = $this->model_gallery->galleryDetails();
        $this->render();
    }
}