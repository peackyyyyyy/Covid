<!doctype html>
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
    <?php
        if ($_SESSION['adm']==0) {
            header("location: profil.php");
        }
        ?>

    <h1 class="display-3 text-center text-info">Admin</h1>

    <div class="nav nav-tabs" id="nav-tab" role="tablist">
        <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Gestion des utilisateurs</a>
        <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Profile</a>
        <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-contact" role="tab" aria-controls="nav-contact" aria-selected="false">Contact</a>
    </div>
    </nav>
    <div class="tab-content" id="nav-tabContent">
    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">utilisateur</div>
    <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">...</div>
    <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">...</div>
    </div>



    </body>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</html>