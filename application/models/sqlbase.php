<?php
 
class SQLBase {
    protected $_dbHandle;
    protected $_result;
    protected $_conn;
 
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
        while ($row = $result->fetch_assoc()){
            $user_arr[] = $row;
        }
        return $user_arr;
    }
 
    /** Get number of rows **/
    function getNumRows ()
    {
        return mysql_num_rows($this->_result);
    }
 
    /** Free resources allocated by a query **/
 
    function freeResult ()
    {
        mysql_free_result($this->_result);
    }
 
    /** Get error string **/
 
    function getError ()
    {
        return mysql_error($this->_dbHandle);
    }

}
