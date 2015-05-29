<?php
/**
*return in JSON format the geolocalisation of the current container.
*/

function getLoc(){
    include('connectionDB.php');

    session_start();

    $idCont = intval($_SESSION['idContainer']);
    //recuperation of containers
	/**
	*Prepare the SQL query and launch it
	*/
    $query = $bdd->prepare("SELECT DISTINCT `geolat`, `geolong` FROM `Containers` WHERE id = :idCont");

    $query->execute(array(
        'idCont'=>$idCont
    ));
    /**
    *Result of query
    */
    $results=$query->fetchAll(PDO::FETCH_ASSOC);
    /**
    *transform to JSON element
    */
    $json=json_encode($results);

    echo $json;

    $bdd = null;
}

?>