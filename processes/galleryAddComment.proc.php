<?php
session_start();
$currentUserNo = $_SESSION["loggedno"];
$currentUserUid = $_SESSION["loggeduid"];

require_once "databaseHandler_gallery.proc.php";
require_once "functions.proc.php";


if (isset($_POST["uploadcomment"])){
  $picsNo = $_POST["picsno"];
  $commentText = $_POST["commenttext"];

  if (strlen($commentText)) {
    addComment($conn, $picsNo, $currentUserUid, $commentText);
  }
  else {
    header("location: ../galleryImage.php?picsNo=".$picsNo."&errors=emptyComment");
    exit();
  }
}
else {
  header("location: ../galleryImage.php?errors=unauthorizedAccess");
  exit();
}