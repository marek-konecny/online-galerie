<?php include_once "header.php" ?>

<div id="imageUploadUI">

<?php
require_once "processes/databaseHandler_gallery.proc.php";

$picsNo = $_GET["picsNo"];
$loggedno = @$_SESSION["loggedno"] ?: 'NULL';

$sql = "SELECT * FROM pics WHERE ( picsPrivate = 0 OR picsOwner = $loggedno ) AND picsNo = $picsNo AND picsStatus = 'enabled'";
$picsResult = $conn -> query($sql);
$picsResultRow = $picsResult -> fetch_assoc();

if ($picsResultRow === NULL) {
  header("location: gallery.php?errors=unauthorizedAccess");
  exit();
}

$sql = "SELECT * FROM usercredentials.users WHERE usersNo = ".$picsResultRow["picsOwner"]." LIMIT 1";
$usersResult = $conn -> query($sql);
$usersResultRow  = $usersResult->fetch_assoc();

$target_file = "uploads/".$picsResultRow["picsPath"];
echo "<img src=\"".$target_file."\">".PHP_EOL;

echo "<div id=\"imageAccessories\">".PHP_EOL;

echo "<p name=\"title\">".$picsResultRow["picsTitle"]."</p>".PHP_EOL;
echo "<p name=\"owner\">Nahrála/a ".$usersResultRow["usersUid"]."</p>".PHP_EOL;
echo "<p name=\"desc\">".$picsResultRow["picsDesc"]."</p>".PHP_EOL;

echo ($picsResultRow["picsTags"])? "<p name=\"tags\">Tagy: ".$picsResultRow["picsTags"]."</p>".PHP_EOL : "<p name=\"tags\"></p>";

if ($loggedno == $picsResultRow["picsOwner"]) {
  echo "<div class=\"imageActionButtons\">".PHP_EOL;
  echo "<a name=\"delete\" href=\"processes/galleryDelete.proc.php?picsNo=".$picsResultRow["picsNo"]."\">Smazat</a>".PHP_EOL;
  echo "<a name=\"edit\" href=\"galleryEdit.php?picsNo=".$picsResultRow["picsNo"]."\">Upravit</a>".PHP_EOL;
  echo "</div>".PHP_EOL;
}

echo "</div>".PHP_EOL;

?>


  </div>
</div>


<div class="imgComments">

  <?php
  $commentForm =
  "<form id=\"registrationForm\" action=\"processes/galleryAddComment.proc.php\" method=\"post\">".PHP_EOL."
    <input type=\"hidden\" name=\"picsno\" value=\" $picsNo \">".PHP_EOL."
    <textarea type=\"text\" name=\"commenttext\" placeholder=\"Komentář\"></textarea>".PHP_EOL."

    <button type=\"submit\" name=\"uploadcomment\">Přidat komentář</button>".PHP_EOL."
  </form>".PHP_EOL;

  echo ($loggedno == "NULL") ?  '' : $commentForm;

   ?>

<?php
$sql = "SELECT * FROM comments WHERE commentsPicsNo = $picsNo ORDER BY commentsTime DESC";

$commentsResult = $conn -> query($sql);

while ($commentsResultRow = $commentsResult->fetch_assoc()) {
    echo "<div class=\"comment\">".PHP_EOL;
    echo "<p name=\"commentsAuthor\">".$commentsResultRow["commentsAuthor"]."</p>".PHP_EOL;
    echo "<p name=\"commentsText\">".$commentsResultRow["commentsText"]."</p>".PHP_EOL;
    echo "<p name=\"commentsTime\">".$commentsResultRow["commentsTime"]."</p>".PHP_EOL;
    echo "</div>";

  }

?>

</div>



<?php include_once "footer.php" ?>