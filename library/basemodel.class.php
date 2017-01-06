<?php
class BaseModel extends SQLBase 
{
    protected $_model;
 
    function __construct () 
    {
        $this->connect(MYSQL_URI);
        $this->_model = get_class($this);
        $this->_table = strtolower($this->_model)."s";
    }
 
    function __destruct () 
    {
        
    }
}
