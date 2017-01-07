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

	public function get ($id)
	{
		$result = $this->query("select * from " . $this->_table . " where id = $id");
		return $result;
	}

	public function search ($name)
	{
		$result = $this->query("select * from " . $this->_table . " where name like '%$name%'");
		return $result;
	}

	public function edit ($productid, $name, $description, $status)
	{
		$query = "update $this->_table set name ='$name', description='$description', status = '$status' where id = $productid";
		$result = $this->update($query);
	}

	public function deleteproduct ($productid)
	{
		$query = "delete from $this->_table where id = $productid";
		$result = $this->delete($query);
	}

	public function createnew ($name, $description, $status)
	{
		$name = $this->escape_string($name);
		$description = $this->escape_string($description);
		$status = $this->escape_string($status);
		$query = "insert into $this->_table(name, description, status, created_at, updated_at) values('$name', '$description', '$status', now(), now());";
		$result = $this->insert($query);
		$query = "SELECT LAST_INSERT_ID() as id";
		$result = $this->query($query);
		$id = "";
		if(count($result))
		{
			$id = $result[0]["id"];
		}
		return $id;
	}

	function __destruct ()
	{
		parent::__destruct();
	}

}
