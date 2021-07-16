<?php include_once "header.php" ?>
<h1>Galerie</h1>

<div class="uploadImgBtn">
<?php

if (isset($_SESSION["loggedno"])) {
  echo "<button onclick=\"window.location.href='galleryUploadForm.php';\"> Nahrát do galerie </button>";
}
else {
  echo "<p>Přihlaš se pro nahrávání do galerie.</p>";
}

$galleryFiltersForm =
"<form id=\"registrationForm\" action=# method=\"post\">".PHP_EOL."
  <input name=\"privateOnly\" type=\"checkbox\"></input>".PHP_EOL."
  <label

  <button type=\"submit\" name=\"confirmFilters\">Přidat komentář</button>".PHP_EOL."
</form>".PHP_EOL;

//echo $galleryFiltersForm;

?>

</div>

  <?php require_once "processes/databaseHandler_gallery.proc.php";

  $pageNo = @$_GET["pageNo"] ?: 0;
  $imgLimit = 12;
  $imgOffset = $imgLimit * $pageNo;

  $loggedno = @$_SESSION["loggedno"] ?: 'NULL';

  $sql = "SELECT * FROM pics WHERE (picsPrivate = 0 OR picsOwner = $loggedno) AND picsStatus = \"enabled\" ORDER BY picsNo DESC LIMIT $imgLimit OFFSET $imgOffset";
  $picsResult = $conn -> query($sql);

  $next_pageNo = $pageNo + 1;
  $previous_pageNo = $pageNo - 1;
  $pageScrollButtonsHTML =
  "<div class=\"pageScrollButtons\">".
  "<a class=\"previousPageButton\" href=\"?pageNo=".$previous_pageNo."\">Předchozí</a>".PHP_EOL.
  "<a class=\"nextPageButton\" href=\"?pageNo=".$next_pageNo."\">Další</a>".PHP_EOL.
  "</div>";
  echo $pageScrollButtonsHTML;
  if(!$picsResult){header("location: gallery.php");}


  $picsCounter = 0;
  echo "<div class=\"gallery\">".PHP_EOL;
  while ($picsResultRow = $picsResult->fetch_assoc()) {

    $sql = "SELECT * FROM usercredentials.users WHERE usersNo = ".$picsResultRow["picsOwner"]." LIMIT 1";
    $usersResult = $conn -> query($sql);
    $usersResultRow  = $usersResult->fetch_assoc();

    echo "<div class=\"mediaImage\">".PHP_EOL;
    echo "<a class=\"linkToImage\" href=\"galleryImage.php?picsNo=".$picsResultRow["picsNo"]."\">Link to image</a>".PHP_EOL;
    echo "<div class=\"imageContainer\">".PHP_EOL;
    echo "<img src=\"uploads/".$picsResultRow["picsPath"]."\" draggable=\"false\">".PHP_EOL;
    echo "</div>".PHP_EOL;

    echo "<div class=\"galleryDescriptors\">".PHP_EOL;
    echo "<p name=\"title\">".$picsResultRow["picsTitle"]."</p>".PHP_EOL;
    echo "<p name=\"owner\">".$usersResultRow["usersUid"]."</p>".PHP_EOL;
    echo "</div>".PHP_EOL;

    echo "</div>".PHP_EOL;

    $picsCounter++;
  }
  echo "</div>".PHP_EOL;

echo $pageScrollButtonsHTML;
if ($picsCounter < $imgLimit) {
  echo "<script src=\"js/galleryNavigationHide.js\"></script>";
}
  ?>


<?php include_once "footer.php" ?>