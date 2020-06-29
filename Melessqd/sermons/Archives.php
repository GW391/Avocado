<p>

<?php
$Month = Nov;

echo "Archive Sermons for " . $Month;


foreach (glob("sermons/Archive/" . $Month . "/*.mp3") as $filename) {
//   echo basename($filename, ".mp3") . "\n";
//   echo "<a href=\"sermons/Archive/" . $Month . "/" . basename($filename) . "\" target=\"_new\">" . basename($filename, ".mp3") ."</a>\n";

$var_sermon = "sermons/Archive/" . $Month ."/" . basename($filename);
include("template/sermonlinks.php");


}

?>