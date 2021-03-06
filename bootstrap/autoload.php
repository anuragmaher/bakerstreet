<?php
define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(dirname(__FILE__)));

/** Autoload any classes that are required **/
 
function __autoload($className)
{

    $parts = explode('\\', $className);
    $className = end($parts);

    if (file_exists(ROOT . DS . 'application' . DS . 'classes' . DS . strtolower($className) . '.class.php')) 
    {
        require_once(ROOT . DS . 'application' . DS . 'classes' . DS . strtolower($className) . '.class.php');
    }
    else if (file_exists(ROOT . DS . 'application' . DS . 'exceptions' . DS . strtolower($className) . '.class.php')) 
    {
        require_once(ROOT . DS . 'application' . DS . 'exceptions' . DS . strtolower($className) . '.class.php');
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