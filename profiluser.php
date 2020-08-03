<!-- Nom du binome BALI-CROISILLE -->
<?php
session_start();
include("connex.inc.php");
$idcom=connex("sharemyhouse","myparam");
mysqli_set_charset($idcom, "utf8");
$requete="SELECT * FROM `annonce` WHERE `ids` = '".$_GET['id']."' ORDER BY `idp` DESC";
$result=@mysqli_query($idcom,$requete);

$requete2="SELECT * FROM `inscription` WHERE `id` = '".$_GET['id']."'";
$result2=@mysqli_query($idcom,$requete2);
$tab2=mysqli_fetch_array($result2);

if(isset($_POST["submit"])){
  if (isset($_SESSION["id"])) { //Conditions pour la notation
if($tab2["evaluation"]==0 && $tab2["diviseur"]==0){
        $div=1;
        $eval=$_POST["note"];
        $requete3="UPDATE inscription SET diviseur=".$div." WHERE ID=".$_GET['id'].";";
        $result3=@mysqli_query($idcom,$requete3);
        $requete4="UPDATE inscription SET evaluation=".$eval." WHERE ID=".$_GET['id'].";";
        $result4=@mysqli_query($idcom,$requete4);
    }
    else{
        $div=$tab2["diviseur"]+1;
        $requete5="UPDATE inscription SET diviseur=".$div." WHERE ID=".$_GET['id'].";";
        $result5=@mysqli_query($idcom,$requete5);
        $eval=$tab2["evaluation"]+$_POST["note"];
        $requete6="UPDATE inscription SET evaluation=".$eval." WHERE ID=".$_GET['id'].";";
        $result6=@mysqli_query($idcom,$requete6);
    }
  }
  else {
    $erreur="Vous devez être connecté.";
  }
}

?>
<html>
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons"rel="stylesheet">
    <style>
    body{
      background-image: url('autre/stripes-light.png');
    }
    </style>
    <title>Profil</title>
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
    <div class="1" align="center">
      <h2>Profil de <?php echo $tab2["pseudo"] ?></h2>
      <br>
      Mail: <?php echo $tab2["mail"] ?>
      <br>
    </div>

    <div class="eval" align="center">
    <?php
    if ($tab2["diviseur"]==0) {
      $equation=0;
    }
    else {
      $equation=$tab2["evaluation"]/$tab2["diviseur"];
      round($equation,1,PHP_ROUND_HALF_EVEN);
    }
    echo "<h2>Note : ".$equation."/5</h2><br>";
    echo "Évaluer cette personne :
      <form action='profiluser.php?id=".$tab2["id"]."' method='post'>
        <select name='note'>
          <option value='0'>0</option>
          <option valeur='1' >1</option>
          <option valeur='2'>2</option>
          <option valeur='3'>3</option>
          <option valeur='4'>4</option>
          <option valeur='5'>5</option>
        </select>
      <input type='submit' name='submit' value='Evaluer'>
      </form>";
    ?>
  </div>

    <div>
      <?php
      if (!$result) {
        $erreur="ERROR SQL";
      }
      else {
        while ($tab=mysqli_fetch_array($result)) {
          $tab["adresse"]=ucfirst($tab["adresse"]);
          $tab["type"]=ucfirst($tab["type"]);
          echo "<div class='choix'>";
          echo "<div><a href='in_annonce.php?=".$tab["idp"]."'><img class='image_choix' src='pictures/".$tab["photos"]."' alt='OK'></a></div>";
          echo "<p><table>";
          echo "<tr><th>Adresse: </th><td>".$tab['adresse']."</td></tr>";
          echo "<tr><th>Logement: </th><td>".$tab['type']."</td></tr>";
          echo "</table></p>";
          echo "</div>";
        }
    }

      ?>
    </div>
  </body>
</html>
<?php

if (isset($erreur)) {
  echo '<p>';
  echo '<strong><font color="red">'.$erreur.'</font></strong>';
  echo '</p></body>';
}
?>
