<?php
/**
*@author Olivier Peurichard & Etienne Marois
*
* Return in a JSON format all the values from the current container of the current user.
*/
$adoc;

//connection to database
include('connectionDB.php');

//To use the sessions values 

session_start();
$idCont = intval($_SESSION['idContainer']);
$idUsr = intval($_SESSION['id_user']);
/**
*The SQL query
*/
$sql = " 
        SELECT value,D.date, content_type_container
        FROM Datas D, BelongsTo B, Containers C
        WHERE D.id_container = '$idCont'
        AND D.id_container = B.id_container
        AND D.id_container = C.id
        AND D.content_type_container = C.content_type
        AND id_owner = '$idUsr'
        ORDER BY D.date
";

$query = $bdd->query($sql);
/**
*Store the query in an array and encode her to JSON format 
*/
$data = array(); 

while( $row=$query->fetch(PDO::FETCH_ASSOC )) {
	array_push($data,$row['value']);
	}


    echo json_encode($data,JSON_NUMERIC_CHECK);
    
$bdd = null;


?>