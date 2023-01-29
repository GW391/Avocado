<rss xmlns:atom="http://www.w3.org/2005/Atom" xmlns:media="http://search.yahoo.com/mrss/" xmlns:itunes="http://www.itunes.com/dtds/podcast-1.0.dtd" version="2.0">
<?php $URL = curURL(parameters('SSL'), 0);
// build podcast folder to check through for podcast files.
$nofolder = 1;
$PodCast = PodCastURL();
$nofolder = 0;
//add the xml
$check_paramater = parameters('Podcast_URL');
if (!isset($check_paramater) || strlen($check_paramater) == 0){
    $PodCast .= 'rss.php?feed=podcast';
}
?>

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

// check if podcasts can be located in Database
$Select = "UUID, name, file_name, type, size, file_type, Meta_1, Meta_2, Meta_3, Meta_4, Description, Date";
$From = "tblattachment";
$die = "Sorry something went wrong, please try again later";
$where = "type = 'podcast'";
$Limit = null;
$sort = "Date DESC";
$PodcastResult = SQL($Select, $From, $die, $where, $Limit, null, $sort);


if ($PodCastRow = fetch_array($PodcastResult)){
    $Date = validate($PodCastRow['Date'],'d');
    $DateTime = new DateTime($Date);
$DateTime->format('d-m-Y');
//echo $DateTime->format('d-m-Y') ." - ". $Title;

		echo "      <lastBuildDate>" . $DateTime->format('D, d M Y H:i:s') . " GMT</lastBuildDate>\n";
?>
      <ttl>5</ttl>
<?php

disppodcast($PodCastRow);
	}
// remove /?format=xml from $PodCast variable, no longer needed

   $PodCast = substr($PodCast, 0, strlen($PodCast)-11);

while ($PodCastRow = fetch_array($PodcastResult)) {

//$var_sermon = substr($var_sermon, 0, -4);

//if(file_exists($var_sermon . ".mp3")){
disppodcast($PodCastRow);
}
?>
</channel>
</rss>

<?php function disppodcast($PodCastRow){
$nofolder = 1;
$PodCast = curURL(parameters('SSL'), 0);
$nofolder = 0;
//add the xml
$check_paramater = parameters('Podcast_URL');
        if (null !== (parameters('Podcast_Folder')) || strlen(parameters('Podcast_Folder')) == 0){
            $PodCast  .= "/podcast/";
        }else{
            $PodCast .= "/" . parameters('Podcast_Folder') . "/";
        }

    $Title = validate($PodCastRow['name'],'hd');
$File_Name = validate($PodCastRow['file_name'],'hd');
$Meta_1 = validate($PodCastRow['Meta_1'],'hd');
$Meta_2 = validate($PodCastRow['Meta_2'],'hd');
$Meta_3 = validate($PodCastRow['Meta_3'],'hd');
$Meta_4 = validate($PodCastRow['Meta_4'],'hd');
$fsize = round(validate($PodCastRow['size'],'hd'));
$Date = validate($PodCastRow['Date'],'d');
$Description = validate($PodCastRow['Description'],'hd');
    $DateTime = new DateTime($Date);
$DateTime->format('d-m-Y');
    echo "\n
";
echo "      <item>\n";
echo "      <title>" . $Title . "</title>\n";
echo "      <pubDate>" . $DateTime->format('D, d M Y H:i:s') . " GMT</pubDate>\n";
echo "      <description>" ;
if (isset($Title) && $Title !=NULL){
    echo "Title: " . $Title . "\r\n";
}
if (isset($Meta_1) && $Meta_1 !=NULL && parameters('Podcast_Meta_1')!= NULL) {
    echo parameters('Podcast_Meta_1'). ": " . $Meta_1 . "\r\n";
}
if (isset($Meta_2) && $Meta_2 !=NULL && parameters('Podcast_Meta_2')!= NULL){
    echo parameters('Podcast_Meta_2'). ": " . $Meta_2 . "\r\n";
}
if (isset($Meta_3) && $Meta_3 !=NULL && parameters('Podcast_Meta_3')!= NULL){
    echo parameters('Podcast_Meta_3'). ": " . $Meta_3 . "\r\n";
}
if (isset($Meta_4) && $Meta_4 !=NULL && parameters('Podcast_Meta_4')!= NULL){
    echo parameters('Podcast_Meta_4'). ": " . $Meta_4 . "\r\n";
}
if (isset($Description) && $Description !=NULL ){
    echo 'Description'. ": " . $Description . "\r\n";
}

echo "</description>\n";
echo "      <guid isPermaLink=\"true\">" . $PodCast .  $File_Name  . "</guid>\n";
echo "      <enclosure url=\"" .$PodCast . $File_Name . "\" length=\"" . $fsize . "\" type=\"audio/mpeg\" />\n";
echo "      </item>\n";

}
