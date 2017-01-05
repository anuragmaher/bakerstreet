<?php

class OrdersController {
     
    function __construct() 
    {
        
    }

    function create()
    {
        return array("new"=> 1);
    }

    function getall()
    {
        $Order = new Order;
        return $Order->selectAll();
    }
 
    function __destruct() 
    {
            //$this->_template->render();
    }
         
}
