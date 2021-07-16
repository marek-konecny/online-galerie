<?php include_once "header.php" ?>

<h1>Galerie</h1>

<?php
require_once "processes/databaseHandler_gallery.proc.php";
$target_file = $_GET["picsPath"];

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