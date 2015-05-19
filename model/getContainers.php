<?php
/**
*@author Olivier Peurichard & Etienne Marois
*
* Return in a JSON format all the containers from the current user.
*/
$adoc;
include('connectionDB.php');


    //To use the sessions values
    session_start();
    /**
    *$sql contain the SQL Query
    */
    $sql = "
SELECT `id`,`content_type`,`name`,`max_value`,`alert_value` FROM `Containers` WHERE `id` IN ( SELECT `id_container` FROM `BelongsTo` WHERE `id_owner` ='".$_SESSION['id_user']."')
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