<?php
session_start();
$currentUser = $_SESSION["loggedno"];

require_once "databaseHandler_gallery.proc.php";
require_once "functions.proc.php";
require_once "reSmushAPI.proc.php";

$tmpPath = "../" . $_POST["tmppath"];
$filePath = "../uploads/" . basename($tmpPath);


if (isset($_POST["cancel"])) {
  unlink($tmpPath);

  header("location: ../gallery.php");
  exit();
}
else if (isset($_POST["upload"])){
  $title = $_POST["title"];
  $desc = $_POST["desc"];
  $tags = $_POST["tags"];
  $isPrivate = (isset($_POST["isPrivate"]));


  if (rename($tmpPath, $filePath)) {
    reSmush($filePath);
    uploadPic($conn, $currentUser, $isPrivate, basename($filePath), $title, $desc, $tags);
  }
  else {
    header("location: ../gallery.php?errors=fileRename");
    exit();
  }
}
else {
  header("location: ../gallery.php?errors=formSubmit");
  exit();
}


