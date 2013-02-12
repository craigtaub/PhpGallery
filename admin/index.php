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

// Configuration
require_once('../config.php');
require_once('../settings.php');
require_once('../init.php');

// Startup
require_once(DIR_SYSTEM . 'startup.php');
require_once(DIR_SYSTEM . 'helper/user.php');
// Loader
$loader = new Loader();
Registry::set('load', $loader);

// Config
$config = new Config();
Registry::set('config', $config);

// Database 
$db = new DB(DB_DRIVER, DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
Registry::set('db', $db);

foreach ($settings as $key=>$value) {
    $config->set($key,$value);
}


$log = new Logger($config->get('config_error_filename'));
Registry::set('log', $log);

// Error Handler
function error_handler($errno, $errstr, $errfile, $errline) {
    global $config, $log;
    
    switch ($errno) {      
        case 8:	
            $errors = "";
            break;		
        case E_WARNING:
        case E_USER_WARNING:
            $errors = "Warning";
            break;
        case E_ERROR:
        case E_USER_ERROR:
            $errors = "Fatal Error";
            break;
        default:
            $errors = "Unknown";
            break;
    }
        
    if ($config->get('config_error_display') && $errors) {
        echo '<b>' . $errors . '</b>: ' . $errstr . ' in <b>' . $errfile . '</b> on line <b>' . $errline . '</b>';
    }
    
    if ($config->get('config_error_log') && $errors) {
        $log->write('PHP ' . $errors . ':  ' . $errstr . ' in ' . $errfile . ' on line ' . $errline);
    }

    return true;
}

// set to the user defined error handler
set_error_handler('error_handler');

// Request
$request = new Request();
Registry::set('request', $request);

// Response
$response = new Response();
$response->addHeader('Content-Type', 'text/html; charset=utf-8');
Registry::set('response', $response);

// Cache
Registry::set('cache', new Cache());

// Url
Registry::set('url', new Url());

// Session
$session = new Session();
Registry::set('session', $session);


// User
$user = new HelperUser();
Registry::set('user', $user);

// Front Controller 
$controller = new Front();

// SEO URL's
//$controller->addPreAction(new Router('seo_url'));

// Router
if(!$user->isLogged()) {
   $action = new Router('login');       
}
else if (isset($request->get['c'])) {
    $action = new Router($request->get['c']);
} else {
    $action = new Router('index');
}
// Dispatch
$controller->dispatch($action, new Router('index'));


// Output
$response->output();