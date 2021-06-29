<?php
        session_start();
        if ($_SESSION['adm']==0) {
            header("location: index.php");
        }
        try{
            include("setting/parametre.inc.php");
          }
          catch(Exception $e){
          die('Connexion impossible à la base de données !'.$e->getMessage());
          }
          $nom = $_POST['inputnom'];
        $prenom = $_POST['inputprenom'];
        $email = $_POST['inputEmail'];
        $adresse = $_POST['inputAddress'];
        $password = $_POST['inputPassword'];
        $adm=$_POST['inputAdmin'];
          if (isset($_POST["modif"])) {
                //requete pour update des utilisateurs
                $req="UPDATE utilisateur SET id_utilisateur= ?, Nom= ? ,Prenom= ? ,Mail= ?, adresse_postale= ?, adm= ? WHERE id_utilisateur= ? ";
                $result=$bd->prepare($req);
                //binvalue
                $result->bindValue(1, $_POST['inputid']);
                $result->bindValue(2, $_POST['inputnom']);
                $result->bindValue(3, $_POST['inputprenom']);
                $result->bindValue(4, $_POST['inputEmail']);
                $result->bindValue(5, $_POST['inputAddress']);
                $result->bindValue(6, $_POST['inputAdmin']);
                $result->bindValue(7, $_POST['inputid']);
                $result->execute();
                header('location: admin.php');
                die();
          }
          //suppression utilisateur
          if (isset($_POST["sup"])) {
            $req="DELETE FROM utilisateur WHERE id_utilisateur='".$_POST['inputid']."'";
            $result=$bd->prepare($req);
            $result->execute();
            header('location: admin.php');
          }
          //ajout utilisateur
          if (isset($_POST["ajout"])) {
            if ($nom&&$prenom&&$adresse&&$email&&$password&&$adm)
                {
                     $password = md5($_POST['inputPassword']);

                        $req="INSERT INTO utilisateur (Nom,Prenom,Mail,Adresse_postale,Mdp,Adm) VALUES
                        ('".$nom."','".$prenom."','".$email."','".$adresse."','".$password."','".$adm."')";
                        $result=$bd->prepare($req);
                        $result->execute();
                        $result->closeCursor();
                        header('location: admin.php');
                        die();

                        }else {
                            header('location: admin.php?c=1');
                          }


          }
          

?>