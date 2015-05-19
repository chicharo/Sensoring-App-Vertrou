<?php
    
/**
*@author Olivier Peurichard & Etienne Marois
*/
    session_start();
    /**
    *Connection to database
    */
include('../model/connectionDB.php');
    
$userN = htmlspecialchars($_POST['username']);
$pass = htmlspecialchars($_POST['password']);

//$userN = 'Etienne';
//$pass = 'Lol5';

if($userN != null AND $pass != null){

    $sql = "SELECT salt FROM Users WHERE username = '$userN'";
    $reqSalt = $bdd->query($sql);
    $dataSalt = $reqSalt->fetch();

    $hash = sha1($dataSalt['salt'].$pass);

    $sql = "SELECT id, username, password FROM Users WHERE username = '$userN' AND password = '$hash'";
    $req = $bdd->query($sql);
    $data = $req->fetch();

    if(($userN==$data['username'])&&($hash==$data['password'])){

        $_SESSION['id_user']=$data['id']; //generation of sessions variables - id of client
        $_SESSION['username'] = $data['username']; //generation of sessions variables - login of client
        //setcookie('id',$data['id']); // genere un cookie contenant l'id du membre
        //setcookie('login',$data['username']); // genere un cookie contenant le login du membre
        echo "1"; // on 'retourne' la valeur 1 au javascript si la connexion est bonne
    }
    else {
        echo "0"; // on 'retourne' la valeur 0 au javascript si la connexion n'est pas bonne
    }
}
else{
    echo "2";
}
    $bdd = null;
?>
