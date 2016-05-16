<?php

/**
 * fernando234
 * Bootstrap.
 * 
 * @author Fernando Oliveira <rodox17@gmail.com>
 * @version 4.0
 */
error_reporting(0);ini_set('display_errors', 0);
//error_reporting(E_ALL);ini_set('display_errors', 1);

require_once 'application/configs/default.php';

function __autoload($pClassName) {
	
    $pClassName = str_replace('\\', DIRECTORY_SEPARATOR, $pClassName);
    $pClassName = str_replace("_", DIRECTORY_SEPARATOR, $pClassName);
    $pClassName = str_replace("stalker" . DIRECTORY_SEPARATOR, '', $pClassName);

    $file       = __DIR__ . DIRECTORY_SEPARATOR . $pClassName . ".php";

    include_once $file;
        
}

$url_params = stalker\library\Fw\Vital::getUrlParams();

$controller = new $url_params['controller'];

if(method_exists($controller,'init')){
	
    $controller->init();
	
}

$action = $url_params['action'];

$controller->$action();

?>
