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
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php"></a>
                <img src="img/COVID19.png" alt="" width="30" height="24" class="d-inline-block align-text-top">
                COV19
              </a>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
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
              
          </div>
          <?php 
                    //phase de verification de session
                    session_start();

                    if (isset($_SESSION['id']) && isset($_SESSION['pass'])) { 
                    //code pour la deconnection du compte
                    echo "Bonjour ".$_SESSION['id']." ";?>
                    <a class="btn btn-success me-auto pull-right" href="<?php session_destroy();?>" role="button">Deconnexion</a>

                    <?php
                    }
                    else{
                    session_destroy();
                    ?>
                    
                    <a class="btn btn-success me-auto pull-right m-2" href="inscription.php" role="button">Inscription</a>
                    <a class="btn btn-outline-secondary me-auto pull-right m-2" href="connexion.php" role="button">Connexion</a>
                    <?php
                    }

                    ?>
        </div>
      </nav>
<body>

<?php
try{
  include("setting/parametre.inc.php");
}
catch(Exception $e){
die('Connexion impossible à la base de données !'.$e->getMessage());
}
session_start();
?>
<h1 class="display-1 text-center text-info">Inscription</h1>

    <form method="post">
      <div class="form-row p-3">
        <div class="form-group col-md-6">
          <label for="inputnom">Nom</label>
          <input type="text" class="form-control" name="inputnom" placeholder="Martin" name="inputnom">
        </div>
        <div class="form-group col-md-6">
          <label for="inputprenom">Prénom</label>
          <input type="text" class="form-control" name="inputprenom" placeholder="Martin">
        </div>
      </div>
      <div class="form-group p-3">
          <label for="inputEmail4">E-mail</label>
          <input type="email" class="form-control" name="inputEmail" placeholder="E-mail">
      </div>
      <div class="form-group p-3">
        <label for="inputAddress">Addresse</label>
        <input type="text" class="form-control" name="inputAddress" placeholder="1234 Main St">
      </div>
      <div class="form-row p-3">
        <div class="form-group col-md-6">
          <label for="inputPassword1">Mot de passe</label>
          <input type="password" class="form-control" name="inputPassword1" placeholder="Mot de passe">
        </div>
        <div class="form-group col-md-6">
          <label for="inputPassword2">Confirmation Mot de passe</label>
          <input type="password" class="form-control" name="inputPassword2" placeholder="Confirmation Mot de passe">
        </div>
      </div>
      <button type="submit" class="btn btn-primary m-3" name="submit">Inscription</button>
    </form>
        
<?php
   
if (isset($_POST['submit'])){
$nom = $_POST['inputnom'];
$prenom = $_POST['inputprenom'];
$adresse = $_POST['inputAddress'];
$email = $_POST['inputEmail'];
$password = $_POST['inputPassword1'];
$repeatpassword = $_POST['inputPassword2'];
//vérification du remplissage de tous les champ
if ($nom&&$prenom&&$adresse&&$email&&$password&&$repeatpassword)
        {
        if (strlen($password)>=6)
            {//taille du mot de passe
                if ($password==$repeatpassword)
                {
            // On crypte le mot de passe
                $password = md5($password);

    //requete qui crée le client
    $req="INSERT INTO Utilisateur (Nom,Prenom,Mail,Adresse_postale,Mdp,Adm) VALUES
    ('".$nom."','".$prenom."','".$email."','".$adresse."','".$password."',0)";
    $result=$bd->prepare($req);
    $result->execute();
    $result->closeCursor();
    $req2="SELECT id_utilisateur FROM utilisateur WHERE mail='".$email."' AND Adresse_postale='".$adresse."' AND Mdp='".$password."'";
    $result2=$bd->query($req2);
    while($ligne2=$result2->fetch()){
        echo "Inscription terminée! <br>";
        echo "Votre identifiant est ".$ligne2[0].".";
        $_SESSION["idutilisateur"]=$ligne2[0];
    }
}else echo "Les mots de passe ne sont pas identiques";
}else echo "Le mot de passe est trop court !";
}else echo "Veuillez saisir tous les champs !";
}                
   
?>

</body>
</html>