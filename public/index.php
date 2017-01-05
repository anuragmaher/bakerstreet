<?php

require_once("../config/config.php");
require_once("../library/bootstrap.php");

$url = $_GET['url'];

function unregisterGlobals() 
{
    if (ini_get('register_globals')) 
    {
        $array = array('_SESSION', '_POST', '_GET', '_COOKIE', '_REQUEST', '_SERVER', '_ENV', '_FILES');
        foreach ($array as $value) {
            foreach ($GLOBALS[$value] as $key => $var) {
                if ($var === $GLOBALS[$key]) {
                    unset($GLOBALS[$key]);
                }
            }
        }
    }
}

function main()
{
	global $url;
 	$urlArray = array();
    $urlArray = explode("/",$url);
    if(!$urlArray[0])
    {
    	array_shift($urlArray);
    }
    $controller = $urlArray[0];
    array_shift($urlArray);

    $action = $urlArray[0];
    array_shift($urlArray);
    $queryString = $urlArray;
 
    $controllerName = $controller;
    $controller = ucwords($controller);
    $controller .= 'Controller';
    $dispatch = new $controller();

    if ((int)method_exists($controller, $action)) 
    {
        echo json_encode(call_user_func_array(array($dispatch,$action),$queryString));
    } 
    else 
    {    
        /* Error Generation Code Here */
        header('HTTP/1.0 404 not found');
        return "404";
    }
}

/** Autoload any classes that are required **/
 
function __autoload($className)
{
    if (file_exists(ROOT . DS . 'library' . DS . 'exceptions' . DS . strtolower($className) . '.class.php')) 
    {
        require_once(ROOT . DS . 'library' . DS . 'exceptions' . DS . strtolower($className) . '.class.php');
    }
    else if (file_exists(ROOT . DS . 'library' . DS . strtolower($className) . '.class.php')) 
    {
        require_once(ROOT . DS . 'library' . DS . strtolower($className) . '.class.php');
    } 
    else if (file_exists(ROOT . DS . 'application' . DS . 'controllers' . DS . strtolower($className) . '.php')) 
    {
        require_once(ROOT . DS . 'application' . DS . 'controllers' . DS . strtolower($className) . '.php');
    } 
    else if (file_exists(ROOT . DS . 'application' . DS . 'models' . DS . strtolower($className) . '.php')) 
    {
        require_once(ROOT . DS . 'application' . DS . 'models' . DS . strtolower($className) . '.php');
    } 
    else 
    {
        die("Class not found " . $className);
    }
}

unregisterGlobals();
main();
