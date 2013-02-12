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


class ModelGallery extends Model {

    function __construct() {
        $this->load->helper('gallery');
        $this->helper = new HelperGallery();
    }

    /*
        Gallery Details using getGallery function
    */
    function galleryDetails() {
        $details = $this->getGallerys();
        $return = array();
        foreach($details as $key=>$value) {
            $return[$key] = $value;
            if(!$value['image']) {
                $value['image'] = $this->helper->getImage($value['gallery_id']);
            }
            $return[$key]['image'] = HTTP_THUMB.'/'.$value['image'];
            $return[$key]['link'] = $this->seourl->rewrite('index.php?c=albums&gallery_id='.$value['gallery_id'].'&title='.$value['name']);            
        }
        return $return;
    }

    /*
        Retrieve the Gallery List
    */    
    function getGallerys() {
            return $this->helper->getGallerys();
    }
}
