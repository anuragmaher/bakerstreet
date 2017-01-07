<?php

/*
* This class can be used for authentiction. 
* To use this class first set setUserAndPassword and then check for user and password validation.
**/
namespace Auth;

class Authentication
{
    protected $username;
    protected $password;

    /**
    * Setting username and password in local protected variable
    * @param  string  $username
    * @param  string  $password
    * @return none
    * @author anurag
    */
    function setUserAndPassword ($username, $password)
    {
        $this->username = $username;
        $this->password = $password;
    }

    /**
    * Checks username and password to be present in $_POST array
    * @throws InsufficientDataException
    * @author anurag
    */
    function setPostData ($source)
    {
    	if(!array_key_exists("password", $source) || !array_key_exists("username", $source))
        {
        	throw new \InsufficientDataException("username password fields are required");
        }
        $this->setUserAndPassword($source['username'], $source['password']);
    }

    /**
    * Validate token is called when we want to validate if the token is valid
    * @param  string  $token
    * @return none
    * @throws UnAuthorizedActionException
    * @author anurag
    */
    public static function validateToken ($token)
    {
        $authtoken = new AuthToken();
        $result = $authtoken->checkToken($token);
        if(!$result)
        {
            throw new \UnAuthorizedActionException("Invalid Token");
        }
        return true;
    }

    /**
    * Creating new token for user 
    * @param  string  $userid
    * @return string
    * @author anurag
    */
    function createNewToken ($userid)
    {
    	$authtoken = new AuthToken();
    	return $authtoken->createToken($userid);
    }

    /**
    * Checking if a user is present in DB
    * username should be set from before
    * @throws UserNotFoundException
    * @author anurag
    */
    function checkIfUserExists ()
    {
    	$user = new \User;
    	$u = $user->getUserByName($this->username);
    	if(count($u) == 0)
        {
        	throw new \UserNotFoundException("user not found", 1);
        }
    }

    /**
    * Check if username and passwords match from DB
    * username and password should be set from before
    * @throws PasswordNotMatchException
    * @author anurag
    */
    function checkPasswordMatch ()
    {
    	$user = new \User;
    	$result = $user->checkPassword($this->username, $this->password);
    
        if(count($result) > 0)
        {
            $userid = $result[0]['id'];
            return $userid;
        }
        else
        {
        	throw new \PasswordNotMatchException("password do not match", 1);	
        }
    }

    /**
    * Checking authorization, returns userid if everything passes
    * @return userid 
    * @author anurag
    */
    function checkUserAuth ()
    {
        $userid = $this->checkPasswordMatch();
        return $userid;
    }
}
