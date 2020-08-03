<!-- Nom du binome BALI-CROISILLE -->
<?php
session_start();
include("connex.inc.php");
$idcom=connex("sharemyhouse","myparam");
mysqli_set_charset($idcom, "utf8");
if(isset($_SESSION["id"])){
  $requete2="SELECT * FROM `inscription` WHERE `id` = '".$_SESSION['id']."'";
  $result2=@mysqli_query($idcom,$requete2);
  $tab2=mysqli_fetch_array($result2);
  if ($tab2["diviseur"]==0) {
    $equation=0;
  }
  else {
    $equation=$tab2["evaluation"]/$tab2["diviseur"];
    round($equation,1,PHP_ROUND_HALF_EVEN);
  }
  if (isset($_POST["button"])) {
    header("Location: recherche2.php?id=".$_SESSION["id"]);
  }
?>
<html>
  <head>
    <meta charset="utf-8">
    <style>
    body{
      background-image: url('autre/stripes-light.png');
    }
    </style>
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons"rel="stylesheet">
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
            <a class="link" href="edition_profil.php"><i class="material-icons">create</i> Editer le profil</a>
            <a class="link" href="reception.php"><i class="material-icons">local_post_office</i> Boîte de réception</a>
            <a class="link" href="hosting.php"><i class="material-icons">local_hotel</i> Devenir hôte</a>
            <a class="link" href="deconnexion.php"><i class="material-icons">exit_to_app</i> Se déconnecter</a>
        </div>
        </div>
      </nav>
    </header>
    <div class="1" align="center">
      <h2>Profil de <?php echo $_SESSION["pseudo"]; ?></h2>
      <br><br>
      <table classe="tabprofil">
        <tr>
          <td><p>Mail: </p></td>
          <td><p><?php echo $_SESSION["mail"]?></p></td>
        </tr>
        <tr>
          <td><p>Pseudo:</p></td>
          <td><p><?php echo $_SESSION["pseudo"]?></p></td>
        </tr>
      </table>
      <br><br>
      <?php
      echo "<h2>Note : ".$equation."/5</h2><br>";
      ?>
    </div>

      <?php
      $requete="SELECT * FROM `annonce` WHERE `ids` = '".$_SESSION['id']."' ORDER BY `idp` DESC";
      $result=@mysqli_query($idcom,$requete);
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

  </body>
</html>
<?php
}
else {
  header("Location: connexion.php");
}
if (isset($erreur)) {
  echo '<p>';
  echo '<strong><font color="red">'.$erreur.'</font></strong>';
  echo '</p></body>';
}
?>
