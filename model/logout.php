<?php
/**
*@author Olivier Peurichard & Etienne Marois
*
* Disconnect the user and redirects to the home page.
*/
$adoc;
session_start();

 
/**
*Delete the session variable
*/
$_SESSION = array();

setcookie('id', NULL, -1);
setcookie('login', NULL, -1);

// Détruisez la session 
/**
* Delete the session
*/
session_destroy();
?>
<head>

        <title>Return to index</title>

        <meta http-equiv="refresh" content="0; URL=../vue/index.html">
</head>
<?php
exit;
?>