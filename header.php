<?php session_start(); ?>

<!DOCTYPE html>
<html lang="cz" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Chleba bez hnětení</title>

    <link rel="stylesheet" type="text/css" href="style/reset.css">
    <link rel="stylesheet" type="text/css" href="style/style.css">

    <link rel="icon" href="style/favicon.png">

  </head>
  <body>

    <div class="navbar">
      <ul>

        <li><a href="gallery.php">Galerie</a></li>
        <?php
        if (!isset($_SESSION["loggeduid"])) {
          echo "<li><a href=\"registration.php\">Registrace</a></li>";
          echo "<li><a href=\"login.php\">Přihlášení</a></li>";
        }
        else {
          echo "<li><a href=\"processes/logout.proc.php\">Odhlásit se</a></li>";
          echo "</ul>";
          echo "<p id=\"loggedUser\">Přihlášen/a ".$_SESSION["loggeduid"]."</p>";
        }
     ?>
    </div>
    <script src="js/navbar.js"></script>

    <div class="content">