
<p>

<?php


$Months = array("Jan", "Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec");

if (empty($_REQUEST['Month']) || !in_array($_REQUEST['Month'], $Months)) {
exit(@require_once("template/content_404.php"));
}

$Month = $_REQUEST["Month"];

echo "<center><h2>Archive Sermons for " , $Month , "</h2></center>";


foreach (glob("sermons/Archive/" . $Month . "/*.mp3") as $filename) {

	$var_sermon = "Archive/" . $Month ."/" . basename($filename, ".mp3");
	@include("./template/sermonlinks.php");

}

?>
