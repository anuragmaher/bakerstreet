<?php 

use App\Routes as Routes;

// Request URI is the url without get params 
$request_uri = $_SERVER['REQUEST_URI'];
$urlArray = explode("?", $request_uri);
$url = $urlArray[0];

$routes = new Routes();
$controller = $routes->getController($url);
$action = $routes->getAction($url);
$queryString = $routes->getQueryString();

$jsonResponse = false;

if($controller == REST_CONTROLLER)
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
		Auth\Authentication::validateToken($authtoken);
	}
	catch(UnAuthorizedActionException $e)
	{
		http_response_code(401);
		return "Unauthorized Action";
	}
	$action = $routes->getRestAction($method);
	
	if($method == "GET" && $param)
	{
		$action = "get";
		$queryString = $param;
	}
	if($method == "PUT" && $param)
	{
		$action = "edit";
		$queryString = $param;
	}
	if($method == "DELETE" && $param)
	{
		$queryString = $param;	
	}
	$jsonResponse = true;
}
$controller = ucwords($controller);

$controller .= 'Controller';
$dispatch = new $controller();

try{
	if ((int)method_exists($controller, $action)) 
	{
		if($jsonResponse)
		{
			header('Content-Type: application/json');
		}
	    echo json_encode(call_user_func_array(array($dispatch,$action), array($queryString)));
	    return;
	}
	else
	{
	    /* Error Generation Code Here */
	    http_response_code(405);
	    return "405";
	}

}catch(ResourceNotFoundException $e){
	echo json_encode(array("status" => "not found" ));
}
catch(InsufficientDataException $e)
{
	echo json_encode(array("status" => "InsufficientData: " . $e->getMessage() ));
}
