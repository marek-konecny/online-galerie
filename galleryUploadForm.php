<?php include_once "header.php" ?>

<h1>Nahrát obrázek</h1>

<form id="imgUploadForm" action="galleryUpload.php" method="post" enctype="multipart/form-data">
<label for="fileToUpload">Zvolit soubor</label>
<input type="file" name="fileToUpload" id="fileToUpload">
<?php

  echo "<div class=\"loginErrors\">".PHP_EOL;
  if(preg_match("/formatUnallowed/", @$_GET["errors"] )) {
      echo "<p>Nepodporovaný formát. Podporované formáty: .JPG .JPEG .PNG .GIF</p>".PHP_EOL;
    }
  if(preg_match("/fileTooBig/", @$_GET["errors"] )) {
      echo "<p>Velikost souboru nesmí překročit 5MB.</p>".PHP_EOL;
    }
  if(preg_match("/fileNotImg/", @$_GET["errors"] )) {
      echo "<p>Soubor není obrázek.</p>".PHP_EOL;
    }
  echo "</div>".PHP_EOL;

  ?>
  </form>

<script>
document.getElementById("fileToUpload").onchange = function() {
    document.getElementById("imgUploadForm").submit();
};
</script>




<?php include_once "footer.php" ?>