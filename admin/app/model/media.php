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

class ModelMedia extends Model {

    function __construct() {
        $this->load->helper('media');
        $this->p_helper = new HelperMedia();	
    }
    
    function getPictures($album_id,$offset,$per_page,$gallery_id) {
        return $this->p_helper->getPictures($album_id,$offset,$per_page,$gallery_id);
    }
    
    function order($orderAr){
        $record_start = $this->request->post['record_start'];
        foreach($orderAr as $key=>$val) {
            $this->db->query("update
                    ".$this->table." 
                    set sortorder='".($record_start+$key+1)."' 
                    where picture_id='".$val."'");
        }
    }

    function getPicture($picture_id) {            
        $result = $this->db->query("SELECT * FROM ".$this->table." where id='".$picture_id."'");
        return $result->row;                    
    }
    
    function deletePicture($picture_id) {
            
        $result = $this->db->query("SELECT * FROM ".$this->table." where id='".$picture_id."'");
        removeimage($result->row['image']);
        return $this->db->query("delete FROM ".$this->table." where id='".$picture_id."'");    
    }
    
    function totalPictures() {
        return $this->p_helper->totalPictures();
    }
    
    function savePicture($fvalue) {            

        if($fvalue['picture_id']) {
            $beginString = " update ".$this->table." set ";
            $endString = " where id='".$fvalue['picture_id']."' ";
        }else {
            $beginString = "insert into ".$this->table." set";
            $endString = " ,date_added=NOW()";
        }
        
        if($fvalue['image']) $imgCon = ", image='".$fvalue['image']."'";

        $result = $this->db->query($beginString." 
                title='".$fvalue['title']."'
                $imgCon "
                .$endString
        );    

        return $fvalue;
        
    }
}
