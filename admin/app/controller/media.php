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

class ControllerMedia extends Controller {

    function __construct() {
        $this->db = Registry::get('db');		
        $this->id = 'content';
        $this->layout   = 'layout';    
        $this->template = $this->config->get('config_template') . 'media.php';
        $this->data['picture_id']=$this->picture_id();
        $this->load->model('media');

        $this->table = DB_PREFIX.'media';
        /* Assign the gallery & album dropdown*/ 		

    }    
    
    function index() {
        /*
            Get value using get method, if the value is null assign the default value
        */
        $page = $this->request->get['page'];
        if(!$page){
            $page = 1;
        }
        
        /* Pagination Code Starts Here */        
        $total = $this->data['total'] = $this->model_media->totalPictures();    
       $per_page = $this->config->get('pictures_per_page');
        $offset = ($page - 1) * $per_page;                
      //for sort and number
        $this->data['record_start'] = ($page-1)*$per_page;        
        $this->data['page'] = $page;                
              
        /* Get the picture details using album_id */                            
        $this->data['fvalue'] = $this->model_media->getPictures($offset,$per_page);

        $pagination = new Pagination();
        $pagination->total = $total;
        $pagination->page = $page;
        $pagination->text = '';        
        $pagination->limit = $per_page; 
        $pagination->url = $this->url->http('media&page=%s');
        $this->data['pagination'] = $pagination->render();
        /* Pagination Code Ends Here */        
                        
        $this->render();
    }
    
    function add() {
        
        $this->edit();
    }
	
    function edit() {

        if($this->picture_id) {
            $this->data['fvalue'] = $this->model_pictures->getPicture($this->picture_id);
        }    
        $this->template = $this->config->get('config_template') . 'media_edit.php';
        $this->render();
        
    }

    function delete() {
        $this->load->helper('image');
        if($picture_id = $this->request->get['id'])  {
            $this->model_media->deletePicture($picture_id);
        }
        $this->redirect($this->url->http('media'));
    }
    
    function callback() {
        $flag = $this->request->post['flag'];
        if($flag == 'albums') {
            $gallery_id = $this->request->post['gallery_id'];
            $this->load->model('albums');
            echo "<select name='album_id'><option value=''>Select..</option>".$this->model_albums->albumsDropdown($gallery_id)."</select>";
        }
        exit;
    }
    
    function save() {        

        $fvalue = $this->request->post['fvalue'];

//        if($this->gallery_id && $this->album_id) {
//            $this->edit();
//        }

//        $fvalue['album_id'] = $this->album_id;
        if($fvalue['title']) {
            //uploading the image to server
            $this->load->helper('image');
            if($this->request->files['image']) {
                  //removing hte old image
                 if($fvalue['picture_id'] && $this->request->files['image']['name'])removeimage($fvalue['old_image']);
			
                if($image = saveimage($this->request->files['image'])) {
                 image_resize($image,$this->config->get('config_thumb_width'), $this->config->get('config_thumb_height'),'thumb');
                 image_resize($image, $this->config->get('config_large_width'), $this->config->get('config_large_height'),'large');
                }
            }    
            $fvalue['image'] = $image;    		

            $fvalue = $this->model_media->savePicture($fvalue);
			
        } else {
            $fvalue['msg'] = "Mandatory Fields Missing";
        }        
        
        if($fvalue['msg']) {
            $this->data['fvalue'] = $fvalue;    
            $this->template = $this->config->get('config_template') . 'media_edit.php';
            $this->render();
        } else 
            $this->redirect($this->url->http('media'));
        
    }
    
    private function picture_id() {
        return $this->picture_id=$this->request->get['picture_id']?$this->request->get['picture_id']:$this->request->post['picture_id'];                            
    }
	
}
