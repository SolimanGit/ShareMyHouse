<!-- Nom du binome BALI-CROISILLE -->
<?php
    session_start();
    include("connex.inc.php");
    $idcom=connex("sharemyhouse","myparam");
    mysqli_set_charset($idcom, "utf8");
?>
<html>
<head>
  <title>Recherche</title>
  <meta charset="utf-8">
  <link rel="stylesheet" href="css/header.css">
  <link rel="stylesheet" href="css/style.css">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons"rel="stylesheet">
  <style>
  body{
    background-image: url('autre/background.jpg');
    background-repeat: no-repeat;
    background-attachment: fixed;
    background-position: 50% 40%;
  }
  </style>
</head>
<body>
  <header>
    <nav class="menu">
      <div class="menu_bis">
        <div class="menu_left">
          <a href="recherche2.php"><h1 id="logo">ShareMyhouse</h1></a>
        </div>
        <div class="menu_right">
          <?php
            if (isset($_SESSION["id"])) {
              echo '<a class="link" href="profil.php"><i class="material-icons">account_circle</i> Profil</a>';
              echo '<a class="link" href="deconnexion.php"><i class="material-icons">exit_to_app</i> Se déconnecter</a>';
            }
            else {
              echo '<a class="link" href="connexion.php"><i class="material-icons">person</i> Connexion</a>';
            }
          ?>
      </div>
      </div>
    </nav>
  </header>
  <div align="center">
    <h2>Recherche</h2>
  </div>
<a href="#"></a>
<div align="center">
<form method="post">
          <input type="text" name="recherche" placeholder="Où">
          <p>
          Date d'arrivée: <input type="date" name="arrive">
          Date de départ: <input type="date" name="départ">

          <label for="tri_prix">Fourchette de prix :</label>
          <select class="tri_prix" name="tri_prix">
            <option value="">Prix</option>
            <option value="20"># < 20 €</option>
            <option value="20.50"> 20 > # > 50 €</option>
            <option value="50">50 < # €</option>
          </select>
          </p>
          <br>
          <br>
          <input type="submit" name="submit" value="Rechercher">
</form>
</div>
<?php
if((isset($_POST["submit"]) && $_POST["recherche"]!="") || (isset($_POST["submit"]) && $_POST["arrive"]!="" && $_POST["départ"]!="")){
    $_POST["recherche"]=strtolower($_POST["recherche"]);
    preg_match_all("/\b[A-Za-z]+\b/",$_POST["recherche"],$mot);
    $requete="SELECT * from `annonce`";
    $result=@mysqli_query($idcom,$requete);
    $adresse="";
    $pays="";
    $ville="";
    while($tab=mysqli_fetch_array($result)){
        for($i=0;$i<count($mot[0]);$i++){
            if(preg_match("/".$mot[0][$i]."/","".$tab["adresse"]."") && !preg_match("/".$mot[0][$i]."/","".$adresse."")) $adresse=$adresse."%".$mot[0][$i]."";
            if(preg_match("/".$mot[0][$i]."/","".$tab["ville"]."") && !preg_match("/".$mot[0][$i]."/","".$ville."")) $ville=$ville."%".$mot[0][$i]."";
            if(preg_match("/".$mot[0][$i]."/","".$tab["pays"]."") && !preg_match("/".$mot[0][$i]."/","".$pays."")) $pays=$pays."%".$mot[0][$i]."";
        }
    }
    if($adresse!="")$adresse=$adresse."%";
    if($ville!="")$ville=$ville."%";
    if($pays!="")$pays=$pays."%";


    if (!empty($_POST["recherche"]) && !empty($_POST["arrive"]) && !empty($_POST["départ"])) {    // Conditions pour utiliser la bonne requête
      if (!empty($_POST["tri_prix"])) {
        if ($_POST["tri_prix"]==20) {
          $requete="SELECT * from `annonce` WHERE (`adresse` LIKE '".$adresse."' OR `ville` LIKE '".$ville."' OR `pays` LIKE '".$pays."') AND (`dispo_debut`<='".$_POST["arrive"]."' AND '".$_POST["arrive"]."'<= `dispo_fin`) AND (`dispo_debut`<='".$_POST["départ"]."' AND '".$_POST["départ"]."'<=`dispo_fin`) AND `prix`<='".$_POST["tri_prix"]."'";
        }
        elseif ($_POST["tri_prix"]==50) {
          $requete="SELECT * from `annonce` WHERE (`adresse` LIKE '".$adresse."' OR `ville` LIKE '".$ville."' OR `pays` LIKE '".$pays."') AND (`dispo_debut`<='".$_POST["arrive"]."' AND '".$_POST["arrive"]."'<= `dispo_fin`) AND (`dispo_debut`<='".$_POST["départ"]."' AND '".$_POST["départ"]."'<=`dispo_fin`) AND `prix`>='".$_POST["tri_prix"]."'";
        }
        elseif ($_POST["tri_prix"]==20.50) {
          $temp=explode(".",$_POST["tri_prix"]);
          $prix=$temp[1];
          $requete="SELECT * from `annonce` WHERE (`adresse` LIKE '".$adresse."' OR `ville` LIKE '".$ville."' OR `pays` LIKE '".$pays."') AND (`dispo_debut`<='".$_POST["arrive"]."' AND '".$_POST["arrive"]."'<= `dispo_fin`) AND (`dispo_debut`<='".$_POST["départ"]."' AND '".$_POST["départ"]."'<=`dispo_fin`) AND `prix`<'".$temp[1]."' AND `prix`>'".$temp[0]."'";
        }
      }
      else {
        $requete="SELECT * from `annonce` WHERE (`adresse` LIKE '".$adresse."' OR `ville` LIKE '".$ville."' OR `pays` LIKE '".$pays."') AND (`dispo_debut`<='".$_POST["arrive"]."' AND '".$_POST["arrive"]."'<= `dispo_fin`) AND (`dispo_debut`<='".$_POST["départ"]."' AND '".$_POST["départ"]."'<=`dispo_fin`)";
      }
    }

    elseif (empty($_POST["recherche"]) && isset($_POST["arrive"]) && isset($_POST["départ"])) {
      if (!empty($_POST["tri_prix"])) {
        if ($_POST["tri_prix"]==20) {
          $requete="SELECT * from `annonce` WHERE (`dispo_debut`<='".$_POST["arrive"]."' AND '".$_POST["arrive"]."'<= `dispo_fin`) AND (`dispo_debut`<='".$_POST["départ"]."' AND '".$_POST["départ"]."'<=`dispo_fin`) AND `prix`<='".$_POST["tri_prix"]."'";
        }
        elseif ($_POST["tri_prix"]==50) {
          $requete="SELECT * from `annonce` WHERE (`dispo_debut`<='".$_POST["arrive"]."' AND '".$_POST["arrive"]."'<= `dispo_fin`) AND (`dispo_debut`<='".$_POST["départ"]."' AND '".$_POST["départ"]."'<=`dispo_fin`) AND `prix`>='".$_POST["tri_prix"]."'";
        }
        elseif ($_POST["tri_prix"]==20.50) {
          $temp=explode(".",$_POST["tri_prix"]);
          $prix=$temp[1];
          $requete="SELECT * from `annonce` WHERE (`dispo_debut`<='".$_POST["arrive"]."' AND '".$_POST["arrive"]."'<= `dispo_fin`) AND (`dispo_debut`<='".$_POST["départ"]."' AND '".$_POST["départ"]."'<=`dispo_fin`) AND `prix`<'".$temp[1]."' AND `prix`>'".$temp[0]."'";
        }
      }
      else {
        $requete="SELECT * from `annonce` WHERE (`dispo_debut`<='".$_POST["arrive"]."' AND '".$_POST["arrive"]."'<= `dispo_fin`) AND (`dispo_debut`<='".$_POST["départ"]."' AND '".$_POST["départ"]."'<=`dispo_fin`)";
      }
    }

    elseif (!empty($_POST["recherche"]) && empty($_POST["arrive"]) && empty($_POST["départ"])) {
      if (!empty($_POST["tri_prix"])) {
        if ($_POST["tri_prix"]==20) {
          $requete="SELECT * from `annonce` WHERE (`adresse` LIKE '".$adresse."' OR `ville` LIKE '".$ville."' OR `pays` LIKE '".$pays."') AND `prix`<='".$_POST["tri_prix"]."'";
        }
        elseif ($_POST["tri_prix"]==50) {
          $requete="SELECT * from `annonce` WHERE (`adresse` LIKE '".$adresse."' OR `ville` LIKE '".$ville."' OR `pays` LIKE '".$pays."') AND `prix`>='".$_POST["tri_prix"]."'";
        }
        elseif ($_POST["tri_prix"]==20.50) {
          $temp=explode(".",$_POST["tri_prix"]);
          $prix=$temp[1];
          $requete="SELECT * from `annonce` WHERE (`adresse` LIKE '".$adresse."' OR `ville` LIKE '".$ville."' OR `pays` LIKE '".$pays."') AND `prix`<'".$temp[1]."' AND `prix`>'".$temp[0]."'";
        }
      }
      else {
      $requete="SELECT * from `annonce` WHERE (`adresse` LIKE '".$adresse."' OR `ville` LIKE '".$ville."' OR `pays` LIKE '".$pays."')";
      }
    }

    elseif (!empty($_POST["recherche"]) && !empty($_POST["arrive"]) && empty($_POST["départ"])) {
      if (!empty($_POST["tri_prix"])) {
        if ($_POST["tri_prix"]==20) {
          $requete="SELECT * from `annonce` WHERE (`adresse` LIKE '".$adresse."' OR `ville` LIKE '".$ville."' OR `pays` LIKE '".$pays."') AND ((`dispo_debut`<='".$_POST["arrive"]."' OR `dispo_debut`>='".$_POST["arrive"]."') AND '".$_POST["arrive"]."'<= `dispo_fin`) AND `prix`>='".$_POST["tri_prix"]."'";
        }
        elseif ($_POST["tri_prix"]==50) {
          $requete="SELECT * from `annonce` WHERE (`adresse` LIKE '".$adresse."' OR `ville` LIKE '".$ville."' OR `pays` LIKE '".$pays."') AND ((`dispo_debut`<='".$_POST["arrive"]."' OR `dispo_debut`>='".$_POST["arrive"]."') AND '".$_POST["arrive"]."'<= `dispo_fin`) AND `prix`>='".$_POST["tri_prix"]."'";
        }
        elseif ($_POST["tri_prix"]==20.50) {
          $temp=explode(".",$_POST["tri_prix"]);
          $prix=$temp[1];
          $requete="SELECT * from `annonce` WHERE (`adresse` LIKE '".$adresse."' OR `ville` LIKE '".$ville."' OR `pays` LIKE '".$pays."') AND ((`dispo_debut`<='".$_POST["arrive"]."' OR `dispo_debut`>='".$_POST["arrive"]."') AND '".$_POST["arrive"]."'<= `dispo_fin`) AND `prix`<'".$temp[1]."' AND `prix`>'".$temp[0]."'";
        }
      }
      else {
        $requete="SELECT * from `annonce` WHERE (`adresse` LIKE '".$adresse."' OR `ville` LIKE '".$ville."' OR `pays` LIKE '".$pays."') AND ((`dispo_debut`<='".$_POST["arrive"]."' OR `dispo_debut`>='".$_POST["arrive"]."') AND '".$_POST["arrive"]."'<= `dispo_fin`)";
      }
    }

    elseif (!empty($_POST["recherche"]) && empty($_POST["arrive"]) && !empty($_POST["départ"])) {
      if (!empty($_POST["tri_prix"])) {
        if ($_POST["tri_prix"]==20) {
          $requete="SELECT * from `annonce` WHERE (`adresse` LIKE '".$adresse."' OR `ville` LIKE '".$ville."' OR `pays` LIKE '".$pays."')  AND ((`dispo_debut`<='".$_POST["départ"]."' OR `dispo_debut`>='".$_POST["départ"]."')  AND '".$_POST["départ"]."'<=`dispo_fin`) AND `prix`>='".$_POST["tri_prix"]."'";
        }
        elseif ($_POST["tri_prix"]==50) {
          $requete="SELECT * from `annonce` WHERE (`adresse` LIKE '".$adresse."' OR `ville` LIKE '".$ville."' OR `pays` LIKE '".$pays."')  AND ((`dispo_debut`<='".$_POST["départ"]."' OR `dispo_debut`>='".$_POST["départ"]."')  AND '".$_POST["départ"]."'<=`dispo_fin`) AND `prix`>='".$_POST["tri_prix"]."'";
        }
        elseif ($_POST["tri_prix"]==20.50) {
          $temp=explode(".",$_POST["tri_prix"]);
          $prix=$temp[1];
          $requete="SELECT * from `annonce` WHERE (`adresse` LIKE '".$adresse."' OR `ville` LIKE '".$ville."' OR `pays` LIKE '".$pays."')  AND ((`dispo_debut`<='".$_POST["départ"]."' OR `dispo_debut`>='".$_POST["départ"]."')  AND '".$_POST["départ"]."'<=`dispo_fin`) AND `prix`<'".$temp[1]."' AND `prix`>'".$temp[0]."'";
        }
      }
      else {
        $requete="SELECT * from `annonce` WHERE (`adresse` LIKE '".$adresse."' OR `ville` LIKE '".$ville."' OR `pays` LIKE '".$pays."')  AND ((`dispo_debut`<='".$_POST["départ"]."' OR `dispo_debut`>='".$_POST["départ"]."')  AND '".$_POST["départ"]."'<=`dispo_fin`)";
      }
    }

    $result=@mysqli_query($idcom,$requete);
    $row=mysqli_num_rows($result);
    if ($row>0) {
      while($tab=mysqli_fetch_array($result)){
          $tab["pays"]=ucfirst($tab["pays"]);
          $tab["ville"]=ucfirst($tab["ville"]);
          $tab["type"]=ucfirst($tab["type"]);
          echo "<div class='choix'>";
          echo "<div><a href='in_annonce.php?=".$tab["idp"]."'><img class='image_choix' src='pictures/".$tab["photos"]."' alt='WOW2'></a></div>";
          echo "<p><table>";
          echo "<tr><th>Lieu: </th><td>".$tab["pays"]." , ".$tab["ville"]."</td></tr>";
          echo "<tr><th>Logement: </th><td>".$tab["type"]."</td></tr>";
          echo "<tr><th>Prix: </th><td>".$tab["prix"]."€/nuit</td></tr>";
          echo "</table></p>";
          echo "</div>";
      }
    }
    else {
      echo "Il n'y a pas de résultat";
    }
}

?>
</body>
</html>
