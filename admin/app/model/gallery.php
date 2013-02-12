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

class ModelGallery extends Model {
    
    function __construct() {
        $this->load->helper('gallery');
        $this->gl_helper = new HelperGallery();

    }
        
    function galleryDropdown($sel='') {
        $this->load->helper('helpers');
        $this->commonhelpers = new HelperHelpers();
        $result = $this->db->query("SELECT * FROM ".DB_PREFIX."gallery order by sortorder");
        return $this->commonhelpers->dropdown($result->rows,$sel);

    } 

    function order($orderAr){
        foreach($orderAr as $key=>$val) {
            $this->db->query("update
                    ".$this->table." 
                    set sortorder='".($key+1)."' 
                    where gallery_id='".$this->db->escape($val)."'");
        }
    }
    
    function getGallerys() {            
            return $this->gl_helper->getGallerys();            
    }

    function getGallery($gallery_id) {
			if(!(int)$gallery_id)
				return false;
				
	        $result = $this->db->query("SELECT * FROM ".$this->table." where gallery_id='".$this->db->escape($gallery_id)."'");
            return $result->row;                    
    }
        
    function deleteGallery($gallery_id){
            return $this->db->query("delete FROM ".$this->table." where gallery_id='".$this->db->escape($gallery_id)."'");
    }
    
    function saveGallery($fvalue) {            
    
            if($fvalue['sortorder'])$fvalue['sortorder']=0;

            if($fvalue['gallery_id']) {
                $beginString = " update ".$this->table." set ";
                $endString = " where gallery_id='".$this->db->escape($fvalue['gallery_id'])."' ";                
            }else {
                $beginString = "insert into ".$this->table." set";            
            }    
            if($fvalue['image']) $imgCon = ", image='".$this->db->escape($fvalue['image'])."'";
            $result = $this->db->query($beginString."         
                    name='".$fvalue['name']."'
                    $imgCon
                    ,sortorder='".$this->db->escape($fvalue['sortorder'])."
                     '
                    ".$endString
            );
            return $fvalue;
    }
}
