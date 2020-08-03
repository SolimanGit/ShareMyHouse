<!-- Nom du binome BALI-CROISILLE -->
<?php
session_start();
include("connex.inc.php");
$idcom=connex("sharemyhouse","myparam");
mysqli_set_charset($idcom, "utf8");
if(isset($_SESSION["id"])){
if ($_GET["dest"]==$_SESSION["id"]) {
  $temp=$_GET["expe"];
}
else {
  $temp=$_GET["dest"];
}
  if (isset($_POST["envoi"])) {
    if (!empty($_POST["message"])) {
      $message=htmlspecialchars($_POST["message"]);
      $requete="INSERT INTO `message` (`id_expe`,`id_dest`,`message`) VALUES ('".$_SESSION['id']."','".$temp."','".$message."')";
      $result=@mysqli_query($idcom,$requete);
      if ($result) {
        $erreur="Votre message a été envoyé.";
      }
    }
    else {
      $erreur="Vous devez renseignez tous les champs.";
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
    <title>Messages</title>
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
            <a class="link" href="reception.php"><i class="material-icons">local_post_office</i> Boîte de réception</a>
            <a class="link" href="deconnexion.php"><i class="material-icons">exit_to_app</i> Se déconnecter</a>
        </div>
        </div>
      </nav>
    </header>
    <?php
      $requete2="SELECT message,pseudo FROM `message`,`inscription` WHERE `id_dest` = '".$temp."' AND `id_expe` = '".$_SESSION['id']."' AND inscription.id=message.id_expe OR `id_expe` = '".$temp."' AND `id_dest` = '".$_SESSION['id']."' AND inscription.id=message.id_expe ORDER BY message.id";
      $result2=@mysqli_query($idcom,$requete2);
      echo "<div class='messages'>";
      while ($tab2=mysqli_fetch_array($result2)) {
        ?>
        <table>
          <tr><td><p><?= $tab2["pseudo"] ?> : <?= nl2br($tab2["message"]) ?></p></td></tr>  <!-- nl2br est utiliser pour garder les retour à la ligne dans le message -->
        </table>
        <br>
      <?php
      }
     ?>
         </div>
     <form method="post">
       <textarea name="message" rows="8" cols="80" required></textarea>
       <div class="submit_textearea"><input type="submit" name="envoi" value="Envoyer"></div>
     </form>
  </body>
</html>
<?php
}
else {
  header("Location: connexion.php");
}

if (isset($erreur)) {
?>
<p><strong><font color="red"><?php  echo $erreur ?></font></strong></p>
<?php
}
?>
