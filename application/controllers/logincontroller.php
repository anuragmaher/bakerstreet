<?php

class LoginController {
     
    protected $_model;
    protected $_controller;
    protected $_action;
 
    function __construct($model, $controller, $action) 
    {
        $this->_controller = $controller;
        $this->_action = $action;
        $this->_model = $model;
        $this->$model = new $model; 
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
