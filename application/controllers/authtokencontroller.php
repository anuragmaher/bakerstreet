<?php

/**
* This class handles authentication for a user. 
*/

class AuthTokenController 
{

    function __construct() 
    {

    }

    function create()
    {
        $authClass = new Authentication;
        try{
            $authClass->checkIfPostDataPresent();
            $authClass->checkIfUserExists();
            $userid = $authClass->checkUserAuth();
            $token = $authClass->createNewToken($userid);
            $content = array();
            $content["token"] = $token;
            return array("content"=> $content);
        }
        catch(UserNotFoundException $e)
        {
            header('HTTP/1.0 401' . $e->getMessage());
            return $e->getMessage();
        }
        catch(InsufficientDataException $e)
        {
            header('HTTP/1.0 401' . $e->getMessage());
            return $e->getMessage();
        }
        catch(PasswordNotMatchException $e)
        {
            header('HTTP/1.0 401' . $e->getMessage());
            return $e->getMessage();
        }
        

    }
 
    function __destruct() 
    {
        //$this->_template->render();
    }
         
}
