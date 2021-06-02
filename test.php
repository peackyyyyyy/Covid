<html>
<head>
        <title>COV19</title> 
        <meta http-equiv="content.type" content="text/html"; charset="UTF-8">
        <link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        
        
        <link rel="icon" href="img/COVID19.ico">
    </head>

<body>
<?php session_start();?>
<div class="row">
<div class="col-sm-4 mt-4">
    <div class="card h-100">
        <div class="card-body">
        <h5 class="card-title">test</h5>
        <p class="card-text text-wrap">test</p>
        <p class="card-text">test</p>
        <button type="button" class="btn btn-primary"  onclick="ajout('<?php echo 'www.huffingtonpost.fr/entry/coronavirus-le-plexiglas-lui-aussi-en-rupture-de-stock_fr_5ecb59dbc5b66ddcaf0f02ea';?>')">Ajouter aux favoris</button>
        
        </div>
        <div class="card-footer">
            <small class="text-muted">test</small>
        </div>
    </div>
</div>
<div class="col-sm-4 mt-4">
    <div class="card h-100">
        <div class="card-body">
        <h5 class="card-title">test</h5>
        <p class="card-text text-wrap">test</p>
        <p class="card-text">test</p>
        <button type="button" class="btn btn-primary"  onclick="ajout('<?php echo 'autreurllllllllllllllllllllll';?>')">Ajouter aux favoris</button>
        
        </div>
        <div class="card-footer">
            <small class="text-muted">test</small>
        </div>
    </div>
</div>
        <script>    
          function ajout(number) {
            document.activeElement.innerHTML = 'Ajouté  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-lg" viewBox="0 0 16 16"><path d="M13.485 1.431a1.473 1.473 0 0 1 2.104 2.062l-7.84 9.801a1.473 1.473 0 0 1-2.12.04L.431 8.138a1.473 1.473 0 0 1 2.084-2.083l4.111 4.112 6.82-8.69a.486.486 0 0 1 .04-.045z"/></svg>';
            document.activeElement.setAttribute("style", "background-color:green");
            console.log(number);
            var sessionid = "<?php echo $_SESSION['id']; ?>";
            console.log(sessionid);
          }
          </script>
</body>
</html>