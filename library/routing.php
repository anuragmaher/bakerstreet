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
	try
	{
		// Since this is a REST request, second parameter will not be action. It will be parameter to the controller.
		$param = $action;
		if(!array_key_exists('HTTP_AUTHTOKEN', $_SERVER))
		{
			throw new UnAuthorizedActionException("Unauthorized Action");
		}
		$authtoken = $_SERVER['HTTP_AUTHTOKEN'];
		$method = $_SERVER['REQUEST_METHOD'];

		Auth\Authentication::validateToken($authtoken);

		$action = $routes->getRestAction($method, $param);
		$queryString = $routes->getRestQueryString($method, $param);
		
		if($queryString)
		{
			// This query string should be int values , if not integer throw exception
			if(!intval($queryString))
			{
				throw new BadRequestException("Bad Request ");
			}
		}
		$jsonResponse = true;
	}
	catch(UnAuthorizedActionException $e)
	{
		http_response_code(401);
		return "Unauthorized Action";
	}
	catch(BadRequestException $e)
	{
		http_response_code(400);
		return "Bad Request";
	}
}
if($controller == REST_CONTROLLER)
{

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
