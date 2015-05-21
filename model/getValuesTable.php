<?php
/* Database connection start */
/**
*@author Olivier Peurichard & Etienne Marois
*/
    session_start();

    $idCont = intval($_SESSION['idContainer']);
	$idUsr = intval($_SESSION['id_user']);
    /**
    *Connection to database
    */
include('../model/connectionDB.php');



// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;


$columns = array( 
// datatable column index  => database column name
	0 =>'date', 
	1 => 'content_type_container',
	2=> 'value'
);

// getting total number records without any search
$sql = " 
        SELECT value, D.date, content_type_container
        FROM Datas D, BelongsTo B, Containers C
        WHERE D.id_container = '$idCont'
        AND D.id_container = B.id_container
        AND D.id_container = C.id
        AND D.content_type_container = C.content_type
        AND id_owner = '$idUsr'
        ORDER BY D.date
";
$query = $bdd->query($sql) or die("getValuesTable.php: get employees");
$totalData = $query->rowCount();
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.


$sql = " 
        SELECT value, D.date, content_type_container
        FROM Datas D, BelongsTo B, Containers C
        WHERE D.id_container = '".$_SESSION['idContainer']."'
        AND D.id_container = B.id_container
        AND D.id_container = C.id
        AND D.content_type_container = C.content_type
        AND id_owner = '".$_SESSION['id_user']."'
";
if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
	$sql.=" AND ( D.content_type_container LIKE '".$requestData['search']['value']."%' ";    
	$sql.=" OR D.date LIKE '".$requestData['search']['value']."%' ";

	$sql.=" OR value LIKE '".$requestData['search']['value']."%' )";
}
$query = $bdd->query($sql) or die("getValuesTable.php: get employees");

$totalFiltered = $query->rowCount();  // when there is no search parameter then total number rows = total number filtered rows.rows as per search result. 
$sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */	
$query = $bdd->query($sql) or die("getValuesTable.php: get employees");



$data = array();
while( $row=$query->fetch(PDO::FETCH_ASSOC )) {  // preparing an array
	$nestedData=array(); 

	$date = date_create($row["date"]);
	$finalDate = date_format($date,'jS F Y g:ia');
	$nestedData[] = $finalDate;
	$nestedData[] = $row["content_type_container"];	
	$nestedData[] = $row["value"];
	
	$data[] = $nestedData;
}



$json_data = array(
			"draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
			"recordsTotal"    => intval( $totalData ),  // total number of records
			"recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
			"data"            => $data   // total data array
			);

echo json_encode($json_data);  // send data as json format

$bdd = null;

?>
