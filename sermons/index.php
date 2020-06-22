<?php
if ($_REQUEST["format"] == "xml") {
	header("Content-Type: application/xml");

echo  "<?xml version=\"1.0\" ?>";
?>



      <rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">
      <channel>

          <title><?php echo parameters('Podcast_Title'); ?></title>
      <link>http://www.woodstockbaptistchurch.org.uk</link>
      <atom:link href="http://www.woodstockbaptistchurch.org.uk/sermons/?format=xml" rel="self" type="application/rss+xml" />
      <description>Woodstock Baptist Church Sermons</description>
      <language>en-gb</language>
      <copyright><?php echo Date("Y") ?></copyright>

	<image>
		<url>http://www.woodstockbaptistchurch.org.uk/images/albumart.png</url>

		<title>Woodstock Baptist church Sermons</title>
		<link>http://www.woodstockbaptistchurch.org.uk/sermons/?format=xml</link>
		<width>178</width>
		<height>130</height>
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
      <webMaster>webmaster@woodstockbaptistchurch.org.uk (Webmaster)</webMaster>
      <ttl>5</ttl>


<?php
foreach (glob("*.mp3") as $var_sermon) {

$var_sermon = substr($var_sermon, 0, -4);

if(file_exists($var_sermon . ".mp3")){
echo "\n\n
";
echo "      <item>\n
";
echo "      <title>Sermon " . $var_sermon . "</title>\n
";
echo "      <pubDate>" . date("D, d M Y H:i:s", filectime($var_sermon . ".mp3")) . " GMT</pubDate>\n
";
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
echo "</description>\n
";
echo "      <guid isPermaLink=\"true\">http://www.woodstockbaptistchurch.org.uk/sermons/" . $var_sermon . ".mp3</guid>\n
";
echo "      <enclosure url=\"http://www.woodstockbaptistchurch.org.uk/sermons/" . $var_sermon . ".mp3\" length=\"" . filesize($var_sermon . ".mp3") . "\" type=\"audio/mpeg\" />\n
";
echo "      </item>\n
";

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
