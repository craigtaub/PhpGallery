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

final class HelperMedia {

	private $db;
	
  	function __construct() {
		$this->db = Registry::get('db');
  	}
    
	final function query_picture($from,$start=0,$limit=12) {

        $where = array(); 
        /* implode the where condition with AND keyword and add WHERE condition before*/
        if($where_cond = implode(" AND ",$where))
		    $where_cond = " WHERE ".$where_cond;

        $limitString = '';

        if($limit)
            $limitString = "LIMIT $start,$limit";		
		
		$result = $this->db->query("SELECT $from
                       FROM 
                       ".DB_PREFIX."media pic 
                       $pictureCon
                       $where_cond
                       $limitString
                       ");
        return $result;
	
    }
    function getPictures($start=0,$limit=12) {                
        $result = $this->query_picture(' pic.*, title'
                                    ,$start
                                    ,$limit
                                    );
        return $result->rows;
    }
    
    function totalPictures() {
        $result = $this->query_picture(' count(pic.id) as total ');
        return $result->row['total'];
    }    
}
