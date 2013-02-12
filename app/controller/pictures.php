<?php
/**
***************************************************************************************************
 * @Software    AjaxMint Gallery
 * @Author      Rajapandian - arajapandi@gmail.com
 * @Copyright    Copyright (c) 2010-2011. All Rights Reserved.
 * @License        GNU GENERAL PUBLIC LICENSE
 **************************************************************************************************
 This source code is licensed under the terms of the GNU GENERAL PUBLIC LICENSE
 http://www.gnu.org/licenses/gpl.html
 **************************************************************************************************
 Copyright (c) 2010-2011 http://ajaxmint.com. All Rights Reserved.
 **************************************************************************************************
**/

class ControllerPictures extends Controller {
    
    function __construct() {
        $this->id       = 'content';        
        $this->layout   = 'layout';
        $this->template = $this->config->get('config_template') .'pictures.php';        
        $this->load->model('pictures');                                
    }
    /*
        getting the Album list from gallery
    */    
    function index() {                        
        if(!(int)$this->album_id = $this->data['album_id'] = $this->request->get['album_id']) {
             $this->redirect($this->config->get('config_site_dir').'/index.php');
        }                
        

        /* Navigation */
        $this->data['navigation'] = $this->model_pictures->albumNavLink($this->album_id);                    
    
        /*
            Get value using get method, if the value is null assign the default value
        */
        $page = $this->request->get['page'];
        if(!$page){
            $page = 1;
        }
        
        /* Pagination Code Starts Here */        
        $total = $this->data['total'] = $this->model_pictures->totalPictures($this->album_id);    
        $per_page = $this->config->get('pictures_per_page');
        $offset = ($page - 1) * $per_page;        
        
        /* Get the picture details using album_id */
        $this->data['fvalue'] = $this->model_pictures->picturesDetails($this->album_id,$offset,$per_page);        

        $pagination = new Pagination();
        $pagination->total = $total;
        $pagination->page = $page;
        $pagination->limit = $per_page; 
        $pagination->url = $this->seourl->rewrite('index.php?c=pictures&album_id='.$this->album_id.'&page=%s');
        $this->data['pagination'] = $pagination->render();
        /* Pagination Code Ends Here */
        $this->render();
    }

    function single() {        

        if(!(int)$this->picture_id = $this->data['picture_id'] = $this->request->get['picture_id']) {
             $this->redirect($this->config->get('config_site_dir').'/index.php');
        }
        $this->data['navigation'] = $this->model_pictures->pictureNavLink($this->picture_id);
        $this->data['fvalue'] = $this->model_pictures->getPicture($this->picture_id);
        /*
            Get List of Picture_id in the album
        */
        $this->model_pictures->getPictureList($this->data['fvalue']['album_id']);
        $this->data['next'] = $this->model_pictures->getNextPicture();
        $this->data['prev'] = $this->model_pictures->getPrevPicture();
            
        $this->template = $this->config->get('config_template') .'single.php';
        $this->render();
    }
}