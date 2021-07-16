<?php include_once "header.php" ?>

<h1>Registrace</h1>

<form id="registrationForm" class="registrationForm" action="processes/registration.proc.php" method="post">
  <input type="text" name="fullname" placeholder="Jméno a příjmení" class="registrationField">
  <input type="text" name="email" placeholder="E-mail">
  <input type="text" name="uid" placeholder="Uživatelské jméno">
  <div id="passwordFields">
  <input type="password" name="pwd" placeholder="Heslo">
  <input type="password" name="pwdRepeat" placeholder="Heslo ještě jednou">
  </div>
  <button type="submit" name="submit">Registrovat</button>


<?php

echo "<div class=\"loginErrors\">".PHP_EOL;
if(preg_match("/emptyInput/", @$_GET["errors"] )) {
    echo "<p>Všechna pole jsou povinná.</p>".PHP_EOL;
  }
if(preg_match("/invalidEmail/", @$_GET["errors"] )) {
    echo "<p>Zadej platnou e-mailovou adresu.</p>".PHP_EOL;
  }
if(preg_match("/emailExists/", @$_GET["errors"] )) {
    echo "<p>Tento e-mail je již zaregistrován.</p>".PHP_EOL;
  }
if(preg_match("/invalidUid/", @$_GET["errors"] )) {
    echo "<p>Povolené znaky pro uživatelské jméno jsou malá písmena a - z a číslice 0 - 9.</p>".PHP_EOL;
  }
if(preg_match("/longUid/", @$_GET["errors"] )) {
    echo "<p>Uživatelské jméno může být dlouhé maximálně 15 znaků.</p>".PHP_EOL;
  }
if(preg_match("/uidExists/", @$_GET["errors"] )) {
    echo "<p>Uživatelské jméno je již použito.</p>".PHP_EOL;
  }
if(preg_match("/shortPassword/", @$_GET["errors"] )) {
  echo "<p>Heslo musí být dlouhé alespoň 6 znaků.</p>".PHP_EOL;
  }
if(preg_match("/unmatchedPasswords/", @$_GET["errors"] )) {
  echo "<p>Hesla se neshodují.</p>".PHP_EOL;
  }
if(preg_match("/zero/", @$_GET["errors"] )) {
  echo "<p id=\"succesfulRegistration\">Registrace proběhla úspěšně! <a href=\"login.php\">Přihlásit se</a></p>".PHP_EOL;
  }
echo "</div>".PHP_EOL;

?>
</form>


<?php include_once "footer.php" ?>