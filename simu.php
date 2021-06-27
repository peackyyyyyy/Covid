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

    <h1 class="display-3 text-center text-info">Simulation</h1>



    <form>

      <div class="form-row p-3">

        <div class="form-group col-md-1">

          <label for="population">Population</label>

          <input type="number" class="form-control" name="population" id="population" placeholder="800">

        </div>

        <div class="form-group col-md-2">

          <label for="duree">Durée</label>

          <input type="number" class="form-control" name="duree" id="duree">

        </div>

        <div class="form-group col-md-2">

          <label for="mask">Port du mask</label>

          <select name="mask" class="form-control" id="mask">

              <option value="0">Non</option>

              <option value="1">Oui</option>

          </select>

        </div>

        <div class="form-group col-md-1">

          <label for="Confinement">confinement</label>

          <select name="Confinement" class="form-control" id="confinement">

              <option value="0">Non</option>

              <option value="1">Oui</option>

          </select>

        </div>

        <div class="form-group col-md-2">

          <label for="fermeture_frontieres">Fermeture des frontieres</label>

          <select name="fermeture_frontieres" class="form-control" id="fermeture_frontieres">

              <option value="0">Non</option>

              <option value="1">Oui</option>

          </select>

        </div>

        <div class="form-group col-md-2">

        <label for="variant">Nouveau variant</label>

          <input type="number" class="form-control" name="variant" id="variant">

        </div>

        <button type="submit" id="submit" class="btn btn-primary m-3" name="submit">Lancer</button>

      </div>

    </form>

    </body>

    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

    <script>

        $("#submit").click(function (e) {

            e.preventDefault();

            var population = document.getElementById("population").value;

            var duree = document.getElementById("duree").value;

            var confinement = document.getElementById("confinement").value;

            var port_mask = document.getElementById("mask").value;

            var deplacement_region = document.getElementById("fermeture_frontieres").value;

            var new_variant = document.getElementById("variant").value;

            $.ajax({

                type: "POST",

                url: "http://localhost:5000/add_simulation",

                data: JSON.stringify({  "nombre_jours": duree,

                                        "population": population,

                                        "confinement": confinement,

                                        "port_mask": port_mask,

                                        "deplacement_region": deplacement_region,

                                        "new_variant": new_variant} ),

                contentType: "application/json; charset=utf-8",

                dataType: "json",

                success: function (data) {

                    alert("Simulation Ajouté");

                }

            });



        });



    </script>

</html>
