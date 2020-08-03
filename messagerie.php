<!-- Nom du binome BALI-CROISILLE -->
<?php
session_start();
include("connex.inc.php");
$idcom=connex("sharemyhouse","myparam");
mysqli_set_charset($idcom, "utf8");
if(isset($_SESSION["id"])){
  if (isset($_POST["envoi"])) {
    if (!empty($_POST["message"])) {
      $message=htmlspecialchars($_POST["message"]);
      $requete="INSERT INTO `message` (`id_expe`,`id_dest`,`message`) VALUES ('".$_SESSION['id']."','".$_GET['dest']."','".$message."')";
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
    <title>Messagerie</title>
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
    <h3>Envoyer un message à <?php echo $_SESSION["pseudo_dest"] ?></h3>
    <form method="post">
      <textarea name="message" rows="8" cols="80" placeholder="Écrivez votre message" ></textarea>
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
  echo '<p>';
  echo '<strong><font color="red">'.$erreur.'</font></strong>';
  echo '</p></body>';
}
?>
