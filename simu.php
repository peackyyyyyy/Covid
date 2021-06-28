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

    <h1 class="display-3 text-center text-info">Simulation</h1>

          <!-- Button ajouter simulation -->
          <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
          Ajouter Simulation
          </button>

          <!-- Modele du pop-up -->
          <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Ajouter Simulation</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                <form>

                    <div class="form-row p-3">

                      <div class="form-group col-md-6">

                        <label for="population">Population</label>

                        <input type="number" class="form-control" min=1 name="population" id="population" placeholder="800 habitants">

                      </div>

                      <div class="form-group col-md-6">

                        <label for="duree">Durée (Jours)</label>

                        <input type="number" class="form-control" min=20 name="duree" id="duree" placeholder="50 jours">

                      </div>

                      <div class="form-group col-md-6">

                        <label for="mask">Port du mask</label>

                        <select name="mask" class="form-control" id="mask">

                            <option value="0">Non</option>

                            <option value="1">Oui</option>

                        </select>

                      </div>

                      <div class="form-group col-md-6">

                        <label for="Confinement">confinement</label>

                        <select name="Confinement" class="form-control" id="confinement">

                            <option value="0">Non</option>

                            <option value="1">Oui</option>

                        </select>

                      </div>

                      <div class="form-group col-md-6">

                        <label for="fermeture_frontieres">Fermeture des frontieres</label>

                        <select name="fermeture_frontieres" class="form-control" id="fermeture_frontieres">

                            <option value="0">Non</option>

                            <option value="1">Oui</option>

                        </select>

                      </div>

                      <div class="form-group col-md-6">

                      <label for="variant">Apparition nouveau variant</label>

                        <input type="number" class="form-control" min=0 name="variant" id="variant" placeholder="50 jours">

                      </div>



                    </div>

                    </form>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <button type="button" id="lancer" class="btn btn-primary">Lancer</button>
                </div>
              </div>
            </div>
          </div>



    <table id="tab" class="table table-hover">
      <thead>
        <tr>
          <th scope="col">ID Simulation</th>
          <th scope="col">Parametres</th>
          <th scope="col">Etat</th>
          <th scope="col">Simulation</th>
          <th scope="col">Resultat</th>
        </tr>
      </thead>
      <tbody>


        <!-- template-->

        <!-- template-->


      </tbody>
    </table>




    </body>

    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

    <script>

        function get_simulation(){
            $.ajax({
                    type: 'GET',
                    url: 'http://localhost:5000/simulation',
                    success: function(data)
                    {
                        var tab = document.getElementById('tab');
                        console.log(data);
                        data.forEach(element => { console.log(element);
                            if(element['status'] == 'finish'){
                                tab.innerHTML += `
                                    <tr>
                                      <th scope="row">${element['id']}</th>
                                      <td>Duree : ${element['duree']}<br>Population : ${element['population']}<br>Port du masque : ${element['port_mask']}<br>Deplacement inter-region : ${element['deplacement_region']}<br>Nouveau Variant : ${element['new_variant']}<br></td>
                                      <td>${element['status']}</td>
                                      <td><a href="http://localhost:5000/simulation_direct"><button type="submit" id="simulation" class="btn btn-primary m-3" name="submit">Simulation</button></a></td>
                                      <td><a href="http://localhost:5000/simulation_result/${element['id']}"<button type="submit" id="resultat" class="btn btn-primary m-3" name="submit">Resultat</button></a></td>
                                    </tr>
                                `;
                            }
                            else {
                                tab.innerHTML += `
                                    <tr>
                                      <th scope="row">${element['id']}</th>
                                      <td>Duree : ${element['duree']}<br>Population : ${element['population']}<br>Port du masque : ${element['port_mask']}<br>Deplacement inter-region : ${element['deplacement_region']}<br>Nouveau Variant : ${element['new_variant']}<br></td>
                                      <td>${element['status']}</td>
                                      <td><a href="http://localhost:5000/simulation_direct"><button type="submit" id="simulation" class="btn btn-primary m-3" name="submit">Simulation</button></a></td>
                                    </tr>
                                `;
                            }
                        });

                    }
            });
        }

        setInterval(get_simulation(), 5000);

        $("#lancer").click(function (e) {

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
                    window.location.href = 'http://localhost/Covid/simu.php';

                }

            });



        });



    </script>

</html>