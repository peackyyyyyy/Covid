<!DOCTYPE html>
<html>
<head>
        <title>COV19</title> 
        <meta http-equiv="content.type" content="text/html"; charset="UTF-8">
        <!-- Link CSS -->
        <link rel="stylesheet" href="css/style.css">
        <!-- Link bootstrap -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link rel="icon" href="img/COVID19.ico">
    </head>
    <!-- Menu de navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <img src="img/cov19logo.png" alt="" width="40" height="40" class="d-inline-block align-text-top">
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
                      //include les paramètres de connexion
                      include("setting/parametre.inc.php");
                    }
                    catch(Exception $e){
                    //capture d'exception
                    die('Connexion impossible à la base de données !'.$e->getMessage());
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
?>
<h1 class="display-5 text-center text-info">Inscription</h1>

    <form method="post">
      <div class="form-row p-3">
        <div class="form-group col-md-6">
          <label for="inputnom">Nom</label>
          <input type="text" class="form-control" name="inputnom" placeholder="Martin" name="inputnom" <?php if(isset($_GET['nom_essai'])){ ?>value="<?php echo $_GET['nom_essai'];?><?php }?>">
        </div>
        <div class="form-group col-md-6">
          <label for="inputprenom">Prénom</label>
          <input type="text" class="form-control" name="inputprenom" placeholder="Martin" <?php if(isset($_GET['prenom_essai'])){ ?>value="<?php echo $_GET['prenom_essai'];?><?php }?>">
        </div>
      </div>
      <div class="form-group p-3">
          <label for="inputEmail">E-mail</label>
          <input type="email" class="form-control" name="inputEmail" placeholder="E-mail" <?php if(isset($_GET['mail_essai'])){ ?>value="<?php echo $_GET['mail_essai'];?><?php }?>">
      </div>
      <div class="form-group p-3">
        <label for="inputAddress">Adresse</label>
        <input type="text" class="form-control" name="inputAddress" placeholder="1234 Main St" <?php if(isset($_GET['adresse_essai'])){ ?>value="<?php echo $_GET['adresse_essai'];?><?php }?>">
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
$c=0; 
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
                    $c=1;
                }
                }
                else {
                  session_destroy();
                header("location: inscription.php?nom_essai=".$_POST['inputnom']."&prenom_essai=".$_POST['inputprenom']."&mail_essai=".$_POST['inputEmail']."&adresse_essai=".$_POST['inputAddress']."&index=identique");
                    }
              }else{ 
                session_destroy();
                header("location: inscription.php?nom_essai=".$_POST['inputnom']."&prenom_essai=".$_POST['inputprenom']."&mail_essai=".$_POST['inputEmail']."&adresse_essai=".$_POST['inputAddress']."&index=court");
              }
              }else {
                session_destroy();
                header("location: inscription.php?nom_essai=".$_POST['inputnom']."&prenom_essai=".$_POST['inputprenom']."&mail_essai=".$_POST['inputEmail']."&adresse_essai=".$_POST['inputAddress']."&index=champ");
                }
              } 
              
              
    if(isset($_GET['index'])&&$c==0){             
      if($_GET['index']=="champ"){ ?>
        <div class="alert alert-danger" role="alert">
              <a href="#" class="alert-link">Veuillez saisir tous les champs !</a>
        </div>
        <?php }
        
      if($_GET['index']=="court"){ ?>
          <div class="alert alert-danger" role="alert">
          Le<a href="#" class="alert-link"> mot de passe </a>est trop court !
        </div>
        <?php }

      if($_GET['index']=="identique"){ ?>
        <div class="alert alert-danger" role="alert">
          Les<a href="#" class="alert-link"> mots de passe </a>ne sont pas identiques.
        </div>
        <?php }
        
      }?>
</body>
</html>