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

function image_resize($filename, $width, $height,$folder='thumb') {

    if (!file_exists(DIR_IMAGE."/".$filename)) {
        return;
    } 

    $old_image = $filename;
    $pathinfo = pathinfo($filename);
    $new_image = $folder.'/' . substr($filename, 0, strrpos($filename, '.')) . '.'.$pathinfo['extension'];

    if (!file_exists(DIR_IMAGE."/".$new_image) || (filemtime(DIR_IMAGE."/".$old_image) > filemtime(DIR_IMAGE."/".$new_image))) {
        $tn_image = new Image(DIR_IMAGE."/".$old_image);
        $tn_image->resize($width, $height);
        $tn_image->save(DIR_IMAGE."/".$new_image);
    }
    return HTTP_IMAGE."/".$new_image;
}

function removeimage($filename) {
    @unlink(DIR_IMAGE."/".$filename);
    @unlink(DIR_IMAGE. '/thumb/' . $filename);
    @unlink(DIR_IMAGE. '/large/' . $filename);
}

function saveimage($image) {
    if (is_uploaded_file($image['tmp_name']) && is_writable(DIR_IMAGE)) {
        $inc=1;
		
        $filename = str_replace(" ","_",$image['name']);
        while(file_exists(DIR_IMAGE."/".$filename)) {
            $filename = $inc."_".str_replace(" ","_",$image['name']);
            $inc++;
        }    
				
        move_uploaded_file($image['tmp_name'], DIR_IMAGE."/".$filename);
        
        if (file_exists(DIR_IMAGE."/".$filename)) {
            return $filename;
        }
    }
}

?>
