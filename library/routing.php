<?php 

$urlArray = explode("?", $_SERVER['REQUEST_URI']);
$url = $urlArray[0];
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
else{
	$action = "";
}
array_shift($urlArray);
$queryString = $urlArray;

if($controller == RESTAPI)
{
	$param = $action;
	if(!array_key_exists('HTTP_AUTHTOKEN', $_SERVER))
	{
		http_response_code(401);
		return "Unauthorized Action";
	}
	$authtoken = $_SERVER['HTTP_AUTHTOKEN'];
	$method = $_SERVER['REQUEST_METHOD'];
	try
	{
		Authentication::validateToken($authtoken);
	}
	catch(UnAuthorizedActionException $e)
	{
		http_response_code(401);
		return "Unauthorized Action";
	}

	if ($method === 'POST') 
	{
    	$action = "create";
	}
	else if ($method === 'GET') 
	{
		$action = "all";
	}
	if($param && $method === 'POST')
	{
		$action = "edit";
		$queryString = $param;
	}
	if($param && $method === 'GET')
	{
		$action = "get";
		$queryString = $param;
	}
}
$controllerName = $controller;
$controller = ucwords($controller);

$controller .= 'Controller';
$dispatch = new $controller();

if ((int)method_exists($controller, $action)) 
{
    echo json_encode(call_user_func_array(array($dispatch,$action), array($queryString)));
    return;
}
else
{    
    /* Error Generation Code Here */
    http_response_code(405);
    return "405";
}
