<?php 
include("password.php");
$host="sqletud.u-pem.fr";
$db="tmario01_db";
$bd = new PDO('mysql:host='.$host.';dbname='.$db, $user, $pass);
?>