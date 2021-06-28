<!doctype html>
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
    <h1 class="display-3 text-center text-info">Bonjour N°<?php echo $_SESSION["id"];?> </h1>

      <div class="nav nav-tabs justify-content-center" id="nav-tab" role="tablist">
        <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Modifier</a>
        <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Mes favoris</a>
        <a class="nav-item nav-link" id="nav-histo-tab" data-toggle="tab" href="#nav-histo" role="tab" aria-controls="nav-histo" aria-selected="false">Mon historique</a>
        <?php
        if ($_SESSION['adm']==1) {?>
        <a class="nav-item nav-link" href="admin.php" role="tab" aria-controls="nav-profile" aria-selected="false">Admin</a>
        <?php
        }
        ?>
      </div>
    </nav>
    <div class="tab-content" id="nav-tabContent">
      <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
          <form method="post">
          <?php
          $password = md5($_SESSION['pass']);
          $req="SELECT id_utilisateur,Mdp,Nom,Prenom,Mail,Adresse_postale FROM utilisateur WHERE utilisateur.id_utilisateur='".$_SESSION['id']."' AND utilisateur.Mdp='".$password."'";
          $result=$bd->query($req);
          while($ligne=$result->fetch()){
              if ($_SESSION["id"]==$ligne[0] && $password==$ligne[1]) {
                  ?>
                  <div class="form-row p-3">
                      <div class="form-group col-md-6">
                          <label for="inputnom">Nom</label>
                          <input type="text" class="form-control" name="inputnom" value="<?php echo $ligne[2];?>">
                      </div>
                      <div class="form-group col-md-6">
                          <label for="inputprenom">Prénom</label>
                          <input type="text" class="form-control" name="inputprenom" value="<?php echo $ligne[3];?>">
                      </div>
                  </div>
                  <div class="form-group p-3">
                      <label for="inputEmail">E-mail</label>
                      <input type="email" class="form-control" name="inputEmail" value="<?php echo $ligne[4];?>">
                  </div>
                  <div class="form-group p-3">
                      <label for="inputAddress">Adresse</label>
                      <input type="text" class="form-control" name="inputAddress" value="<?php echo $ligne[5];?>">
                  </div>
                  <button type="submit" class="btn btn-primary m-3" name="submit">Mettre à jour</button>
                  <?php
              }
          }
          ?>
          </form>
          <?php
          if (isset($_POST['submit'])){
              $nom = $_POST['inputnom'];
              $prenom = $_POST['inputprenom'];
              $adresse = $_POST['inputAddress'];
              $email = $_POST['inputEmail'];
              if ($nom&&$prenom&&$adresse&&$email){

                  $req="UPDATE Utilisateur SET Nom='".$nom."',Prenom='".$prenom."',Mail='".$email."', adresse_postale='".$adresse."' WHERE id_utilisateur='".$_SESSION["id"]."'";
                  $result=$bd->prepare($req);
                  $result->execute();
                  $result->closeCursor();
                  echo "<script>window.location.href = 'profil.php';</script>";

                  }
              else{?>
              
              <div class="alert alert-danger" role="alert">
                <a href="#" class="alert-link">Veuillez saisir tous les champs !</a>
              </div>
              
              <?php
              }
          } 
          
          ?>
      
      </div>
      <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
          <div class="row">
            <?php
            $req2="SELECT url_fav,date_ajout FROM favori WHERE favori.id_utilisateur='".$_SESSION['id']."'";
                $result2=$bd->query($req2);
                while($ligne=$result2->fetch()){?>
                  <div class="col-sm-4 mt-4">
                      <div class="card h-100">
                        <div class="card-body">
                          <a class="card-title" href="<?php echo $ligne[0];?>" target="_blank"><?php echo $ligne[0];?></a><br><br>
                          <button type="button" class="btn btn-primary" onclick="sup('<?php echo $ligne[0];?>')">Supprimer</button>
                        </div>
                        <div class="card-footer">
                                  <small class="text-muted">Ajouté le <?php echo $ligne[1];?></small>
                        </div>
                      </div>
                  </div>
                <?php
                }
            ?>
           </div>
      </div>
      <div class="tab-pane fade" id="nav-histo" role="tabpanel" aria-labelledby="nav-histo-tab">

                historique

      </div>
    </div>
    </body>
    <script>    
          function sup(number) {
            document.activeElement.innerHTML = 'Supprimé  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-lg" viewBox="0 0 16 16"><path d="M13.485 1.431a1.473 1.473 0 0 1 2.104 2.062l-7.84 9.801a1.473 1.473 0 0 1-2.12.04L.431 8.138a1.473 1.473 0 0 1 2.084-2.083l4.111 4.112 6.82-8.69a.486.486 0 0 1 .04-.045z"/></svg>';
            document.activeElement.setAttribute("style", "background-color:red");
            //var sessionid = "<?php //echo $_SESSION['id']; ?>";
            window.location.href = "profil.php?url=" + number;
            <?php 
            if (isset($_GET["url"]) && isset($_SESSION['id'])) {
              $url=$_GET["url"];
              $id=$_SESSION["id"];
              $req="DELETE FROM favori WHERE url_fav='".$url."' AND id_utilisateur='".$id."'";
              $result=$bd->prepare($req);
              $result->execute();
              $result->closeCursor();
              
            }?>
            //window.location.href = "profil.php";
            //header("Refresh:0; url=profil.php");
          }
      </script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</html>