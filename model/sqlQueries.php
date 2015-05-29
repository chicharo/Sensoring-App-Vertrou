<?php
    
/**
*@author Olivier Peurichard & Etienne Marois
*/



//launch the function sent by POST
if (isset($_POST['myFunction']) && $_POST['myFunction'] != ''){
    $_POST['myFunction']();
}

/**
* Return a table which contain the containers' types the current user.
*@param $id id of the owner of containers
*@return a table which contain all the tanks' types
*/
function sqlContainers($id){
    //recuperation of containers
    include('../model/connectionDB.php');

    $id_owner = intval($id);
/**
* $query prepare and launch the SQL query
*/
    $query = $bdd->prepare("SELECT DISTINCT content_type FROM BelongsTo, Containers WHERE id_owner= :id_owner AND id_container = id");

    $query->execute(array(
    'id_owner'=>$id_owner,
    ));
/**
* $req launch the SQL query
*/
    for($i = 0; $data = $query->fetch(); $i++){
        $container_type[$i] = $data['content_type'];
    }
    return $container_type;

    $bdd = null;
}

//------------------------------------

/**
* Return in a JSON format all the values from the current container of the current user.
*/
function getAllValues(){
//connection to database
include('connectionDB.php');

//To use the sessions values 

session_start();
$idCont = intval($_SESSION['idContainer']);
$idUsr = intval($_SESSION['id_user']);
/**
*The SQL query
*/
$query = $bdd->prepare(" 
        SELECT value, D.date, content_type_container, name
        FROM Datas D, BelongsTo B, Containers C
        WHERE D.id_container = :idCont
        AND D.id_container = B.id_container
        AND D.id_container = C.id
        AND D.content_type_container = C.content_type
        AND id_owner = :idUsr
        ORDER BY D.date
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

}

//--------------------------

/**
* Return in a JSON format all the values from the current container of the current user.
*/
function getDetail(){
//connection to database
include('connectionDB.php');

//To use the sessions values

session_start();

$idCont = intval($_SESSION['idContainer']);
$idUsr = intval($_SESSION['id_user']);
/**
*The SQL query
*/
$query = $bdd->prepare(" 
        SELECT DISTINCT details, max_value
        FROM Datas D, BelongsTo B, Containers C
        WHERE D.id_container = :idCont
        AND D.id_container = B.id_container
        AND D.id_container = C.id
        AND D.content_type_container = C.content_type
        AND id_owner = :idUsr
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
}

//---------------------------------------

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

//--------------------------------

/**
* Return in a JSON format the id of the current container.
*/

function getSessionIdCont(){
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
}
//-----------------------------

/**
* Return in a JSON format all the containers from the current user.
*/
function getContainers(){
    //connection to the database
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
}

//----------------------------------

/**
* Return in a JSON format the last values from all the containers of the current user.
*/
function getLastValues(){

    include('connectionDB.php');


    //To use the sessions values 
    session_start();

    $idUsr = intval($_SESSION['id_user']);

    $data = array(); 
    /**
    * contain amd launch the SQL query
    */
    $query = $bdd->prepare("
    SELECT `id_container`,`content_type_container`,`value`,`date`
        FROM `Datas` WHERE `date` IN (SELECT MAX( `date` )
                                    FROM `Datas` WHERE `id_container` 
                                    IN (Select `id_container`FROM `BelongsTo`
                                         where `id_owner` = :idUsr)
                                    GROUP BY `id_container`,`content_type_container`
      )
      ORDER BY `id_container` ASC , `date` DESC
    ");

    $query->execute(array(
        'idUsr'=>$idUsr
    ));

    /**
    *Store the query in an array and encode her to JSON format
    */
    $data = $query->fetchAll();
    echo json_encode($data);
    $bdd = null;
}

//-----------------------------------------------------------

function countAllValues(){
    //connection to database
    include('connectionDB.php');

    //To use the sessions values
    session_start();

    $idCont = intval($_SESSION['idContainer']);
    $idUsr = intval($_SESSION['id_user']);
    /**
    *The SQL query
    */
    $query = $bdd->prepare(' 
        SELECT value
        FROM Datas D, BelongsTo B, Containers C
        WHERE D.id_container = :idCont
        AND D.id_container = B.id_container
        AND D.id_container = C.id
        AND D.content_type_container = C.content_type
        AND id_owner = :idUsr
    ');

    $query->execute(array(
        'idCont'=>$idCont,
        'idUsr'=>$idUsr
    ));

    /**
    *Store the query in an array and encode her to JSON format 
    */
    $data = array(); 
    $k=0;

    while($data = $query->fetch()){
        $k++;
    }

    echo $k;
    
    $bdd = null;
}
?>
