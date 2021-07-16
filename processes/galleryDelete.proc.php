<?php
session_start();
$currentUser = $_SESSION["loggedno"];

require_once "databaseHandler_gallery.proc.php";
require_once "functions.proc.php";

$picsNo = $_GET["picsNo"];
$loggedno = @$_SESSION["loggedno"] ?: 'NULL';

$sql = "SELECT * FROM pics WHERE picsOwner = " . $loggedno . " AND picsNo = " . $picsNo;

$picsResult = $conn -> query($sql);
$picsResultRow = $picsResult -> fetch_assoc();

if ($picsResultRow === NULL) {
  header("location: ../gallery.php?errors=unauthorizedAccess");
  exit();
}

deletePic($conn, $picsNo);