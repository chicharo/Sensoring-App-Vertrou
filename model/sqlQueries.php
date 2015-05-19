<?php
    
/**
*@author Olivier Peurichard & Etienne Marois
*/
    /**
    *Connection to database
    */
include('../model/connectionDB.php');
/**
*this function verify in the database if the login and password are correct
*/
/*
function identification($unername, $password){

    $userN = mysql_real_escape_string($username);
    $pass = mysql_real_escape_string($password);

    $sql = "SELECT username, passwd, id, salt FROM Users WHERE username = '$userN'";
    $req = $bdd->query($sql);
    
    $data = $req->fetch();
	if($userN != null AND $pass != null){
        $hash = sha1($data['salt'].$pass);
	    if(($userN==$data['username'])&&($hash==$data['passwd']))
	    {
	        $_SESSION['id_user']=$data['id']; //generation of sessions variables - id of client
	        $_SESSION['username'] = $data['username']; //generation of sessions variables - login of client
	        //setcookie('id',$data['id']); // genere un cookie contenant l'id du membre
	        //setcookie('login',$data['username']); // genere un cookie contenant le login du membre
        	echo "1"; // on 'retourne' la valeur 1 au javascript si la connexion est bonne
    	}
	    else 
    	{
        	echo "0"; // on 'retourne' la valeur 0 au javascript si la connexion n'est pas bonne
    	}
	}
	else{
    	echo "2";
	}
}*/

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
* $sql contain the query
*/
    $sql = "SELECT DISTINCT content_type FROM BelongsTo, Containers WHERE id_owner= '$id_owner' AND id_container = id";
/**
* $req launch the SQL query
*/
    $req = $bdd->query($sql);
    for($i = 0; $data = $req->fetch(); $i++){
        $container_type[$i] = $data['content_type'];
    }
    return $container_type;
}

    $bdd = null;
?>
