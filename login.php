<?php include_once "header.php" ?>

<h1>Přihlásit se</h1>

<form id="registrationForm" class="registrationForm" action="processes/login.proc.php" method="post">
  <input type="text" name="email" placeholder="E-mail / uživatelské jméno">
  <input type="password" name="pwd" placeholder="Heslo">
  <button type="submit" name="submit">Přihlásit se</button>

<?php

  echo "<div class=\"loginErrors\">".PHP_EOL;
  if(preg_match("/emptyEmail/", @$_GET["errors"] )) {
      echo "<p>Zadej svůj e-mail.</p>".PHP_EOL;
    }
  if(preg_match("/emptyPwd/", @$_GET["errors"] )) {
      echo "<p>Zadej své heslo.</p>".PHP_EOL;
    }
  if(preg_match("/emailUnexisting/", @$_GET["errors"] )) {
      echo "<p>Zadaný e-mail není registrován.</p>".PHP_EOL;
    }
  if(preg_match("/unmatchedPasswords/", @$_GET["errors"] )) {
    echo "<p>Nesprávné heslo.</p>".PHP_EOL;
    }
  echo "</div>".PHP_EOL;

  ?>
  </form>

<?php include_once "footer.php" ?>