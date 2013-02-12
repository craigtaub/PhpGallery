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

class ModelPictures extends Model {
	
    function __construct() {
        $this->load->helper('pictures');
        $this->helper = new HelperPictures();
    }
    
    function picturesDetails($album_id,$start,$limit) {
        $details = $this->getPictures($album_id,$start,$limit);
        $return = array();
        foreach($details as $key=>$value) {
            $return[$key] = $value;    
            if(!$value['image']) {
                $value['image'] = 'noimage.jpg';
            }
            $return[$key]['image'] = HTTP_THUMB.'/'.$value['image'];
            $return[$key]['link'] = $this->seourl->rewrite('index.php?c=pictures_single&picture_id='.$value['picture_id'].'&title='.$value['title']);            
        }
        return $return;
    }

    function getPictures($album_id,$start,$limit) {
        return $this->helper->getPictures($album_id,$start,$limit);
    }

    function getPicture($picture_id) {
    
        if(!(int)$picture_id)die('foo');
        
        $result = $this->db->query("SELECT *
                                FROM  ".DB_PREFIX."pictures pic
                                where
                                pic.picture_id='".$this->db->escape($this->picture_id)."'
                                ");
        $return = $result->row;
        
        if(!$return['image']) {
            $return['image'] = 'noimage.jpg';
        }

        $return['image_large'] = HTTP_LARGE.'/'.$return['image'];
        $return['image'] = HTTP_IMAGE.'/'.$return['image'];

        return $return;
    }

    function getPictureList($album_id) {
                
        $result = $this->db->query("SELECT picture_id,title
                                    FROM 
                                    ".DB_PREFIX."pictures pic 
                                    WHERE
                                    pic.album_id='".$this->db->escape($album_id)."'
                                    ORDER BY pic.sortorder");    
        $picture_list = array();
        foreach($result->rows as $value) {
            $picture_list[] = $value['picture_id'];
            $picture_title[] = $value['title'];
        }

        $this->picture_title = $picture_title;
        return $this->picture_list = $picture_list;
    }
    
    function totalPictures($album_id) {
        return $this->helper->totalPictures($album_id);
    }

    function albumNavLink($album_id) {
        $result = $this->db->query("SELECT 
                                        al.album_id,
                                        gl.gallery_id,
                                        al.title as album,
                                        gl.name as gallery
                                        FROM 
                                        ".DB_PREFIX."albums al 
                                        JOIN ".DB_PREFIX."gallery gl ON (al.gallery_id=gl.gallery_id)
                                        WHERE
                                        al.album_id='".$this->db->escape($album_id)."' 
                                        limit 1");
        $result_row = $result->row;    
        $return = array();
        $return[1]['link']=$this->seourl->rewrite('index.php?c=albums&gallery_id='.$result_row['gallery_id'].'&title='.$result_row['gallery']);
        $return[1]['title']=$result_row['gallery'];
        $return[2]['title']=$result_row['album'];

        return $return;
    }
    
    function pictureNavLink($picture_id) {
        $result = $this->db->query("SELECT 
                                        pic.picture_id,
                                        al.album_id,
                                        gl.gallery_id,
                                        pic.title as picture,
                                        al.title as album,
                                        gl.name as gallery
                                        FROM 
                                        ".DB_PREFIX."pictures pic 
                                        JOIN ".DB_PREFIX."albums al ON (al.album_id=pic.album_id)
                                        JOIN ".DB_PREFIX."gallery gl ON (al.gallery_id=gl.gallery_id)
                                        WHERE
                                        pic.picture_id='".$this->db->escape($picture_id)."' 
                                        limit 1");                
            
        $result_row = $result->row;    
        $return = array();
        $return[1]['link']=$this->seourl->rewrite('index.php?c=albums&gallery_id='.$result_row['gallery_id'].'&title='.$result_row['gallery']);
        $return[1]['title']=$result_row['gallery'];
        $return[2]['link'] = $this->seourl->rewrite('index.php?c=pictures&album_id='.$result_row['album_id'].'&title='.$result_row['album']);
        $return[2]['title']=$result_row['album'];
        $return[3]['title']=$result_row['picture'];
        
        return $return;
    }
    
    function getNextPicture() {
        $this_picture = array_search($this->picture_id, $this->picture_list);
        if ($this_picture < sizeof($this->picture_list)-1) {
            return $this->data['next'] = $this->seourl->rewrite('index.php?c=pictures_single&picture_id='.$this->picture_list[$this_picture+1].'&title='.$this->picture_title[$this_picture+1]);
        }
        return ;
    }
    
    function getPrevPicture() {
        $image_list = $this->picture_list;
        $this_picture = array_search($this->picture_id, $this->picture_list);
        if ($this_picture > 0) {
            return $this->data['prev'] = $this->seourl->rewrite('index.php?c=pictures_single&picture_id='.$this->picture_list[$this_picture-1].'&title='.$this->picture_title[$this_picture-1]);
        }
        return ;
    }
}