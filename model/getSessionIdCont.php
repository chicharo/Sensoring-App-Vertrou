<?php
/**
*@author Olivier Peurichard & Etienne Marois
*
* Return in a JSON format the id of the current container.
*/
$adoc;

include('connectionDB.php');

//To use the sessions values
session_start();
/**
    *$sql contain the SQL Query
    */
    $sql = "
SELECT DISTINCT id FROM Containers, BelongsTo WHERE id_owner ='".$_SESSION['id_user']."' AND id_container ='".$_SESSION['idContainer']."' AND id = id_container
";
/**
*Launch the SQL query
*/
    $query = $bdd->query($sql);
    
/**
*Store the query in an array and encode her to JSON format
*/
	$data = array();
	$data = $query->fetchAll();

    echo json_encode($data);

$bdd = null;

?>