<?php

class Authentication
{
	function __construct() 
    {
    	$this->username = null;
    	$this->password = null;
    }

    function checkPostData ()
    {
    	if(!array_key_exists("password", $_POST) || !array_key_exists("username", $_POST))
        {
        	throw new InsufficientDataException("username password fields are required");
        }
    	$this->username = $_POST['username'];
    	$this->password = $_POST['password'];
    }

    function validateToken ($token)
    {
        $authtoken = new AuthToken();
        $result = $authtoken->checkToken($token);
        if(!count($result))
        {
            throw new UnAuthorizedActionException("Invalid Token");
        }
    }

    function createNewToken ($userid)
    {
    	$authtoken = new AuthToken();
    	return $authtoken->createToken($userid);
    }

    function checkIfUserExists ()
    {
    	$user = new User;
    	$u = $user->getUserByName($this->username);
    	if(count($u) == 0)
        {
        	throw new UserNotFoundException("user not found", 1);
        }
    }

    function checkPasswordMatch ()
    {
    	$user = new User;
    	$result = $user->checkPassword($this->username, $this->password);
    
        if(count($result) > 0)
        {
            $userid = $result[0]['id'];
            return $userid;
        }
        else
        {
        	throw new PasswordNotMatchException("password do not match", 1);	
        }
    }

    function checkUserAuth ()
    {
    	$this->checkPostData();
        $this->checkIfUserExists();
        $userid = $this->checkPasswordMatch();
        return $userid;
    }

}
