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

class ModelSettings extends Model {

    function getSettings() {    
        $result = $this->db->query("SELECT * FROM 
                    ".$this->table." u 
                    ");
        return $result->rows;
    }    
    function saveSettings($fvalue) {
            foreach($fvalue as $key=>$value) {
                $update = " UPDATE ".$this->table." SET value='$value' WHERE `flag`='$key'; ";
                $result = $this->db->query($update);
            }
            $this->writeSettings();

    
    }
    function writeSettings() {
    
        $result = $this->db->query("SELECT * FROM 
                    ".$this->table." u 
                    ");
                    
        $content = "<?php \n ";                    
        foreach($result->rows as $key=>$value) {
$content .= '$settings["'.$value['flag'].'"]  = "'.$value['value'].'";
';
                
        }

        $fp = fopen('../settings.php', 'w');
        fwrite($fp, $content);        
        fclose($fp);
    }
}
