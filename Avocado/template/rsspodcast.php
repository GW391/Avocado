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
      <language><?php echo parameters('Podcast_Language'); ?></language>
      <copyright>&#169; <?php echo Date("Y") . " " . parameters('Organisation'); ?></copyright>
      <?php // TODO: need to paramertarise image file ?>
      <image>
	<url><?php echo $URL; ?>/images/albumart.jpg</url>
	<width>144</width>
	<height>130</height>
      <title><?php echo parameters('Podcast_Title'); ?></title>
      <link><?php echo $URL ?></link>
      </image>
<?php //itunes specific tags ?>
<itunes:owner>
<?php // set podcast contact email and use contactemail if podcast email does not exist ?>
<?php if (null != (parameters('PodcastContactEmail')) && strlen(trim(parameters('PodcastContactEmail'))) != 0){?>
<itunes:email><?php echo parameters('ContactEmail'); ?></itunes:email>
    <?php }else{?>
<itunes:email><?php echo parameters('ContactEmail'); ?></itunes:email>
<?php }?>
</itunes:owner>
<?php
    // Get Podcast Category's from parameters
        $category = nl2br(parameters('Podcast_Category'));
        $categoryArray = explode('<br />', trim($category));
        $cnum = count($categoryArray);
        $i = 0;
        while ($cnum > $i) {
            echo "<itunes:category text=\"" . $categoryArray[$i] . "\"";
            if ($cnum > 0 and $i == 0){
            }else{
            echo " /";
            }
            echo ">";
            $i++;
        }
?>
</itunes:category>
	<itunes:summary><?php echo parameters('Podcast_Title'); ?></itunes:summary>
	<itunes:author><?php echo parameters('Organisation'); ?></itunes:author>
<itunes:image 
	href="<?php echo $URL; ?>/images/albumartFull.jpg"
/>
<itunes:explicit><?php if (parameters('Podcast_Explicit') == 0 or parameters('Podcast_Explicit') == null){echo 'false';}else{echo 'true';}?></itunes:explicit>
<?php

// check if podcasts can be located in Database
$Select = "UUID, name, file_name, duration, type, size, file_type, Meta_1, Meta_2, Meta_3, Meta_4, Description, Date, FileTime";
$From = "tblattachment";
$die = "Sorry something went wrong, please try again later";
$where = "type = 'podcast' && deleted != 1";
$Limit = null;
$sort = "Date DESC";
$PodcastResult = SQL($Select, $From, $die, $where, $Limit, null, $sort);


if ($PodCastRow = fetch_array($PodcastResult)){
    $DateString = validate($PodCastRow['FileTime'],'n');
    $date = date('D, d M Y H:i:s', $DateString);
	echo "      <lastBuildDate>" . $date . " GMT</lastBuildDate> \n";
	echo "      <pubDate>" . $date . " GMT</pubDate> \n";
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
        if (null == (parameters('Podcast_Folder')) || strlen(parameters('Podcast_Folder')) == 0){
            $PodCast  .= "/podcast/";
        }else{
            $PodCast .= "/" . parameters('Podcast_Folder') . "/";
        }

    $Title = validate($PodCastRow['name'],'hd');
$File_Name = validate($PodCastRow['file_name'],'hd');
$Duration = validate($PodCastRow['duration'],'hd');
$Meta_1 = validate($PodCastRow['Meta_1'],'hd');
$Meta_2 = validate($PodCastRow['Meta_2'],'hd');
$Meta_3 = validate($PodCastRow['Meta_3'],'hd');
$Meta_4 = validate($PodCastRow['Meta_4'],'hd');
$fsize = round(validate($PodCastRow['size'],'hd'));
if (isset($PodCastRow['FileTime']) && $PodCastRow['FileTime'] != null){
    $DateString = validate($PodCastRow['FileTime'],'n');
    $Date = date('D, M d Y H:i:s', $DateString);
//echo $Date;
}else{
    $Date = validate($PodCastRow['Date'],'d');
}
$Description = validate($PodCastRow['Description'],'hd');
    $DateTime = new DateTime($Date);
$DateTime->format('d-m-Y H:i:s');
    echo "\n
";
$URL = curURL(parameters('SSL'), 0);
echo "      <item>\n";
echo "      <title>" . $Title . "</title>\n";
echo "      <pubDate>" . $DateTime->format('D, d M Y H:i:s') . " GMT</pubDate>\n";
echo "      <link>" . $URL . "?target=play&amp;d=" . encryptfe(validate($PodCastRow['UUID'],'hd')) . "</link>\n";
echo "      <itunes:duration>$Duration</itunes:duration>\n";
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
echo "      <itunes:summary>" ;
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

echo "</itunes:summary>\n";

echo "      <guid isPermaLink=\"true\">" . $PodCast .  $File_Name  . "</guid>\n";
echo "      <enclosure url=\"" .$PodCast . $File_Name . "\" length=\"" . $fsize . "\" type=\"audio/mpeg\" />\n";

echo "      </item>\n";

}
