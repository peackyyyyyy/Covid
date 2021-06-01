<!DOCTYPE html>
<html>
<head>
    <title>Boulangerie</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="icon" href="img/index.ico">
</head>
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
<a href="index.php"><button>ACCUEIL</button></a>
<h1>Inscription<h1>
   
    <form method="post">
        <h1>Vous êtes</h1> <button name="particulier">Particulier</button> <button name="societe">Société</button>
        <?php
        if (isset($_POST["particulier"])) {
        //phase d'inscription qui récupère les informations en fonction de si vous êtes un particulier ou une société
        $_SESSION["c"]=0;
        ?>
        <h2>Nom</h2>
        <input type="text" name="nom">
        <h2>Prénom</h2>
        <input type="text" name="prenom">
        <h2>Adresse</h2>
        <input type="text" name="adresse">
        <h2>E-mail</h2>
        <input type="email" name="email">
        <h2>Mot de passe</h2>
        <input type="password" name="password">

        <p>Confirmez votre Mot de passe</p>
        <input type="password" name="repeatpassword"><br><br>
        <input type="submit" name="submit" value="Valider">
        <?php
        }
        if (isset($_POST["societe"])) {
        $_SESSION["c"]=1;?>
        <h2>Chiffre d'affaires</h2>
        <input type="number" name="ca">
        <h2>Raison Sociale</h2>
        <input type="text" name="raison">
        <h2>Nom Société</h2>
        <input type="text" name="nomsoc">
        <h2>Adresse</h2>
        <input type="text" name="adresse">
        <h2>E-mail</h2>
        <input type="email" name="email">
        <h2>Mot de passe</h2>
        <input type="password" name="password">

        <p>Confirmez votre Mot de passe</p>
        <input type="password" name="repeatpassword"><br><br>
        <input type="submit" name="submit" value="Valider">
        <?php
        }
        ?>
        
   
    </form>
<?php
   
if (isset($_POST['submit'])){
if ($_SESSION["c"]==0) {
$Nom = $_POST['nom'];
$Prenom = $_POST['prenom'];
$adresse = $_POST['adresse'];
$email = $_POST['email'];
$password = $_POST['password'];
$repeatpassword = $_POST['repeatpassword'];
//vérification du remplissage de tous les champ
if ($Nom&&$Prenom&&$adresse&&$email&&$password&&$repeatpassword)
        {
        if (strlen($password)>=6)
            {//taille du mot de passe
                if ($password==$repeatpassword)
                {
            // On crypte le mot de passe
                $password = md5($password);

    //requete qui crée le client
    $req="INSERT INTO Client (mail,adresse,mdp) VALUES
    ('".$email."','".$adresse."','".$password."')";
    $result=$bd->prepare($req);
    $result->execute();
    $result->closeCursor();
    $req2="SELECT idclient FROM Client WHERE mail='".$email."' AND adresse='".$adresse."' AND mdp='".$password."'";
    $result2=$bd->query($req2);
    while($ligne2=$result2->fetch()){
        $req3="INSERT INTO particulier (idclient, nom, prenom) VALUES
        ('".$ligne2[0]."','".$Nom."', '".$Prenom."')";
        $result3=$bd->prepare($req3);
        $result3->execute();
        echo "Inscription terminée! <br>";
        echo "Votre identifiant est ".$ligne2[0].".";
        $_SESSION["idcliverif"]=$ligne2[0];
    }
        echo "<br>Veuillez confirmer votre adresse e-mail";
        $subject='Vérification Mail';
        $message="Merci de votre Inscription veuillez verifier votre mail à cette adresse https://etudiant.u-pem.fr/~tmario01/Projet%20PHP/mail.php?idclient=".$_SESSION['idcliverif']."";
        mail($email, $subject, $message);
}else echo "Les mots de passe ne sont pas identiques";
}else echo "Le mot de passe est trop court !";
}else echo "Veuillez saisir tous les champs !";                
}
if ($_SESSION["c"]==1) {
$ca = $_POST['ca'];
$raison = $_POST['raison'];
$Nom = $_POST['nomsoc'];
$adresse = $_POST['adresse'];
$email = $_POST['email'];
$password = $_POST['password'];
$repeatpassword = $_POST['repeatpassword'];
if ($ca&&$raison&&$Nom&&$adresse&&$email&&$password&&$repeatpassword)
        {
        if (strlen($password)>=6)
            {//taille du mot de passe
                if ($password==$repeatpassword)
                {
            // On crypte le mot de passe

                $password = md5($password);

    //requete qui crée le client
    $req="INSERT INTO Client (mail,adresse,mdp) VALUES
    ('".$email."','".$adresse."','".$password."')";
    $result=$bd->prepare($req);
    $result->execute();
    $result->closeCursor();
    $req2="SELECT idclient FROM Client WHERE mail='".$email."' AND adresse='".$adresse."' AND mdp='".$password."'";
    $result2=$bd->query($req2);
    while($ligne2=$result2->fetch()){
        $req3="INSERT INTO Societe (idclient, CA, raisonsociale, nomsociete) VALUES
        ('".$ligne2[0]."',".$ca.", '".$raison."', '".$Nom."')";
        $result3=$bd->prepare($req3);
        $result3->execute();
        echo "Inscription terminée! <br>";
        echo "Votre identifiant est ".$ligne2[0].".";
        $_SESSION["idcliverif"]=$ligne2[0];
    }
    echo "<br>Veuillez confirmer votre adresse e-mail";
        $subject='Vérification Mail';
       $message="Merci de votre Inscription veuillez verifier votre mail à cette adresse https://etudiant.u-pem.fr/~tmario01/Projet%20PHP/mail.php?idclient=".$_SESSION['idcliverif']."";
        mail($email, $subject, $message);

}else echo "Les mots de passe ne sont pas identiques";
}else echo "Le mot de passe est trop court !";
}else echo "Veuillez saisir tous les champs !";                
}  
}
   
?>

</body>
</html>