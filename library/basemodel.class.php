<?php
class BaseModel extends SQLBase 
{
    protected $_model;
 
    function __construct () 
    {
        $this->connect(MYSQL_URI);
        $this->_model = get_class($this);
        $parts = explode('\\', $this->_model);
        $className = end($parts);
        $this->_table = strtolower($className)."s";
    }
 
    function __destruct () 
    {
        
    }
}
