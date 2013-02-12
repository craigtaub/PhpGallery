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

class ControllerAlbums extends Controller {

    function __construct() {
        $this->db = Registry::get('db');
        $this->id = 'content';
        $this->table = DB_PREFIX.'albums';
        $this->template = $this->config->get('config_template') . 'albums.php';        
        $this->layout   = 'layout';                    
        $this->data['gallery_id']=$this->gallery_id();
		$this->load->model('albums');  
        $this->load->model('gallery');  
    }        

    function index() {        

        $this->data['gvalue'] = $this->model_albums->getGallery($this->gallery_id);
		
		/*
			Load the filter dropdown from helper gallery
		*/
        $this->load->model('gallery');
        $this->data['gallery_dropdown'] = $this->model_gallery->galleryDropdown($this->gallery_id);
			
		        
        /*
            Get value using get method, if the value is null assign the default value
        */
        $page = $this->request->get['page'];
        if(!$page){
            $page = 1;
        }
        
        /* Pagination Code Starts Here */        
        $total = $this->data['total'] = $this->model_albums->totalAlbums($this->gallery_id);    
        $per_page = $this->config->get('albums_per_page');
        $offset = ($page - 1) * $per_page;
        $this->data['record_start'] = ($page-1)*$per_page;
        $this->data['page'] = $page;
        

        /* Get the album details using album_id */
        $this->data['fvalue'] = $this->model_albums->getAlbums($this->gallery_id,$offset,$per_page);    

        $pagination = new Pagination();
        $pagination->total = $total;
        $pagination->page = $page;
        $pagination->text = '';
        $pagination->limit = $per_page; 
        $pagination->url = $this->url->http('albums&gallery_id='.$this->gallery_id.'&page=%s');
        $this->data['pagination'] = $pagination->render();
        /* Pagination Code Ends Here */
        $this->render();
    }
    
    
    function add() {
        $this->edit();
    }
	
    function edit() {
    
        $album_id = $this->request->get['album_id'];
		
		
        if($album_id) {
            $this->data['fvalue'] = $this->model_albums->getAlbum($album_id);
            $this->data['gallery_id']=$this->gallery_id = $this->data['fvalue']['gallery_id'];
        }

        $this->data['gallery_dropdown'] = $this->model_gallery->galleryDropdown($this->gallery_id);		
		
        $this->data['gvalue'] = $this->model_albums->getGallery($this->gallery_id);        
        $this->template = $this->config->get('config_template') . 'albums_edit.php';
        $this->render();                    
        
    }    
    
    function save() {
        
        $fvalue = $this->request->post['fvalue'];
        if($fvalue['title'] && $fvalue['gallery_id']) {
            //uploading the image to server
            $this->load->helper('image');
            if($this->request->files['image']) {
                //removing hte old image
              if($fvalue['album_id']  && $this->request->files['image']['name'])removeimage($fvalue['old_image']);
			
              if($image = saveimage($this->request->files['image'])) {                
                image_resize($image,$this->config->get('album_thumb_width'), $this->config->get('album_thumb_height'),'thumb');
              }
            }
            $fvalue['image'] = $image;
            $fvalue = $this->model_albums->saveAlbums($fvalue);
        } else {
            $msg = "Mandatory Fields Missing";
        }

        if($msg) {
            $this->data['msg'] = $msg;
            $this->edit();
        } else 
            $this->redirect($this->url->http('albums&gallery_id='.$this->gallery_id));
    }  
    /*
        Order the album values
    */
    function order() {

        $orderAr = $this->request->post['sortorder'];
        $page = $this->request->post['page'];
        if(count($orderAr)) {
            $this->model_albums->order($orderAr);
        }

        $this->redirect($this->url->http('albums&gallery_id='.$this->gallery_id.'&page='.$page));
    }    
    
    function delete() {                
        if($album_id = $this->request->get['album_id'])  {
            $this->model_albums->deleteAlbum($album_id);
        }        
        $this->redirect($this->url->http('albums&gallery_id='.$this->gallery_id));        
    }

    private function gallery_id() {
        return $this->gallery_id=$this->request->get['gallery_id']?$this->request->get['gallery_id']:$this->request->post['gallery_id'];                            
    }
}