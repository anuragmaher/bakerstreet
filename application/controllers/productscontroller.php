<?php

class ProductsController {
     
    function __construct() 
    {
        
    }

    function create()
    {
        
    }

    function getall()
    {
        $product = new Product;
        return $product->getall();
    }
 
    function __destruct() 
    {
            //$this->_template->render();
    }
         
}
