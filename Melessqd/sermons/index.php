<?php if ($_REQUEST["format"] == "xml") {
header("Content-Type: application/xml");
echo '<?xml version="1.0" encoding="utf-8" ?>';
}
require_once '../template/library/HTMLPurifier.auto.php';
require_once '../template/functions.php';
require_once '../template/config.php';
require_once '../template/hotsprings_'.$DatabaseType.'.php';
//echo "databse loaded";
require_once '../template/SQL_'.$DatabaseType.'.php';
require_once '../template/vars.php';
require_once '../template/errorlog.php';
require_once '../template/asc_shift.php';
$URL = curURL(parameters('SSL'), 0);
// build podcast folder to check through for podcast files.
$nofolder = 1;
$PodCast = PodCastURL(); 
$nofolder = 0;
//add the xml 
$check_paramater = parameters('Podcast_URL');
if (!isset($check_paramater) || strlen($check_paramater) == 0){
    $PodCast .= '/?format=xml';
}
if ($_REQUEST["format"] == "xml") {
?>

<rss xmlns:atom="http://www.w3.org/2005/Atom" xmlns:media="http://search.yahoo.com/mrss/" xmlns:itunes="http://www.itunes.com/dtds/podcast-1.0.dtd" version="2.0">
      <channel>
      <title><?php echo parameters('Podcast_Title'); ?></title>
      <link><?php echo $URL ?></link>
      <atom:link href="<?php echo $PodCast ?>" rel="self" type="application/rss+xml" />
      <description><?php echo parameters('Podcast_Title'); ?></description>
      <language>en-gb</language>
      <copyright>&#169; <?php echo Date("Y") . " " . parameters('Organisation'); ?></copyright>
      <image>
	<url><?php echo $URL; ?>/images/albumart.png</url>
	<title><?php echo parameters('Podcast_Title'); ?></title>
	<width>144</width>
	<height>115</height>
	<link><?php echo $PodCast ?></link>
      </image>
<?php

$today = new DateTime(date('d-m-Y'));

$today->modify("+1 day");
$Adjust = 1;
while ($Adjust < 21) {
	$today->modify("-1 day");
	$var_sermon = $today->format("d-m-Y");
	if(file_exists($var_sermon . ".mp3")){
		echo "      <lastBuildDate>" . date("D, d M Y H:i:s", filectime($var_sermon . ".mp3")) . " GMT</lastBuildDate>\n";
		break;
	}
	$Adjust++;
} 

?>
      <ttl>5</ttl>
<?php

// remove /?format=xml from $PodCast variable, no longer needed

   $PodCast = substr($PodCast, 0, strlen($PodCast)-11);

foreach (glob("*.mp3") as $var_sermon) {

$var_sermon = substr($var_sermon, 0, -4);

if(file_exists($var_sermon . ".mp3")){
echo "\n\n
";
echo "      <item>\n";
echo "      <title>Sermon " . $var_sermon . "</title>\n";
echo "      <pubDate>" . date("D, d M Y H:i:s", filectime($var_sermon . ".mp3")) . " GMT</pubDate>\n";
echo "      <description>Sermon " . $var_sermon . " - ";
$handle = @fopen($var_sermon . ".php", "r");
if ($handle) {
	$i = 0;
    while ($i <= 2) {
        $buffer = fgets($handle, 4096);
        echo substr($buffer,0,-7);
	if ($i < 2){
		echo " - ";
	}
	$i++;
    }
    fclose($handle);
}
echo "</description>\n";
echo "      <guid isPermaLink=\"true\">" . $PodCast . $var_sermon . ".mp3</guid>\n";
echo "      <enclosure url=\"" . $PodCast  . $var_sermon . ".mp3\" length=\"" . filesize($var_sermon . ".mp3") . "\" type=\"audio/mpeg\" />\n";
echo "      </item>\n";
}
}
?>
</channel>
</rss>

<?php

	}else{
?>
          <meta http-equiv=refresh content="0; url=../?target=sermons" />
<?php
}

?>
