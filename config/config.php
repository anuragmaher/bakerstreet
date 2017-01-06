<?php

if(getenv('ENV') == "HEROKU")
{
	define('DB_HOST', "us-cdbr-iron-east-04.cleardb.net");
	define('DB_USER', "b375ff3cef8561");
	define('DB_PASSWORD', "2f7baec4");
	define('DB_NAME', "heroku_085941f3160cfba");
}
else
{
	define('DB_HOST', "localhost");
	define('DB_USER', "root");
	define('DB_PASSWORD', "kri");
	define('DB_NAME', "heroku");
}

define("RESTAPI", "products");
