<!-- Nom du binome BALI-CROISILLE -->
<?php
session_start();
include("connex.inc.php");
$idcom=connex("sharemyhouse","myparam");
mysqli_set_charset($idcom, "utf8");
if(isset($_SESSION["id"])){
  if (isset($_POST["submit"])) {

    if (isset($_POST["newpseudo"]) && !empty($_POST["newpseudo"]) && $_POST["newpseudo"] != $_SESSION["pseudo"]) {
      $newpseudo=htmlspecialchars($_POST["newpseudo"]);
      $requete="UPDATE `inscription` SET `pseudo` = '".$newpseudo."' WHERE `inscription`.`id` = '".$_SESSION['id']."'";
      $result=@mysqli_query($idcom,$requete);
      $_SESSION["pseudo"]=$_POST["newpseudo"];
      header("Location: profil.php?id=".$_SESSION["id"]);
    }

    if (isset($_POST["newmail"]) && !empty($_POST["newmail"]) && $_POST["newmail"] != $_SESSION["mail"]) {
      $newmail=htmlspecialchars($_POST["newmail"]);
      $requete="UPDATE `inscription` SET `mail` = '".$newmail."' WHERE `inscription`.`id` = '".$_SESSION['id']."'";
      $result=@mysqli_query($idcom,$requete);
      $_SESSION["mail"]=$_POST["newmail"];
      header("Location: profil.php?id=".$_SESSION["id"]);
    }

    if (isset($_POST["newmdp"]) && !empty($_POST["newmdp"]) && isset($_POST["newmdpbis"]) && !empty($_POST["newmdpbis"])) {
      $newmdp=sha1($_POST["newmdp"]);
      $newmdpbis=sha1($_POST["newmdpbis"]);
        if ($newmdp == $newmdpbis) {
          $requete="UPDATE `inscription` SET `mdp` = '".$newmdp."' WHERE `inscription`.`id` = '".$_SESSION['id']."'";
          $result=@mysqli_query($idcom,$requete);
          $_SESSION["mdp"]=$_POST["newmdp"];
          header("Location: profil.php?id=".$_SESSION["id"]);
        }
        else {
          $erreur="Les mots de passes ne correspondent pas.";
        }
    }

}
?>
<html>
  <head>
    <meta charset="utf-8">
    <title>Edition de profil</title>
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons"rel="stylesheet">
    <style>
    body{
      background-image: url('autre/stripes-light.png');
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
            <a class="link" href="profil.php"><i class="material-icons">account_circle</i> Profil</a>
            <a class="link" href="deconnexion.php"><i class="material-icons">exit_to_app</i> Se déconnecter</a>
        </div>
        </div>
      </nav>
    </header>
    <div align="center">
      <h2>Edition du profil de <?php echo $_SESSION["pseudo"]; ?></h2>
      <form method="post">
      <br><br>
      <input type="text" name="newpseudo" placeholder="Nouveau pseudo" required/>
      <br><br>
      <input type="email" name="newmail" placeholder="Nouveau mail" required/>
      <br><br>
      <input type="password" name="newmdp" placeholder="Nouveau mot de passe" required/>
      <br><br>
      <input type="password" name="newmdpbis" placeholder="Confirmation du mot de passe" required/>
      <br><br>
      <input type="submit" name="submit" value="Mettre à jour le profil"/>
    </form>
    </div>
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
