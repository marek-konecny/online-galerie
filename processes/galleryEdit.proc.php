<?php
session_start();
$currentUser = $_SESSION["loggedno"];

require_once "databaseHandler_gallery.proc.php";
require_once "functions.proc.php";

if(($picsNo = $_POST["picsno"]) === NULL){header("location: ../gallery.php?errors=unauthorizedAccess"); exit();};
$loggedno = @$_SESSION["loggedno"] ?: 'NULL';

$sql = "SELECT * FROM pics WHERE picsOwner = " . $loggedno . " AND picsNo = " . $picsNo;

$picsResult = $conn -> query($sql);
$picsResultRow = $picsResult -> fetch_assoc();

if ($picsResultRow === NULL) {
  header("location: ../gallery.php?errors=unauthorizedAccess");
  exit();
}

if (isset($_POST["cancel"])) {
  header("location: ../galleryImage.php?picsNo=".$picsNo);
  exit();
}
else if (isset($_POST["upload"])){
  $title = $_POST["title"];
  $desc = $_POST["desc"];
  $tags = $_POST["tags"];
  $isPrivate = (isset($_POST["isPrivate"]));


  editPic($conn, $picsNo, $isPrivate, $title, $desc, $tags);

}
else {
  header("location: ../gallery.php?errors=formSubmit");
  exit();
}


