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
                    session_start();
                    session_destroy();
                    unset($_SESSION);?>
                    <a class="btn btn-success me-auto pull-right" href="incription.php" role="button">Inscription</a>
                    <a class="btn btn-outline-secondary me-auto pull-right" href="connexion.php" role="button">Connexion</a>
        </div>
      </nav>
    <body>

        Accueil
        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
              <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
              <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
              <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
            </ol>
            <div class="carousel-inner">
              <div class="carousel-item active">
                <img class="d-block w-100 h-50" src="img/img1.jpg" alt="First slide">
              </div>
              <div class="carousel-item">
                <img class="d-block w-100 h-50" src="img/img1.jpg" alt="Second slide">
              </div>
              <div class="carousel-item">
                <img class="d-block w-100 h-50" src="img/img1.jpg" alt="Third slide">
              </div>
            </div>
            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
              <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
              <span class="carousel-control-next-icon" aria-hidden="true"></span>
              <span class="sr-only">Next</span>
            </a>
          </div>
    
    </body>
    <script>console.log("hello");</script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</html>