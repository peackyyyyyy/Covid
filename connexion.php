<!DOCTYPE html>
<html>
<head>
	<title>Boulangerie</title>
	<link rel="stylesheet" type="text/css" href="style.css">
	<link rel="icon" href="img/index.ico">
	
</head>
<body>
<?php 
try{
  include("setting/parametre.inc.php");
}
catch(Exception $e){
die('Connexion impossible à la base de données !'.$e->getMessage());
}
session_start();
//phase de stockage de donnée le login et le mdp
$_SESSION['log'] = $_POST['log'];
$_SESSION['pass'] = $_POST['pass']; 
$password = md5($_SESSION['pass']);
if (isset($_POST["clientsub"])) {
	//Apres identification d'un client
	$req="SELECT Client.idclient, Client.mdp ,Client.verif FROM Client WHERE Client.idclient='".$_SESSION['log']."' AND Client.mdp='".$password."'";
	$result=$bd->query($req);
	while($ligne=$result->fetch()){
	if ($_SESSION["log"]==$ligne[0] && $password==$ligne[1] && $ligne[2]==1) {
	header("location: compte/client.php");
	}
	else{
		echo "verifier votre mail";
	}
	}

}
if (isset($_POST["adminsub"])) {
	//Apres identification d'un boulanger
	$req="SELECT Boulanger.MatBoulanger, Boulanger.mdp FROM Boulanger WHERE Boulanger.MatBoulanger='".$_SESSION['log']."' AND Boulanger.mdp='".$password."'";
	$result=$bd->query($req);
	while($ligne=$result->fetch()){
	if ($_SESSION["log"]==$ligne[0] && $password==$ligne[1]) {
		header("location: compte/boulanger.php");
	}
	else{
		echo "verifier votre mail";
	}
	}

}
		echo "<br>Identifiant ou mot de passe incorrect <br><br>";
		echo "<a href='index.php'><button>Accueil</button></a>";
?>
</body>
</html>