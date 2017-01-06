<?php

class ProductsController {
     
    function __construct () 
    {
        
    }

    function checkRequiredFields()
    {

    }

    function create ()
    {
        $product = new product();
        $name = $_POST['name'];
        $description = $_POST['description'];
        $status = "active";
        $product->createnew($name, $description, $status);
    }

    public function all ()
    {
        $product = new product();
        if(array_key_exists("name", $_GET))
        {
            $name = $_GET['name'];
            return $product->search($name);
        }
        return $product->getall();
    }

    function get ($id)
    {
        $product = new Product;
        return $product->get($id);
    }
 
    function __destruct () 
    {
            //$this->_template->render();
    }
         
}
