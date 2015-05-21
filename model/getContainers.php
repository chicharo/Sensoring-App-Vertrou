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

$idUsr = intval($_SESSION['id_user']);
    /**
    *Prepare and launch the SQL query
    */
    //prepare
    $query = $bdd->prepare("
SELECT `id`,`content_type`,`name`,`max_value`,`alert_value` FROM `Containers` WHERE `id` IN ( SELECT `id_container` FROM `BelongsTo` WHERE `id_owner` = :idUsr)
");
    //launch
    $query->execute(array(
        'idUsr'=>$idUsr
    ));   
        
/**
*Store the query in an array and encode her to JSON format
*/
	$data = array();
    $data = $query->fetchAll();

    echo json_encode($data);

$bdd = null;

?>