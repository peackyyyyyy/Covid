<?php 
include("password.php");
$host="localhost";
$db="cov19";
$bd = new PDO('mysql:host='.$host.';dbname='.$db, $user, $pass);
?>