<?php
require_once "databaseHandler.proc.php";
require_once "functions.proc.php";

if (isset($_POST["submit"])) {

  $name = $_POST["fullname"];
  $email = strtolower($_POST["email"]);
  $uid = strtolower($_POST["uid"]);
  $pwd = $_POST["pwd"];
  $pwdRepeat = $_POST["pwdRepeat"];

  $header = "location: ../registration.php?errors=";
  $err = FALSE;

  if (emptyInputRegistration($name, $email, $uid, $pwd, $pwdRepeat)) {
    $header .= "-emptyInput-"; $err = TRUE;
  }
  if (invalidUid($uid)) {
    $header .= "-invalidUid-"; $err = TRUE;
  }
  if (strlen($uid) > 15) {
    $header .= "-longUid-"; $err = TRUE;
  }
  if (uidExists($conn, $uid)) {
    $header .= "-uidExists-"; $err = TRUE;
  }
  if (invalidEmail($email)) {
    $header .= "-invalidEmail-"; $err = TRUE;
  }
  if (emailExists($conn, $email)) {
    $header .= "-emailExists-"; $err = TRUE;
  }
  if (strlen($pwd) < 6) {
    $header .= "-shortPassword-"; $err = TRUE;
  }
  if ($pwd !== $pwdRepeat) {
    $header .= "-unmatchedPasswords-"; $err = TRUE;
  }


  if ($err) {
    header($header);
    exit();
  }
  else {
    createUser($conn, $name, $email, $uid, $pwd);
  }

}
else {
  header("location: ../registration.php");
  exit();
}