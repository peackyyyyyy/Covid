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
    <?php
      //check si c'est un admin
        if ($_SESSION['adm']==0) {
            header("location: profil.php");
        }
        ?>

    <h1 class="display-3 text-center text-info">Admin</h1>
          <?php
          $password = md5($_SESSION['pass']);
          //requete de récupération des utilisateurs
          $req="SELECT * FROM utilisateur";
          $result=$bd->query($req);
          while($ligne=$result->fetch()){
            //affichage des informations des utilisateurs
                  ?>
                  <form method="post" action="adminreq.php">
                  <div class="form-row p-3">
                      <div class="form-group col-md-1">
                              <label for="inputid">ID</label>
                              <input type="text" class="form-control" name="inputid" value="<?php echo $ligne[0];?>" readonly>
                      </div>
                      <div class="form-group col-md-2">
                          <label for="inputnom">Nom</label>
                          <input type="text" class="form-control" name="inputnom" value="<?php echo $ligne[1];?>">
                      </div>
                      <div class="form-group col-md-2">
                          <label for="inputprenom">Prénom</label>
                          <input type="text" class="form-control" name="inputprenom" value="<?php echo $ligne[2];?>">
                      </div>
                      <div class="form-group col-md-2">
                          <label for="inputEmail">E-mail</label>
                          <input type="email" class="form-control" name="inputEmail" value="<?php echo $ligne[3];?>">
                      </div>
                      <div class="form-group col-md-2">
                          <label for="inputAddress">Adresse</label>
                          <input type="text" class="form-control" name="inputAddress" value="<?php echo $ligne[4];?>">
                      </div>
                      <div class="form-group col-md-1">
                          <label for="inputAdmin">Admin</label>
                          <select name="inputAdmin" class="form-control">
                              <option value="<?php echo $ligne[6];?>"><?php echo $ligne[6];?></option>
                              <?php if($ligne[6]==1){ echo '<option value="0">0</option>';}?>
                              <?php if($ligne[6]==0){ echo '<option value="1">1</option>';}?>
                          </select>
                      </div>
                      <button type="submit" class="btn btn-primary m-3" name="modif">Modifier</button>
                      <button type="submit" class="btn btn-primary m-3" name="sup">Supprimer</button>
                  </div>
                  </form>
                  <?php
          }
          ?>
          <!--formulaire pour ajouter un utilisateur-->
          <form method="post" action="adminreq.php">
                  <div class="form-row p-3">
                      <div class="form-group col-md-2">
                          <label for="inputnom">Nom</label>
                          <input type="text" class="form-control" name="inputnom">
                      </div>
                      <div class="form-group col-md-2">
                          <label for="inputprenom">Prénom</label>
                          <input type="text" class="form-control" name="inputprenom">
                      </div>
                      <div class="form-group col-md-2">
                          <label for="inputEmail">E-mail</label>
                          <input type="email" class="form-control" name="inputEmail">
                      </div>
                      <div class="form-group col-md-2">
                          <label for="inputAddress">Adresse</label>
                          <input type="text" class="form-control" name="inputAddress">
                      </div>
                      <div class="form-group col-md-2">
                          <label for="inputPassword">Mot de passe</label>
                          <input type="password" class="form-control" name="inputPassword">
                      </div>
                      <div class="form-group col-md-1">
                          <label for="inputAdmin">Admin</label>
                          <select name="inputAdmin" class="form-control">
                              <option value=""></option>
                              <option value="0">0</option>
                              <option value="1">1</option>
                          </select>
                      </div>
                      <button type="submit" class="btn btn-primary m-3" name="ajout">Ajouter</button>
                  </div>
            </form>

            <?php
            //check si tous les champ ont été remplis
            if (isset($_GET["c"])) {
              ?>
                              
                <div class="alert alert-danger" role="alert">
                  <a href="#" class="alert-link">Veuillez saisir tous les champs !</a>
                </div>

                <?php
                
            }
            ?>


    </body>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</html>