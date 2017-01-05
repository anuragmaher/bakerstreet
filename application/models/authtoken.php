<?php

class AuthToken extends BaseModel 
{
	protected $_table = "authtokens";

	function __construct() 
    {
    	parent::__construct();
    }

	public function getTokenForUser ($userid)
	{
		$result = $this->query("select * from " . $this->_table . 
								" where userid = '$userid'");
		return $result;
	}

	public function checkToken ($token)
	{
		$encryptedtoken = hash('sha256', $token);
		$result = $this->query("select * from $this->_table where token = '$encryptedtoken'");
		return $result;
	}

	public function createToken ($userid)
	{
		$dbtoken = $this->getTokenForUser($userid);
		$token = uniqid();
		/* Encoding token */
    	$encryptedtoken = hash('sha256', $token);
		if(!count($dbtoken))
		{
			// Have to create a token here 
			$this->insert("insert into $this->_table(userid, token, created_at, updated_at) values($userid, '$encryptedtoken', now(), now());");
		}
		else
		{
			//echo $encryptedtoken;
			$query = "update $this->_table set token = '$encryptedtoken', updated_at = now() where userid = $userid";
			$this->insert($query);
		}
		return $token;
	}

	function __destruct ()
	{
		parent::__destruct();
	}

}
