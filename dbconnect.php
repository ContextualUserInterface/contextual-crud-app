<?php
function db_connect() 
{
    // Define connection as a static variable, to avoid connecting more than once 
    static $con;

    // Try and connect to the database, if a connection has not been established yet
    if(!isset($con)) 
    {
        $con = new mysqli(REDACTED_SERVER, REDACTED_USER, REDACTED_PASS, REDACTED_DB_NAME);
    }

    // If connection was not successful, handle the error
    if($con === false) 
    {
        // Handle error - notify administrator, log to a file, show an error screen, etc.
        return mysqli_connect_error(); 
    }
    
    return $con;
}

?> 
