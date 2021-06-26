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
      <!-- Onglet de navigation  -->
      <div class="nav nav-tabs" id="nav-tab" role="tablist">
        <!-- Onglets des flux RSS -->
        <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">COVID-19</a>
        <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Santé publique france</a>
        <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-contact" role="tab" aria-controls="nav-contact" aria-selected="false">ARS</a>
        <a class="nav-item nav-link" id="nav-rss-tab" data-toggle="tab" href="#nav-rss" role="tab" aria-controls="nav-rss" aria-selected="false">Flux RSS</a>
      </div>
      <!-- 1er onglet -->
      <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                
            <div class="row">
            <?php
            //liste des meme template RSS
            $xml1 = array('https://api-a1.beta.curebot.io/v1/atom-feed/smartfolder/5fc33913bf184b708e11a7619580bc6b', 'https://api-a1.beta.curebot.io/v1/atom-feed/smartfolder/0108158cafff45a6ab6bbf57bcc4cb2c', 'https://api-a1.beta.curebot.io/v1/atom-feed/smartfolder/83ada5c002724cdc992b3f1faa80b0bd');
            //parcours de la liste RSS
            for ($j=0; $j < count($xml1) ; $j++) {
              //initialisation fichier xml
              $xml = simplexml_load_file($xml1[$j]);
              //parcours du premier lien XML
              for ($i=0; $i < count($xml)/7 ; $i++) { ?>
                  <div class="col-sm-4 mt-4">
                      <div class="card h-100">
                        <div class="card-body">
                          <!-- affichage de la premiere balise tittle ... -->
                          <h5 class="card-title"><?php echo $xml->entry[$i]->title;?></h5>
                          <p class="font-italic"> <?php echo $xml->entry[$i]->author->name;?></p>
                          <p class="card-text"><small><?php echo $xml->entry[$i]->summary;?></small></p>
                          <p class="card-text"><?php echo "<a href='".$xml->entry[$i]->id."' target='_blank'>En savoir +</a>";?></p>
                          <button type="button" class="btn btn-primary" onclick="ajout('<?php echo $xml->entry[$i]->id;?>')">Ajouter aux favoris</button>
                          
                        </div>
                        <div class="card-footer">
                            <small class="text-muted"><?php echo $xml->entry[$i]->updated;?></small>
                        </div>
                      </div>
                  </div>

              <?php
              }
              }
              ?>
              </div>
      
        
        </div>
        <!-- 2eme onglet -->
        <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
            <!-- meme technique que précedemment -->
            <div class="row">
                <?php
                $xml2 = array('https://www.santepubliquefrance.fr/rss/themes/vaccination.xml?1622621786', 'https://www.santepubliquefrance.fr/rss/themes/maladies-et-infections-respiratoires.xml?1622621786','https://www.santepubliquefrance.fr/rss/communiques-de-presse.xml?1622621786','https://www.santepubliquefrance.fr/rss/actualites.xml?1622621786','https://www.santepubliquefrance.fr/rss/regions/national.xml?1622621786');
                for ($j=0; $j < count($xml2) ; $j++) {
                  $xml3 = simplexml_load_file($xml2[$j]);
                  for ($i=0; $i < count($xml3->channel->item) ; $i++) {?>
                      <div class="col-sm-4 mt-4">
                          <div class="card h-100">
                            <div class="card-body">
                              <?php echo $xml3->channel->title;?>
                              <h5 class="card-title"><?php echo $xml3->channel->item[$i]->title;?></h5>
                              <p class="card-text text-wrap"><?php echo $xml3->channel->item[$i]->description;?></p>
                              <p class="card-text"><?php echo "<a href='".$xml3->channel->item[$i]->link."' target='_blank'>En savoir +</a>";?></p>
                              <button type="button" class="btn btn-primary" onclick="ajout('<?php echo $xml3->channel->item[$i]->link;?>')">Ajouter aux favoris</button>
                              
                            </div>
                            <div class="card-footer">
                                <small class="text-muted"><?php echo $xml3->channel->item[$i]->pubDate;?></small>
                            </div>
                          </div>
                      </div>

                  <?php
                  }
                  }
                  ?>
                  </div>
        
        </div>
        <!-- 3eme onglet -->
        <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
            <!-- meme technique que précedemment -->
            <div class="row">
                  <?php
                  $xml4 = array('https://www.iledefrance.ars.sante.fr/rss.xml','https://www.iledefrance.ars.sante.fr/rss.xml?type=ars_actualite');
                  for ($k=0; $k < count($xml4) ; $k++) {
                    $xml5 = simplexml_load_file($xml4[$k]);
                    for ($l=0; $l < count($xml5->channel->item) ; $l++) {?>
                        <div class="col-sm-4 mt-4">
                            <div class="card h-100">
                              <div class="card-body">
                                <h5 class="card-title"><?php echo $xml5->channel->item[$l]->title;?></h5>
                                <p class="card-text text-wrap"><?php echo $xml5->channel->item[$l]->description;?></p>
                                <p class="card-text"><?php echo "<a href='".$xml5->channel->item[$l]->link."' target='_blank'>En savoir +</a>";?></p>
                                <button type="button" class="btn btn-primary" onclick="ajout('<?php echo $xml5->channel->item[$l]->link;?>')">Ajouter aux favoris</button>
                                
                              </div>
                              <div class="card-footer">
                                  <small class="text-muted"><?php echo $xml5->channel->item[$l]->pubDate;?></small>
                              </div>
                            </div>
                        </div>
                        

                    <?php
                    }
                    }
                    ?>
              </div>
            
        </div>

        <!-- 4eme onglet -->
        <div class="tab-pane fade" id="nav-rss" role="tabpanel" aria-labelledby="nav-rss-tab">
        
        <a href="https://www.santepubliquefrance.fr/rss/regions/national.xml?1622621786" target='_blank'>National : Santé publique France</a> <br>
        <a href="https://www.santepubliquefrance.fr/rss/themes/vaccination.xml?1622621786" target='_blank'>Vaccination : Santé publique France</a><br>
        <a href="https://www.santepubliquefrance.fr/rss/themes/maladies-et-infections-respiratoires.xml?1622621786" target='_blank'>Maladies et infections respiratoires : Santé publique France</a><br>
        <a href="https://www.santepubliquefrance.fr/rss/communiques-de-presse.xml?1622621786" target='_blank'>Communiqués de presse : Santé publique France</a><br>
        <a href="https://www.santepubliquefrance.fr/rss/actualites.xml?1622621786" target='_blank'>Actualités : Santé publique France</a><br>
        <a href="https://api-a1.beta.curebot.io/v1/atom-feed/smartfolder/5fc33913bf184b708e11a7619580bc6b" target='_blank'>🦠 Covid-19 - Impacts</a><br>
        <a href="https://api-a1.beta.curebot.io/v1/atom-feed/smartfolder/0108158cafff45a6ab6bbf57bcc4cb2c" target='_blank'>🦠 Covid-19 - Etat des lieux</a><br>
        <a href="https://api-a1.beta.curebot.io/v1/atom-feed/smartfolder/83ada5c002724cdc992b3f1faa80b0bd" target='_blank'>🦠 Covid-19 - Stay Home</a>     <br>
        <a href="https://www.iledefrance.ars.sante.fr/rss.xml" target='_blank'>Agence Régionale de Santé île de france - Actualités</a>     <br>
        <a href="https://www.iledefrance.ars.sante.fr/rss.xml?type=ars_actualite" target='_blank'>Agence Régionale de Santé île de france - Global</a>     <br>  
        </div>
      </div>

    </body>
    <script>    
          //fonction pour ajouter un article au favoris
          function ajout(number) {
            <?php if (isset($_SESSION['id']) && isset($_SESSION['pass'])) { ?>
            //message d'ajout
            document.activeElement.innerHTML = 'Ajouté  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-lg" viewBox="0 0 16 16"><path d="M13.485 1.431a1.473 1.473 0 0 1 2.104 2.062l-7.84 9.801a1.473 1.473 0 0 1-2.12.04L.431 8.138a1.473 1.473 0 0 1 2.084-2.083l4.111 4.112 6.82-8.69a.486.486 0 0 1 .04-.045z"/></svg>';
            document.activeElement.setAttribute("style", "background-color:green");
            //stockage du lien de l'article dans l'url pour ajout
            window.location.href = "actu.php?url=" + number;
            
            <?php 
            if (isset($_GET["url"]) && isset($_SESSION['id'])) {
            $url=$_GET["url"];
            $id=$_SESSION["id"];
            //date d'ajout
            $today = date("Y-m-d H:i:s"); 
            //requete ajout de l'article
            $req="INSERT INTO favori (url_fav,date_ajout,id_utilisateur) VALUES ('".$url."','".$today."','".$id."')";
            $result=$bd->prepare($req);
            $result->execute();
            $result->closeCursor();
            }?>
            <?php }
            else{?>
            var msg="Vous devez être connectez !";
            console.log(msg);
            alert(msg);
            <?php }?>
          }
      </script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</html>