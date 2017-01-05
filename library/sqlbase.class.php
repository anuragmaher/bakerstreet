<?php
 
class SQLBase 
{
    protected $_conn;
    protected $_table;
 
    /** Connects to database **/
 
    function connect($server, $username, $password, $db) 
    {
        $this->_conn = new mysqli($server, $username, $password, $db);
        /* check connection */
        if ($this->_conn->connect_errno) 
        {
            die("Connect failed: " . $server);
        }
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
        $query = 'select * from `'.$this->_table.'` where `id` = \''.mysql_real_escape_string($id).'\'';
        return $this->query($query, 1);    
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
        return $user_arr;
    }

    function insert($query)
    {
        $result = $this->_conn->query($query);
        return $result;
    }

    function update($query)
    {
        $result = $this->_conn->query($query);
        return $result;
    }

}
