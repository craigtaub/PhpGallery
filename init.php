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
 
ini_set("memory_limit",$settings['config_memory_limit'].'M');

/* Root Directory */
$root_dir = '/var/www/projects/ginasgallery/';
//dirname(__FILE__);

define('ROOT_DIR', $root_dir);

//define('APP_DIR', $settings['config_site_host']);
define('HTTP_HOST', $settings['config_site_url']);

//getting current directory path
$exploded_path = explode('/', dirname($_SERVER['PHP_SELF']));
$current_dir = count($exploded_path)>1?end($exploded_path):'';
define('CURRENT_DIR', "/".$current_dir);


/* define http url */
$http_server = !defined('APP_MAIN') ? HTTP_HOST.CURRENT_DIR : HTTP_HOST;
define('HTTP_SERVER', $http_server);

/* Current Application Directory */
$dir_app = !defined('APP_MAIN') ? ROOT_DIR.CURRENT_DIR : ROOT_DIR;
define('DIR_APPLICATION', $dir_app."/");

/* System Direcoty */
define('DIR_SYSTEM', ROOT_DIR.'/system/');

/*
	Upload Directory
*/
$upload_dir = 'pictures';
define('HTTP_IMAGE', HTTP_HOST.'/'.$upload_dir);
define('HTTP_THUMB', HTTP_HOST.'/'.$upload_dir.'/thumb');
define('HTTP_LARGE', HTTP_HOST.'/'.$upload_dir.'/large');

/* Image Directory Path */
define('DIR_IMAGE', ROOT_DIR."/".$upload_dir);
