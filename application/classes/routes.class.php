<?php

namespace App;

class Routes
{
	protected $urlArray;
	/**
	* 
	* get controller 
	* 
	* @param  type  $url
	* @return type
	* @throws 
	* @author name
	*/
	public function getController ($url)
	{
		$urlArray = explode("/", $url);
		// This is for heroku deployment, we are getting first element as null
		if(!$urlArray[0])
		{
			array_shift($urlArray);
		}
		$controller = $urlArray[0];
		$this->urlArray = $urlArray;
		if(!$controller)
		{
			echo " Follow instructions on <a href='https://github.com/anuragmaher/bakerstreet'> https://github.com/anuragmaher/bakerstreet </a>";
			exit();
		}
		return $controller;
	}

	public function getRestQueryString ($method, $param)
	{
		$queryString = "";
		if($method == "GET" && $param)
		{
			$queryString = $param;
		}
		if($method == "PUT" && $param)
		{
			$queryString = $param;
		}
		if($method == "DELETE" && $param)
		{
			$queryString = $param;	
		}
		return $queryString;
	}

	public function getRestAction ($method, $param)
	{
		if($param === 0)
		{
			throw new BadRequestException("Bad Request ");
		}
		$action = "";
		if ($method === 'POST') 
		{
	    	$action = "create";
		}
		else if ($method === 'GET') 
		{
			$action = "all";
		}
		else if($method === "DELETE")
		{
			$action = "delete";
		}
		if($method === 'PUT')
		{
			$action = "edit";
		}
		if($method == "GET" && $param)
		{
			$action = "get";
		}
		if($method == "PUT" && $param)
		{
			$action = "edit";
		}
		return $action;
	}
	
	public function getAction ()
	{
		$action = "";
		if(count($this->urlArray) > 1)
		{
			$action = $this->urlArray[1];
		}
		return $action;
	}

	public function getQueryString ()
	{
		$queryString = "";
		if(count($this->urlArray) > 2)
		{
			$queryString = $this->urlArray[2];
		}
		return $queryString;
	}

}
