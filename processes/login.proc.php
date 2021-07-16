<?php
require_once "databaseHandler.proc.php";
require_once "functions.proc.php";

if (isset($_POST["submit"])) {

  $email = strtolower($_POST["email"]);
  $pwd = $_POST["pwd"];

  $header = "location: ../login.php?errors=";
  $err = FALSE;

  if (empty($email)){
    $header .= "-emptyEmail-"; $err = TRUE;
  }
  if (empty($pwd)) {
    $header .= "-emptyPwd-"; $err = TRUE;
  }

  if ($err) {
    header($header);
    exit();
  }

  loginUser($conn, $email, $pwd);

}
else {
  header("location: ../login.php");
  exit();
}