<?php include_once "header.php" ?>

<h1>Nahrát obrázek</h1>

<?php
require_once "processes/databaseHandler_gallery.proc.php";

$uploadName = $_FILES["fileToUpload"]["name"];
$allowedFormats = array("jpg", "png", "jpeg", "gif");

$result = $conn->query("SELECT * FROM pics ORDER BY picsNo DESC LIMIT 1");
$row = $result->fetch_assoc();
$newPicId = $row["picsNo"] + 1;


$target_dir = "tmp/";
$target_file = $target_dir . $newPicId . "." . strtolower(pathinfo($uploadName, PATHINFO_EXTENSION));
$uploadOk = TRUE;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);


$header = "location: galleryUploadForm.php?errors=";
$err = FALSE;

// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
  if($check = getimagesize($_FILES["fileToUpload"]["tmp_name"])) {
    $err = FALSE;
  }
  else {
    $header .="-fileNotImg-";
    $err = TRUE;
  }
}

// Check file size
if ($_FILES["fileToUpload"]["size"] > 5000000) {
  $header .="-fileTooBig-";
  $err = TRUE;
}

// Allow certain file formats
if(!in_array($imageFileType, $allowedFormats)) {
  $header .="-formatUnallowed-";
  $err = TRUE;
}

if ($err) {
  header($header);
  exit();
}

move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file);
// if everything is ok, try to upload file
?>

<div id="imageUploadUI">

<?php echo "<img src=\"".$target_file."\">"; ?>

<form id="registrationForm" action="processes/galleryUpload.proc.php" method="post">
  <input type="hidden" name="tmppath" value="<?php echo $target_file; ?>">
  <input type="text" name="title" placeholder="Titulek">
  <input type="text" name="desc" placeholder="Popisek">
  <input type="text" name="tags" placeholder="Tagy">
  <div id="privateCheckboxLabel">
    <input type="checkbox" name="isPrivate" id="isPrivate" checked>
    <label for="isPrivate">Soukromý obrázek</label>
  </div>
  <button type="submit" name="upload">Nahrát</button>
  <button type="submit" name="cancel">Zrušit</button>
</form>

</div>



<?php include_once "footer.php" ?>