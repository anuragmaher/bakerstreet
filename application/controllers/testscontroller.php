<?php

use Auth\Authentication as Authentication;

class TestsController {
    protected $userid = null;
    protected $token = null;
    protected $auth = null;

    function __construct()
    {
        $this->auth = new Authentication;
    }

    function authenticateUser($username, $password)
    {
        $this->auth->setUserAndPassword($username, $password);
        $this->auth->checkIfUserExists();
        $userid = $this->auth->checkUserAuth();
        return $userid;
    }

    function userNotFoundException()
    {
        echo "<b>Test 1</b>- <b>username</b>: usernotpresent and <b>password</b>: junk <br/> ";
        try{
            $this->authenticateUser("usernotpresent", "junk");
        }catch(UserNotFoundException $e){
            echo "Test case passed";
            return "<br/>";
        }
        throw new Exception(" TEST CASE FAILED: UserNotFoundException Exception not thrown ");
    }

    function wrongPasswordException()
    {
        echo "<br/><b>Test 2</b>- <b>username</b>: admin and <b>password</b>: junk <br/> ";
        try{
            $this->authenticateUser("admin", "junk");
        }catch(PasswordNotMatchException $e){
            echo "Test case passed";
            return "<br/>";
        }
        throw new Exception(" TEST CASE FAILED: PasswordNotMatchException Exception not thrown ");
    }


    function shouldwork()
    {
        echo "<br/><b>Test 3</b>- <b>username</b>: admin and <b>password</b>: admin <br/> ";
        $userid = $this->authenticateUser("admin", "admin");
        if(!$userid)
        {
            throw new Exception(" Some issue : userid not returned ");
        }
        $this->userid = $userid;
        $token = $this->auth->createNewToken($userid);
        return $token;

    }

    function getProductsWithoutAuthentication ()
    {
        echo "<br/> <b>Test 4 </b>: Get products without authtication GET /products </br>";
        $result = MyCurl::callAPI("GET", BASEURL . "/products");
        if(!strpos($result, "401 Unauthorized"))
        {
            throw new Exception("  Response code 401 not found ");
        }
        echo "Test case passed";
        return "<br/>";
    }

    function getProductsWithAuthenticationHeader ()
    {
        echo "<br/> <b>Test 5 </b>: Get products without authtication GET /products and token</br>";
        $result = MyCurl::callAPI("GET", BASEURL . "/products", "", $this->token);
        if(!strpos($result, "1.1 200 OK"))
        {
            throw new Exception("  Response code 200 not found ");
        }
        echo "Test case passed";
        return "<br/>";
    }

    function auth ()
    {
        echo "<h2> Automated Testing </h2>" . "<br/>";
        $this->userNotFoundException();
        $this->wrongPasswordException();
        $this->token = $this->shouldwork();
        
        echo " <h3>All tests for authtication passed Token: " . $this->token . " </h3>";
        echo " Now all the tests will use this token : " . $this->token . " for authentication </br> ";
        $this->getProductsWithoutAuthentication();
        $this->getProductsWithAuthenticationHeader();
        echo "<br/><br/><b> Authentication complete</b><br/><br/>";
        return "All Tests Passed";
    }
 
    function __destruct () 
    {

    }
         
}
