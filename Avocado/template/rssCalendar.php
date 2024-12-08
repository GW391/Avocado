<?php /*<?xml version="1.0" encoding="UTF-8" ?>
<rss version="2.0">
*/?>
<rss xmlns:atom="http://www.w3.org/2005/Atom" xmlns:media="http://search.yahoo.com/mrss/" xmlns:itunes="http://www.itunes.com/dtds/podcast-1.0.dtd" version="2.0">

<?php $URL = curURL(parameters('SSL'), 0);
// build podcast folder to check through for podcast files.

/*$nofolder = 1;
$PodCast = PodCastURL();
$nofolder = 0;
//add the xml
$check_paramater = parameters('Podcast_URL');
if (!isset($check_paramater) || strlen($check_paramater) == 0){
    $PodCast .= 'rss.php?feed=podcast';
}*/
?>
<channel>
  <title>Calendar</title>
  <link><?php echo $URL;?></link>
  <description>Calendar Feed</description>
  <ttl>15</ttl>


<?php
$system = true;


$date = date('Ymd');
$Where = "Date>=$date AND Deleted!=1"; // select valid Calendar entries

if (isset($_SESSION['security'])){
        if(stripos($_SESSION['security'], 'Member')){

    }else{
        $Where .= " AND Restricted!=1";
    }
}else{
    $Where .= " AND Restricted!=1";
}

$Select = " UID, Date, Event, venue, Time, ETime, target, section, Restricted, flyers, datecreted, thumbnail";
        $From = "Pcalder";
        $Limit = null;
        $die = "Sorry no events found ";
        $sort = "Date, Time";
        $GROUP = null;
        
$result = SQL($Select, $From, $die, $Where, $Limit, $GROUP, $sort);

while ($row = fetch_array($result)){
	?>
<item>
<title><?php echo  validate($row['Event'], 'hd');?></title>
<description><?php
echo "Date: ";
echo date('l, d M Y', strtotime($row['Date']));
echo " " . date('H:i', strtotime($row['Time']));
echo "\n\r";
echo "Event: " . validate($row['Event'], 'hd');?>
</description>
<link><?php if (isset($row['target'])){
	if (strlen($row['target'])!=0){
		echo $URL . '?target=' . validate($row['target'], 'hd');
		if (isset($row['section'])){
                    if (strlen(trim($row['section'])) != 0){
			echo '&amp;section=' . validate($row['section'], 'hd');
                    }
		}
	}
}?></link>
<guid isPermaLink="false"><?php if (isset($row['target'])){
	if (strlen($row['target'])!=0){
		echo $URL . '?target=' . validate($row['target'], 'hd');
		if (isset($row['section'])){
                    if (strlen(trim($row['section'])) != 0){
			echo '&amp;section=' . validate($row['section'], 'hd');
                    }
		}
	}
}?></guid>
<pubDate><?php echo date('D, d M Y', strtotime($row['datecreted']));?></pubDate>
<?php if(isset($row['thumbnail'])){?>
<media:thumbnail width="240" url="<?php echo $URL  . "/" . validate($row['thumbnail'], 'hd');?>" />
<?php } ?>
</item>

<?php
}
?>
</channel>
</rss>
