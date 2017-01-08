<?php
 
class SQLBase 
{
    protected $_conn;
    protected $_table;
    protected $host;
    protected $username;
    protected $password;
    protected $db;

    /** Connects to database **/
    function setVars($mysqlurl)
    {
        $mysqlurl = str_replace("mysql://", "", $mysqlurl);
        $mysqlurl = str_replace("?reconnect=true", "", $mysqlurl);
        $urlarray = explode("/", $mysqlurl);
        $this->db = $urlarray[1];
        $urlarray = explode("@", $urlarray[0]);
        $this->host = $urlarray[1];
        $urlarray = explode(":", $urlarray[0]);
        $this->username = $urlarray[0];
        $this->password = $urlarray[1];
    }
 
    function connect($mysqlurl) 
    {
        $this->setVars($mysqlurl);
        $this->_conn = new mysqli($this->host, $this->username, $this->password, $this->db);
        /* check connection */
        if ($this->_conn->connect_errno) 
        {
            die("Connect failed: " . $server);
        }
    }

    function escape_string ($input)
    {
        return $this->_conn->escape_string($input);
    }
 
    /** Disconnects from database **/
 
    function disconnect() 
    {
        $this->_conn->close();
        return 1;
    }
     
    function selectAll() 
    {
        $query = 'select * from `'.$this->_table.'`';
        return $this->query($query);
    }
     
    function select($id) 
    {
        $query = 'select * from '.$this->_table.' where id = $id';
        return $this->query($query);    
    }
 
    /** Custom SQL Query **/
    function query($query) 
    {
        $result = $this->_conn->query($query);
        $user_arr = array();
        if(!$result)
        {
            return false;
        }
        while ($row = $result->fetch_assoc()){
            $user_arr[] = $row;
        }
        if($this->_conn->error)
        {
            throw new Exception($this->_conn->error);
        }
        return $user_arr;
    }

    function insert($query)
    {
        $result = $this->_conn->query($query);
        if($this->_conn->error)
        {
            throw new Exception($this->_conn->error);
        }
        return $result;
    }

    function update($query)
    {
        $result = $this->_conn->query($query);
        if($this->_conn->error)
        {
            throw new Exception($this->_conn->error);
        }
        return $result;
    }

    function delete ($query)
    {
        $result = $this->_conn->query($query);
        if($this->_conn->error)
        {
            throw new Exception($this->_conn->error);
        }
        return $result;
    }

}
