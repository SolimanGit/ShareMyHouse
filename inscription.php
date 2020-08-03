<!-- Nom du binome BALI-CROISILLE -->
<?php
include("connex.inc.php");
$idcom=connex("sharemyhouse","myparam");
mysqli_set_charset($idcom, "utf8");
if (isset($_POST["submit"])) {
  $pseudoconnect= htmlspecialchars($_POST["pseudo"]);
  $pseudoconnect= htmlspecialchars($_POST["mail"]);
  $mdp=sha1($_POST["mdp"]);
  if (!empty($_POST["pseudo"]) && !empty($_POST["mail"]) && !empty($_POST["mdp"])) {
    $requete2="SELECT * FROM `inscription` WHERE `pseudo`LIKE '".$_POST['pseudo']."' OR `mail` LIKE '".$_POST['mail']."'";
    $result2=@mysqli_query($idcom,$requete);
    $bis=mysqli_num_rows($result2);
    if ($bis==0) {
      $requete="INSERT INTO `inscription` (`pseudo`,`mail`,`mdp`,`evaluation`,`diviseur`) VALUES ('".$_POST['pseudo']."','".$_POST['mail']."','".$mdp."','0','0')";
      $result=@mysqli_query($idcom,$requete);
      if ($result) {
        header("Location: connexion.php");
      }
      else {
        $erreur="Une erreur s'est produite veuillez recommencer";
      }
    }
    else {
      $erreur="Le mail ou le Pseudo existent déjà veuillez en définir un nouveau.";
    }

  }
  else {
    $erreur="Tous les champs doivent être remplis";
    header("Location: inscription.php?error=emptyfieldspseudomailmdp");
  }
}

?>
<html>
<head>
  <style>
  body{
    background-image: url('autre/background.jpg');
    background-repeat: no-repeat;
    background-attachment: fixed;
    background-position: 50% 40%;
  }
  </style>
  <title>Inscription</title>
  <meta charset="utf-8">
  <link rel="stylesheet" href="css/header.css">
  <link rel="stylesheet" href="css/style.css">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons"rel="stylesheet">
</head>
<body>
  <header>
    <nav class="menu">
      <div class="menu_bis">
        <div class="menu_left">
          <a href="recherche2.php"><h1 id="logo">ShareMyhouse</h1></a>
        </div>
        <div class="menu_right">
          <a class="link" href="connexion.php"><i class="material-icons">person</i> Connexion</a>
      </div>
      </div>
    </nav>
  </header>
  <div align="center">
    <h2>Incription</h2>
    <br>
  <form method="post">
    <table>
      <tr>
        <td>
          <input type="text" name="pseudo" placeholder="Pseudo" required>
        </td>
      </tr>
      <tr>
        <td>
          <input type="email" name="mail" placeholder="Mail" required>
        </td>
      </tr>
      <tr>
        <td>
          <input type="password" name="mdp" placeholder="Mot de passe" required>
        </td>
      </tr>
    </table>
    <br>
    <input type="submit" name="submit" value="Je m'inscris"/>
  </form>
  <?php
    if (isset($erreur)) {
      echo '<p>';
      echo '<strong><font color="red">'.$erreur.'</font></strong>';
      echo '</p></body>';
    }
  ?>
</div>
</body>
</html>
