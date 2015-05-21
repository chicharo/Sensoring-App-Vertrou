<?php
/**
*@author Olivier Peurichard & Etienne Marois
*
* Return in a JSON format the last values from all the containers of the current user.
*/
$adoc;
include('connectionDB.php');


//To use the sessions values 
session_start();

$idUsr = intval($_SESSION['id_user']);

$data = array(); 
/**
* $sql contain the query
*/
$sql = "
SELECT `id_container`,`content_type_container`,`value`,`date`
  FROM `Datas` WHERE `date` IN (SELECT MAX( `date` )
                                FROM `Datas` WHERE `id_container` 
                                IN (Select `id_container`FROM `BelongsTo`
                                     where `id_owner` = '$idUsr')
                                GROUP BY `id_container`,`content_type_container`
  )
  ORDER BY `id_container` ASC , `date` DESC
";

/**
*Launch the query
*/
$query = $bdd->query($sql);

/**
*Store the query in an array and encode her to JSON format
*/
$data = $query->fetchAll();
    echo json_encode($data);
$bdd = null;


?>