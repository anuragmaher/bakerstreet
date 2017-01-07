<?php

class User extends BaseModel 
{
	protected $_table = "users";

	function __construct() 
    {
    	parent::__construct();
    }

	public function getUserByName ($username)
	{
		$result = $this->query("select * from " . $this->_table . 
								" where username = '$username'");
		return $result;
	}

	public function checkPassword ($username, $password)
	{
		$password = Encryption::encrypt($password);
		$result = $this->query("select * from " . $this->_table . 
								" where username = '$username' and password = '$password'");
		return $result;
	}

	function __destruct ()
	{
		parent::__destruct();
	}

}
