<?php

if(getenv('CLEARDB_DATABASE_URL'))
{
	define('MYSQL_URI', getenv('CLEARDB_DATABASE_URL'));
	define('BASEURL', 'https://' . $_SERVER['HTTP_HOST']);
}
else
{
	define('MYSQL_URI', 'mysql://root:kri@localhost/heroku?reconnect=true');
	define('BASEURL', 'http://fluidtasks.com');
}

// Here we define what are the controllers for REST API. 
// By doing this all the REST calls will be routed to specific controller actions. 
define("REST_CONTROLLER", "products");

define("USERNAME", "admin");
define("PASSWORD", "admin");
