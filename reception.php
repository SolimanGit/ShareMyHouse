<!-- Nom du binome BALI-CROISILLE -->
<?php
session_start();
include("connex.inc.php");
$idcom=connex("sharemyhouse","myparam");
mysqli_set_charset($idcom, "utf8");
if(isset($_SESSION["id"])){
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
    <title>Boîte de réception</title>
  </head>
  <body>
    <header>
      <nav class="menu">
        <div class="menu_bis">
          <div class="menu_left">
            <a href="recherche2.php"><h1 id="logo">ShareMyhouse</h1></a>
          </div>
          <div class="menu_right">
            <a class="link" href="profil.php"><i class="material-icons">account_circle</i> Profil</a>
            <a class="link" href="deconnexion.php"><i class="material-icons">exit_to_app</i> Se déconnecter</a>
        </div>
        </div>
      </nav>
    </header>
    <div align="center">
      <h2>Conversations</h2>
    </div>

    <?php
    $requete3="SELECT DISTINCT inscription.pseudo, message.id_dest, message.id_expe FROM message,inscription WHERE id_dest = '".$_SESSION["id"]."' AND inscription.id=message.id_expe OR id_expe = '".$_SESSION["id"]."' AND inscription.id=message.id_dest GROUP BY inscription.pseudo ";
    $result3=@mysqli_query($idcom,$requete3);
    if (!$result3) {
      echo "Une erreur s'est produite.";
    }
    while ($tab3=mysqli_fetch_array($result3)) {
      echo '<div class="converse" align="center">';
      echo '<p>';
      echo '<a href="messagefocus.php?dest='.$tab3["id_dest"].'&expe='.$tab3["id_expe"].'">Messages de '.$tab3["pseudo"].'</a><br><br>';
      echo '</p>';
      echo '</div>';
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
