<?php

class ProductsController {
     
    function __construct () 
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
        $product = new Product;
        return $product->getall();
    }

    function get ()
    {
        $product = new Product;
        return $product->getall();
    }
 
    function __destruct () 
    {
            //$this->_template->render();
    }
         
}
