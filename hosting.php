<!-- Nom du binome BALI-CROISILLE -->
<?php
session_start();
include("connex.inc.php");
$idcom=connex("sharemyhouse","myparam");
mysqli_set_charset($idcom, "utf8");
if(isset($_SESSION["id"])){
  if (isset($_POST["submit"])) {
    if (!empty($_POST["type"]) && !empty($_POST["adresse"]) && !empty($_FILES["image"]) && !empty($_POST["ville"]) && !empty($_POST["pays"]) && !empty($_POST["debut"]) && !empty($_POST["fin"]) && !empty($_POST["prix"])) {
      $ext=array("png", "jpg", "jpeg", "gif");
      $file_ext=explode(".",$_FILES["image"]["name"]);
      $file_ext=end($file_ext);
      $taille_max=1000000;


      if (!in_array($file_ext,$ext)) {
        $erreur="Vous devez utiliser un fichier png, jpg, jpeg ou gif.";
      }
      if ($_FILES["image"]["size"] > $taille_max) {  //La taille max est de base 2MB sur le fichier php.ini
        $erreur="Le fichier est trop volumineux.";
      }
      if (!isset($erreur)) {
        $img=basename($_FILES["image"]["name"]);
        if (move_uploaded_file($_FILES["image"]["tmp_name"], "pictures/$img")) {
          $_POST["pays"]=strtolower($_POST["pays"]);
          $_POST["adresse"]=strtolower($_POST["adresse"]);      //On met tout en lower pour faciliter la recherche
          $_POST["type"]=strtolower($_POST["type"]);
          $_POST["ville"]=strtolower($_POST["ville"]);
          $requete="INSERT INTO `annonce` (`ids`, `photos`, `dispo_debut`,`dispo_fin`,`prix`, `type`, `adresse`, `ville`, `pays`,`description`) VALUES ('".$_SESSION["id"]."', '".$img."', '".$_POST["debut"]."', '".$_POST["fin"]."', '".$_POST["prix"]."', '".$_POST["type"]."', '".$_POST["adresse"]."','".$_POST["ville"]."', '".$_POST["pays"]."', '".$_POST["description"]."')";
          $result=@mysqli_query($idcom,$requete);
          if ($result) {
            $erreur="Votre annonce a bien été crée";
          }
        }
        else {
          $erreur="Il y a eu une erreur lors de l'upload, veuillez recommencer.";
        }

      }

    }
}
?>
<html>
  <head>
    <meta charset="utf-8">
    <title>Hosting</title>
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
      <h2>Devenir hôte</h2>
      <div class="2" align="center">
        <form method="post" enctype="multipart/form-data">
          <input type="file" name="image">
          <br>
          <br>
          <input type="text" name="type" placeholder="Type de logement" require>
          <br>
          <br>
          <input type="text" name="adresse" placeholder="Adresse du logement" required>
          <br>
          <br>
          <input type="text" name="ville" placeholder="Ville" required>
          <br><br>
          <input type="text" name="pays" placeholder="Pays" required>
          <br><br>
          Du: <input type="date" name="debut" required>
          <br><br>
          Au: <input type="date" name="fin" required>
          <br><br>
          <input type="tel" name="prix" maxlength="8" placeholder="Prix €/nuit" required>
          <br><br>
          <textarea name="description" rows="8" cols="60" placeholder="Description de l'annonce"></textarea>
          <br><br>
          <input type="submit" name="submit" value="Envoyer">
        </form>
      </div>
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
