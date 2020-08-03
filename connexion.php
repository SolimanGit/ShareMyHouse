<!-- Nom du binome BALI-CROISILLE -->
<?php
session_start();
include("connex.inc.php");
$idcom=connex("sharemyhouse","myparam");
mysqli_set_charset($idcom, "utf8");
if (isset($_POST["submitconnect"])) {
  $pseudoconnect= htmlspecialchars($_POST["pseudoconnect"]);
  $mdpconnect=sha1($_POST["mdpconnect"]);
  if (!empty($mdpconnect) && !empty($pseudoconnect)){
    setcookie("pseudo",$_POST["pseudoconnect"],time()+(3600));   //Initialisation du cookie pour 1h
    $requete="SELECT * FROM `inscription` WHERE `pseudo` LIKE '".$pseudoconnect."' AND `mdp` LIKE '".$mdpconnect."'";
    $result=@mysqli_query($idcom,$requete);
    $resultbis=mysqli_num_rows($result);
    if ($resultbis==1) {                          //Vérification, si il y a un résultat
      $tab=mysqli_fetch_array($result);
      $_SESSION["id"]=$tab["id"];
      $_SESSION["pseudo"]=$tab["pseudo"];
      $_SESSION["mail"]=$tab["mail"];
      header("Location: profil.php?id=".$_SESSION["id"]);   // Je créer des sessions de l'utilisateur pour plus tard et je change de page
    }
    else {
      $erreur="Mauvais identifiants";
    }
  }
  else {
    $erreur="Vous devez renseignez tous les champs.";
  }
}
?>
<html>
<head>
  <title>Connexion</title>
  <meta charset="utf-8">
  <link rel="stylesheet" href="css/header.css">
  <link rel="stylesheet" href="css/style.css">                                            <!--Fichiers CSS -->
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
          <a href="recherche2.php"><h1 id="logo">ShareMyhouse</h1></a>                    <!-- Création de la bannière -->
        </div>
        <div class="menu_right">
          <a class="link"href="inscription.php"><i class="material-icons">assignment</i> S'inscrire</a>
      </div>
      </div>
    </nav>
  </header>
  <div align="center">
    <h2>Connexion</h2>
    <br>
  <form method="post">
    <table>
      <tr>
        <td>
          <input type="text" name="pseudoconnect" placeholder="Pseudo" <?php if(isset($_COOKIE["pseudo"])){?>value="<?=$_COOKIE["pseudo"]?>"<?php } ?> required/>
        </td>
      </tr>
      <tr>
        <td>
          <input type="password" name="mdpconnect" placeholder="Mot de passe" required/>
        </td>
      </tr>
    </table>
    <br>
      <input type="submit" name="submitconnect" value="Je me connecte"/>



  </form>
  <?php
    if (isset($erreur)) {                     // Mise en place d'une erreur "universel" avec une variable
      echo '<p>';
      echo '<strong><font color="red">'.$erreur.'</font></strong>';
      echo '</p></body>';
    }
  ?>
</div>
</body>
</html>
