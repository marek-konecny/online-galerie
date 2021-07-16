<?php include_once "header.php" ?>

<?php
require_once "processes/databaseHandler_gallery.proc.php";

$picsNo = $_GET["picsNo"];
$loggedno = @$_SESSION["loggedno"] ?: 'NULL';

$sql = "SELECT * FROM pics WHERE picsOwner = $loggedno AND picsNo = $picsNo AND picsStatus = 'enabled'";
$picsResult = $conn -> query($sql);
$picsResultRow = $picsResult -> fetch_assoc();

if ($picsResultRow === NULL) {
  header("location: gallery.php?errors=unauthorizedAccess");
  exit();
}

$target_file = "uploads/".$picsResultRow["picsPath"];
?>

<div id="imageUploadUI">

<?php echo "<img src=\"".$target_file."\">"; ?>

<form id="registrationForm" action="processes/galleryEdit.proc.php" method="post">
  <?php
  echo "<input type=\"hidden\" name=\"picsno\" value=".$picsResultRow["picsNo"].">".PHP_EOL;
  echo "<input type=\"text\" name=\"title\" placeholder=\"Titulek\" value=\"".$picsResultRow["picsTitle"]."\">".PHP_EOL;
  echo "<input type=\"text\" name=\"desc\" placeholder=\"Popisek\" value=\"".$picsResultRow["picsDesc"]."\">".PHP_EOL;
  echo "<input type=\"text\" name=\"tags\" placeholder=\"Tagy\" value=\"".$picsResultRow["picsTags"]."\">".PHP_EOL;
  echo "<div id=\"privateCheckboxLabel\">".PHP_EOL;
    $isPrivate = ($picsResultRow["picsPrivate"] == "1")? "checked" : " ";

    echo "<input type=\"checkbox\" name=\"isPrivate\" id=\"isPrivate\"".$isPrivate.">".PHP_EOL;
    echo "<label for=\"isPrivate\">Soukromý obrázek</label>".PHP_EOL;
  echo "</div>".PHP_EOL;
  ?>
  <button type="submit" name="upload">Nahrát změny</button>
  <button type="submit" name="cancel">Zrušit</button>
</form>

</div>



<?php include_once "footer.php" ?>