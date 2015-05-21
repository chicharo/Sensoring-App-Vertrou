<?php
/**
*@author Olivier Peurichard & Etienne Marois
*
*This file contain the connection to the database with PDO
*/
$adoc;

try{
    // Connection to database
    /**
    * $bdd contain the PDO object which connect to the database
    */
    //$bdd = new PDO('mysql:host=localhost;dbname=sensoringDB;charset=utf8', 'root', '');
    $bdd = new PDO('mysql:host=192.168.1.69;dbname=sensoringDB;charset=utf8', 'user', 'darzak');
}
catch(Exception $e){
    // If there is an error, we stop all
        die('Error : '.$e->getMessage());
}

?>