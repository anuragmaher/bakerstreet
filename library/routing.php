<?php 

$url = $_GET['url'];
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