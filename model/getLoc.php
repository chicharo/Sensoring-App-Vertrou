<?php
/**
*@author Olivier Peurichard & Etienne Marois
*
* return in JSON format the geolocalisation of the current container.
*/
$adoc;
include('connectionDB.php');

session_start();
//recuperation of containers
	/**
	*Prepare the SQL query
	*/
    $statement = $bdd->prepare("SELECT DISTINCT `geolat`, `geolong` FROM `Containers` WHERE id = '".$_SESSION['idContainer']."'");
    $statement->execute();
    /**
    *Result of query
    */
    $results=$statement->fetchAll(PDO::FETCH_ASSOC);
    /**
    *transform to JSON element
    */
    $json=json_encode($results);

    echo $json;

$bdd = null;


?>