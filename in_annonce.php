<!-- Nom du binome BALI-CROISILLE -->
<?php
session_start();
include("connex.inc.php");
$idcom=connex("sharemyhouse","myparam");
mysqli_set_charset($idcom, "utf8");
  $temp=explode("=",$_SERVER["REQUEST_URI"]);
  $idp=$temp[1];

  $requete="SELECT * FROM annonce,inscription WHERE annonce.idp='".$idp."' AND annonce.ids=inscription.id ";
  $result=@mysqli_query($idcom,$requete);
  $tab=mysqli_fetch_array($result);
  $_SESSION["pseudo_dest"]=$tab["pseudo"];
if (isset($_POST["submitreserve"])) {
  if (isset($_POST["reserve1"]) && isset($_POST["reserve2"]) && isset($_SESSION["id"])) {
    $requete2="SELECT * FROM `reservation` WHERE reserver_idp='".$idp."' AND `date_debut_r` BETWEEN '".$_POST['reserve1']."' AND '".$_POST['reserve2']."' AND `date_fin_r` BETWEEN '".$_POST['reserve1']."' AND '".$_POST['reserve2']."'";
    $result2=@mysqli_query($idcom,$requete2);
    $bis=mysqli_num_rows($result2);
    if ($bis==0) {
      $requete="INSERT INTO `reservation` (`ids`,`reserver_idp`,`date_debut_r`,`date_fin_r`) VALUES ('".$_SESSION['id']."','".$idp."','".$_POST['reserve1']."','".$_POST['reserve2']."')";
      $result=@mysqli_query($idcom,$requete);
      $erreur="Félicitation vous venez de réserver votre logement.";
    }
    else {
      $erreur="Dommage cette date de réservation est déjà prise.";
    }

  }
  else {
    $erreur="Vous devez vous connecter pour réserver";
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
    <title>Annonce</title>
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
                echo '<a class="link" href="reception.php"><i class="material-icons">local_post_office</i> Boîte de réception</a>';
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
      <h2>Annonce de <?php echo $tab["pseudo"]; ?></h2>
    </div>
    <br>
    <a href="messagerie.php?dest=<?php echo $tab["id"] ?>">Envoyer un message à l'host</a><br>
    <a href="profiluser.php?id=<?= $tab["id"] ?>" target="_blank">Profil de l'hôte: <?= $tab["pseudo"] ?></a>
    <br>
    <div align="center">
      <?php
      echo "<img class='image' src='pictures/".$tab["photos"]."' alt='wow'>"; // le css ne marche pas
      ?>
    </div>
    <br><br>
      <table align="center" class="intable">
        <tr>
          <td>
            <?php echo ucfirst($tab["pays"]); ?>
          </td>
        </tr>
        <tr>
          <td>
            <?php echo ucfirst($tab["ville"]); ?>
          </td>
        </tr>
        <tr>
          <td>
            <?php echo ucfirst($tab["adresse"]); ?>
          </td>
        </tr>
        <tr>
          <td>
            <?php echo ucfirst($tab["type"]); ?>
          </td>
        </tr>
        <tr>
          <td>
            <?php echo $tab["prix"]; ?> €/nuit
          </td>
        </tr>
        <tr>
          <td>
              <?php echo $tab["description"]; ?>
          </td>
        </tr>
          <?php
            if (isset($_SESSION["id"]) && $_SESSION["id"] != $tab["ids"] || !isset($_SESSION["id"])) {
           ?>
        <tr>
          <td>
              <h4>Dates de réservations disponible:</h4>
          </td>
        </tr>
        <tr>
          <td>
              Du: <?php echo $tab["dispo_debut"]; ?> Au: <?php echo $tab["dispo_fin"]; ?>
          </td>
        </tr>
        <tr>
          <td>
            <form class="tdform" method="post">
              <label>Veuillez choisir la date d'arrivée :
              <input type="date" name="reserve1" min="<?php echo $tab["dispo_debut"] ?>" max="<?php echo $tab["dispo_fin"] ?>"required>
              </label>
          </td>
        </tr>
        <tr>
          <td>
            <label>Veuillez choisir la date de départ :
              <input type="date" name="reserve2" min="<?php echo $tab["dispo_debut"] ?>" max="<?php echo $tab["dispo_fin"] ?>"required>
            </label>
          </td>
        </tr>
        <tr>
          <td>
              <input type="submit" name="submitreserve" value="Réserver">
          </td>
        </tr>
      <?php
        }
      ?>
    </form>
  </table>



  </body>
</html>
<?php
if (isset($erreur)) {
  echo '<p>';
  echo '<strong><font color="red">'.$erreur.'</font></strong>';
  echo '</p></body>';
}
?>
