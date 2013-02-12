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

class ControllerPictures extends Controller {

    function __construct() {
        $this->db = Registry::get('db');		
        $this->id = 'content';
        $this->layout   = 'layout';    
        $this->template = $this->config->get('config_template') . 'pictures.php';
        $this->data['album_id']=$this->album_id();
        $this->data['gallery_id']=$this->gallery_id();
        $this->data['picture_id']=$this->picture_id();
        $this->load->model('pictures');
        $this->load->model('albums');
        $this->model_albums->table=DB_PREFIX.'albums';
        if($this->album_id) {
                 $this->data['avalue'] = $this->model_albums->getAlbum($this->album_id);
                 $this->data['gallery_id']=$this->gallery_id=$this->data['avalue']['gallery_id'];
                 $this->data['gvalue'] = $this->model_albums->getGallery($this->gallery_id);        
        }
        $this->table = DB_PREFIX.'pictures';
        /* Assign the gallery & album dropdown*/ 
        $this->albumGalleryDropdown();
		

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
        $total = $this->data['total'] = $this->model_pictures->totalPictures($this->album_id,$this->gallery_id);    
        $per_page = $this->config->get('pictures_per_page');
        $offset = ($page - 1) * $per_page;                
        //for sort and number
        $this->data['record_start'] = ($page-1)*$per_page;        
        $this->data['page'] = $page;                
                
        /* Get the picture details using album_id */                            
        $this->data['fvalue'] = $this->model_pictures->getPictures($this->album_id,$offset,$per_page,$this->gallery_id);

        $pagination = new Pagination();
        $pagination->total = $total;
        $pagination->page = $page;
        $pagination->text = '';        
        $pagination->limit = $per_page; 
        $pagination->url = $this->url->http('pictures&album_id='.$this->album_id.'&gallery_id='.$this->gallery_id.'&page=%s');
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
        $this->template = $this->config->get('config_template') . 'pictures_edit.php';
        $this->render();
        
    }

    function delete() {
        $this->load->helper('image');
        if($picture_id = $this->request->get['picture_id'])  {
            $this->model_pictures->deletePicture($picture_id);
        }
        $this->redirect($this->url->http('pictures&album_id='.$this->album_id));
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
        if($this->gallery_id && $this->album_id) {
            $this->edit();
        }

        $fvalue['album_id'] = $this->album_id;
        if($fvalue['title'] && $fvalue['album_id']) {
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
            $fvalue = $this->model_pictures->savePicture($fvalue);
			
        } else {
            $fvalue['msg'] = "Mandatory Fields Missing";
        }        
        
        if($fvalue['msg']) {
            $this->data['fvalue'] = $fvalue;    
            $this->template = $this->config->get('config_template') . 'pictures_edit.php';
            $this->render();
        } else 
            $this->redirect($this->url->http('pictures&album_id='.$this->album_id));
        
    }
    function order() {

        $orderAr = $this->request->post['sortorder'];
        $page = $this->request->post['page'];
        if(count($orderAr)) {
            $this->model_pictures->order($orderAr);
        }
        $this->redirect($this->url->http('pictures&album_id='.$this->album_id.'&page='.$page.'&gallery_id='.$this->gallery_id));
    }    
    
    private function album_id(){
        return    $this->album_id = $this->request->get['album_id']?$this->request->get['album_id']:$this->request->post['album_id'];
    }
    
    private function gallery_id() {
        return $this->gallery_id=$this->request->get['gallery_id']?$this->request->get['gallery_id']:$this->request->post['gallery_id'];                            
    }
    
    private function picture_id() {
        return $this->picture_id=$this->request->get['picture_id']?$this->request->get['picture_id']:$this->request->post['picture_id'];                            
    }
	
    private function albumGalleryDropdown() {
        $this->load->model('gallery');
        $this->data['gallery_dropdown'] = $this->model_gallery->galleryDropdown($this->gallery_id);
        if($this->gallery_id)
           $this->data['albums_dropdown'] = $this->model_albums->albumsDropdown($this->gallery_id,$this->album_id);
    }		
}