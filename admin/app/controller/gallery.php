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


class ControllerGallery extends Controller {

    function __construct() {

        $this->db = Registry::get('db');
        $this->id = 'content';
        $this->table = DB_PREFIX.'gallery';
        $this->template = $this->config->get('config_template') . 'gallery.php';        
        $this->layout   = 'layout';
        $this->data['gallery_id']=$this->gallery_id();
        $this->load->model('gallery');
    }        
        
    function index() {
        $this->data['fvalue'] = $this->model_gallery->getGallerys();
        $this->render();
    }
    
    
    function add() {
        $this->edit();
    }    
    
    function edit() {
        if((int)$this->gallery_id) {
            $this->data['fvalue'] = $this->model_gallery->getGallery($this->gallery_id);
        }
        $this->template = $this->config->get('config_template') . 'gallery_edit.php';
        $this->render();
        
    }
    
    function save() {
        
        $fvalue = $this->request->post['fvalue'];
        if($this->data['gallery_id'])
            $fvalue['gallery_id'] = $this->data['gallery_id'];

        //uploading the image to server
        $this->load->helper('image');
        if($this->request->files['image']) {
		
	        if($fvalue['gallery_id'] && $this->request->files['image']['name']) removeimage($fvalue['old_image']);
            if($image = saveimage($this->request->files['image'])) {
            //removing hte old image
            image_resize($image,$this->config->get('gallery_thumb_width'), $this->config->get('gallery_thumb_height'),'thumb');			
            }    
        }
        $fvalue['image'] = $image;

        
        if($fvalue['name']) {        
            $fvalue = $this->model_gallery->saveGallery($fvalue);
        } else {
            $fvalue['msg'] = "Mandatory Fields Missing";
        }        
        
        if($fvalue['msg']) {
            $this->data['fvalue'] = $fvalue;
            $this->template = $this->config->get('config_template') . 'gallery_edit.php';
            $this->render();
        } else 
            $this->redirect($this->url->http('gallery'));
    }
        
    function order() {

        $orderAr = $this->request->post['sortorder'];
        if(count($orderAr)) {
            $this->model_gallery->order($orderAr);
        }
        $this->redirect($this->url->http('gallery'));

    }
    
    function delete() {
        if((int)$this->gallery_id)  {
            $this->model_gallery->deleteGallery($this->gallery_id);
        }
        $this->redirect($this->url->http('gallery'));
    }
    
    private function gallery_id() {
        return $this->data['gallery_id'] = $this->gallery_id = $this->request->get['gallery_id']?$this->request->get['gallery_id']:$this->request->post['gallery_id'];                            
    }
}