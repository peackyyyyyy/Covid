<!DOCTYPE html>
<html>
<head>
        <title>COV19</title> 
        <meta http-equiv="content.type" content="text/html"; charset="UTF-8">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link rel="stylesheet" href="css/style.css">
        
        <link rel="icon" href="img/COVID19.ico">
    </head>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="#">COV19</a>
            <img src="img/COVID19.png" alt="" width="30" height="24" class="d-inline-block align-text-top">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
              <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                  <a class="nav-link active" aria-current="page" href="index.php">Accueil</a>
                </li>
              <li class="nav-item">
                <a class="nav-link" href="actu.php">Actualités</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="simu.php">Simulation</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="apropos.php">À propos</a>
              </li>
            </ul>
            <?php 
                    //phase de verification de session
                    session_start();
                    
                    if (isset($_SESSION['id']) && isset($_SESSION['pass'])) { 
                    //code pour la deconnection du compte?>
                    <a class="btn btn-success me-auto pull-right m-2" href="profil.php" role="button">Mon profil</a>
                    <a class="btn btn-outline-secondary me-auto pull-right m-2" href="deconnexion.php" role="button">Deconnexion</a>

                    <?php
                    }
                    else{
                    ?>
                    
                    <a class="btn btn-success me-auto pull-right m-2" href="inscription.php" role="button">Inscription</a>
                    <a class="btn btn-outline-secondary me-auto pull-right m-2" href="connexion.php" role="button">Connexion</a>
                    <?php
                    }
                    try{
                      include("setting/parametre.inc.php");
                    }
                    catch(Exception $e){
                    die('Connexion impossible à la base de données !'.$e->getMessage());
                    }
                    ?>
            </div>
                    
                    
      </nav>
<body>
<h1 class="display-3 text-center text-info">Connexion</h1>

<?php 
try{
  include("setting/parametre.inc.php");
}
catch(Exception $e){
die('Connexion impossible à la base de données !'.$e->getMessage());
}
?>
	<form method="post">
        <div class="form-group p-3">
          <label for="inputid">Identifiant</label>
          <input type="text" class="form-control" name="inputid" placeholder="112" name="inputid">
        </div>
        <div class="form-group p-3">
          <label for="inputPassword1">Mot de passe</label>
          <input type="password" class="form-control" name="inputPassword1" placeholder="Mot de passe">
        </div>
      <button type="submit" class="btn btn-primary m-3" name="submit">Connexion</button>
    </form>

<?php
if (isset($_POST['submit'])){
	//phase de stockage de donnée le id et le mdp
	$_SESSION['id'] = $_POST['inputid'];
	$_SESSION['pass'] = $_POST['inputPassword1'];
	$password = md5($_SESSION['pass']);
		//Apres identification d'un client
		$req="SELECT utilisateur.id_utilisateur,utilisateur.Mdp,utilisateur.adm FROM utilisateur WHERE utilisateur.id_utilisateur='".$_SESSION['id']."' AND utilisateur.Mdp='".$password."'";
		$result=$bd->query($req);
		while($ligne=$result->fetch()){
			if ($_SESSION["id"]==$ligne[0] && $password==$ligne[1]) {
        $_SESSION['adm']=$ligne[2];
				header("location: index.php");
			}
		}?>

    <div class="alert alert-danger" role="alert">
      <a href="#" class="alert-link">Identifiant ou mot de passe</a> incorrect.
    </div>

    <?php
}
?>
</body>
</html>