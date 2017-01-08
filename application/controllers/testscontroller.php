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
            echo print_r($result, true);
            throw new Exception("  Response code 401 not found ");
        }
        echo "Test case passed";
        return "<br/>";
    }

    function getProductsWithWrongAuthenticationHeader ()
    {
        echo "<br/> <b>Test 5 </b>: Get products without authtication GET /products and token</br>";
        $result = MyCurl::callAPI("GET", BASEURL . "/products", "", "thisisnotavalidtoken");
        if(!strpos($result, "401 Unauthorized"))
        {
            throw new Exception("  401 Unauthorized not found ");
        }
        echo "Test case passed";
        return "<br/>";
    }

    function getProductsWithAuthenticationHeader ()
    {
        echo "<br/> <b>Test 6 </b>: Get products without authtication GET /products and token: $this->token </br>";
        $result = MyCurl::callAPI("GET", BASEURL . "/products", "", $this->token);
        if(!strpos($result, "1.1 200 OK"))
        {
            throw new Exception("  Response code 200 not found ");
        }
        echo "Test case passed";
        return "<br/>";
    }

    function createProduct()
    {
        echo "<br/> <br/> <b>Test 7 </b>: POST /products with token and name and description </br>";
        $result = MyCurl::callAPI("POST", BASEURL . "/products", "name=anurag&description=test", $this->token, false);
        $result = json_decode($result);
        if(!$result->product)
        {
            throw new Exception(" product could not be created ");
        }
        $product = $result->product[0]; 
        echo " Product created with id: " . $product->id;
        echo " Test case passed ";
        return $product->id;
    }

    function listsProduct()
    {
        echo "<br/> <br/> <b>Test 8 </b>: GET /products with token </br>";
        $result = MyCurl::callAPI("GET", BASEURL . "/products", "", $this->token);
    }

    function getOneProduct($productid)
    {
        echo "<br/> <br/> <b>Test 8 </b>: GET /products/$productid with token and productid </br>".BASEURL."/products/".$productid;
        $result = MyCurl::callAPI("GET", BASEURL . "/products/$productid", "", $this->token, false);
        $result = json_decode($result);
        if(!$result->product)
        {
            throw new Exception(" product is not returned ");
        }
        $product = $result->product[0]; 
        echo " Product created with id: " . $product->id;
    }

    function updateProduct ($productid)
    {
        echo "<br/><br/> <b>Test 9 </b>: PUT /products/$productid with token and name and description </br>";
        $result = MyCurl::callAPI("PUT", BASEURL . "/products/$productid", "name=newname&description=12", $this->token, false);
        $result = json_decode($result);
        if(!$result->product)
        {
            throw new Exception(" product is not returned ");
        }
        $product = $result->product[0]; 
        if(!$product->name == "newname")
        {
            throw new Exception(" product name change not successfull ");
        }
        echo " Test case passed ";
    }

    function deleteProduct ($productid)
    {
        echo "<br/><br/> <b>Test 10 </b>: DELETE /products/$productid with token </br>";
        $result = MyCurl::callAPI("DELETE", BASEURL . "/products/$productid", "", $this->token, false);
        $result = json_decode($result);
        if(!$result->status == "done")
        {
            throw new Exception(" DELETE not succesfull ");
        }
        echo "Test Case passed";
    }



    function start ()
    {
        echo "<h2> Automated Testing </h2>" . "<br/>";
        $this->userNotFoundException();
        $this->wrongPasswordException();
        $this->token = $this->shouldwork();
        
        echo " <h3>All tests for authtication passed New Token: " . $this->token . " </h3>";
        echo " Now all the tests will use this token : " . $this->token . " for authentication </br> ";
        $this->getProductsWithoutAuthentication();
        $this->getProductsWithWrongAuthenticationHeader();
        $this->getProductsWithAuthenticationHeader();
        echo "<br/> <br/> <br/> <b> Test Cases for Products: </b>";
        /*
        * Have to write these tests- just the basic tests written.
        */
        $productid = $this->createProduct();
        $this->getOneProduct($productid);
        $this->updateProduct($productid);
        $this->deleteProduct($productid);

        echo "<br/><br/><b> Authentication complete</b><br/><br/>";
        return "All Tests Passed";
    }
 
    function __destruct () 
    {

    }
         
}
