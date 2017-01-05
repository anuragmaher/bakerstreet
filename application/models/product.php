<?php

class Product extends BaseModel 
{
	protected $_table = "products";

	function __construct() 
    {
    	parent::__construct();
    }

	public function getall ()
	{
		$result = $this->query("select * from " . $this->_table);
		return $result;
	}

	public function createnew ($name, $description, $status)
	{
		$query = "insert into $this->_table(name, description, status, created_at, updated_at) values('$name', '$description', '$status', now(), now());";
		$result = $this->insert($query);
		return $result;
	}

	function __destruct ()
	{
		parent::__destruct();
	}

}
