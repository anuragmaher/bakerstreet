<?php
class Encryption 
{
    function __construct () 
    {
    }

    public static function encrypt ($input)
    {
        return hash('sha256', $input);
    }

    function __destruct () 
    {
        
    }
}
