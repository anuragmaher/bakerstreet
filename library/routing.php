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
if(count($urlArray))
{
	$action = $urlArray[0];
}
array_shift($urlArray);
$queryString = $urlArray;

if($controller == RESTAPI)
{
	if(!array_key_exists('HTTP_AUTHTOKEN', $_SERVER))
	{
		header('HTTP/1.0 401 Unauthorized Action');
		return "Unauthorized Action";
	}
	$authtoken = $_SERVER['HTTP_AUTHTOKEN'];
	$auth = new Authentication;
	try
	{
		$auth->validateToken($authtoken);
	}catch(UnAuthorizedActionException $e)
	{
		header('HTTP/1.0 401 '. $e->getMessage());
		return "Unauthorized Action";
	}

	if ($_SERVER['REQUEST_METHOD'] === 'POST') 
	{
    	$action = "create";
	}
	else if ($_SERVER['REQUEST_METHOD'] === 'GET') 
	{
		$action = "all";
	}
}
$controllerName = $controller;
$controller = ucwords($controller);

$controller .= 'Controller';
$dispatch = new $controller();

if ((int)method_exists($controller, $action)) 
{
    echo json_encode(call_user_func_array(array($dispatch,$action),$queryString));
    return;
}
else
{    
    /* Error Generation Code Here */
    header('HTTP/1.0 405 Method Not Allowed ');
    return "405";
}
