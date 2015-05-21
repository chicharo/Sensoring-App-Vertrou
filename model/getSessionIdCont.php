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

$idCont = intval($_SESSION['idContainer']);
$idUsr = intval($_SESSION['id_user']);
/**
    *$sql contain the SQL Query
    */
    $query = $bdd->prepare("
SELECT DISTINCT id FROM Containers, BelongsTo WHERE id_owner = :idUsr AND id_container = :idCont AND id = id_container
");

    $query->execute(array(
	'idCont'=>$idCont,
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