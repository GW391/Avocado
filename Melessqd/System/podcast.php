<?php

$system = true;


if(preg_match("/".'editor'."/i", $_SESSION['security'])){
echo '<div id="edit">';
echo '<a href="?target=System&amp;section=Settings&amp;subsection=fileuploads">Upload file</a>';
echo '&nbsp;&nbsp;&nbsp;&nbsp;<a href="?target=Settings&amp;limit=podcast">Podcast Settings</a>';
echo '</div>';

}
?>

<style>
div.history {
  margin: 5px;
  border: 1px solid #ccc;
  float: left;
  width: 150px;
  border-radius: 2px;
  text-align: center;
}

div.history:hover {
  border: 1px solid #777;
}

</style>
<p>

<?php 
if(isset($_REQUEST['Month']) && $_REQUEST['Month'] !=null){
    $History = validate($_REQUEST['Month'],'n');
}
// build podcast folder to check through for podcast files.
$URL = curURL(parameters('SSL'), 0);
//$PodCast = PodCastURL();
$PodCast = $URL;
//add the xml 
$check_paramater = parameters('Podcast_URL');
if (!isset($check_paramater) || strlen($check_paramater) == 0){
    $PodCast .= '/rss.php?feed=podcast';
}
?>
Podcast URL:  <a href="<?php echo validate($PodCast, 'hd'); ?>"><?php echo validate($PodCast, 'hd'); ?></a><br />
</p>
<?php 
    if (parameters('Podcast_Text')){
        echo "<p>";
        echo validate(parameters('Podcast_Text'),'hd');
        echo "</p>";

}
?>

<?php

// check if podcasts can be located in Database
$Select = "UUID, name, file_name, type, size, file_type, Meta_1, Meta_2, Meta_3, Meta_4, Description, Date, deleted";
$From = "tblattachment";
$die = "Sorry something went wrong, please try again later";
$where = "type = 'podcast' && deleted = 0";
if (isset($History)){
 $where .= " and Month(Date) = $History";
}

$Limit = 4;
$sort = "Date DESC";
$PodcastResult = SQL($Select, $From, $die, $where, $Limit, null, $sort);

//get months for history
$Select = "Month(Date) as Month";
$Limit = 12;
$where = "type = 'podcast' && deleted = 0";
$Group = "Month(Date)";
$HistoryResult = SQL($Select, $From, $die, $where, $Limit, $Group, $sort);

echo '<div id="edit">';
echo "History: ";
while ($PodCastHistory = fetch_array($HistoryResult)){
    $monthNum = validate($PodCastHistory['Month'],'hd');
//    echo $monthNum;
    $monthName = date('F', mktime(0, 0, 0, $monthNum, 10)); // March
//    echo $monthName;
    echo "<a href=\"?target=$target";
    if(isset($section)){echo "&amp;section=$section";}
    if(isset($subsection)){echo "&amp;subsection=$subsection";}
    echo "&amp;Month=$monthNum\">" . $monthName . "</a>";
}
echo "</div>";

$Potcast_Rows = num_rows($PodcastResult);

if ($Potcast_Rows > 0){

// display podcast record. 
while ($PodCastRow = fetch_array($PodcastResult)){

$Title = validate($PodCastRow['name'],'hd');
$File_Name = validate($PodCastRow['file_name'],'hd');
$Meta_1 = validate($PodCastRow['Meta_1'],'hd');
$Meta_2 = validate($PodCastRow['Meta_2'],'hd');
$Meta_3 = validate($PodCastRow['Meta_3'],'hd');
$Meta_4 = validate($PodCastRow['Meta_4'],'hd');
$fsize = round(validate($PodCastRow['size'],'hd')/1024,2);
$Date = validate($PodCastRow['Date'],'d');


?>
<table width="75%" class="sermons">
<tr>
<td colspan="2" align="center">
<strong>

<?php
$DateTime = new DateTime($Date);
$DateTime->format('d-m-Y');
echo $DateTime->format('d-m-Y') ." - ". $Title;
?>

</strong>
</td>
</tr>
<tr>
<td>
<?php
        if (null !== (parameters('Podcast_Folder')) || strlen(parameters('Podcast_Folder')) == 0){
            $location = "podcast";
        }else{
            $location = parameters('Podcast_Folder');
        }

?>
- <a href="download.php?target=podcast&amp;d=<?php echo $File_Name; ?>">Download</a><br />
<!-- - <a href="?target=sermons/play&amp;d=<?php echo $File_Name; ?>">Play</a><br />-->
- <a href="?target=play&amp;d=<?php echo encryptfe(validate($PodCastRow['UUID'],'hd')); ?>">Play</a><br />

</td>
<td align="right">
<?php

if (isset($Title) && $Title !=NULL){
    echo "<strong>Title: </strong>" . $Title . "<br />";
}
if (isset($Meta_1) && $Meta_1 !=NULL && parameters('Podcast_Meta_1')!= NULL) {
    echo "<strong>" . parameters('Podcast_Meta_1'). ": </strong>" . $Meta_1 . "<br />";
}
if (isset($Meta_2) && $Meta_2 !=NULL && parameters('Podcast_Meta_2')!= NULL){
    echo "<strong>" . parameters('Podcast_Meta_2'). ": </strong>" . $Meta_2 . "<br />";
}
if (isset($Meta_3) && $Meta_3 !=NULL && parameters('Podcast_Meta_3')!= NULL){
    echo "<strong>" . parameters('Podcast_Meta_3'). ": </strong>" . $Meta_3 . "<br />";
}
if (isset($Meta_4) && $Meta_4 !=NULL && parameters('Podcast_Meta_4')!= NULL){
    echo "<strong>" . parameters('Podcast_Meta_4'). ": </strong>" . $Meta_4 . "<br />";
}
if (isset($fsize) && $fsize !=NULL){
    echo "<strong> Size: </strong>" . $fsize . "MB<br />";
}
?>
</td>
</tr>
</table>

<?php
}
}
else{

//check for podcast files, specified by the filename being a date for the podcast file. 
$today = new DateTime(date('d-m-Y'));
$today->modify("+1 day");
$Adjust = 1;
while ($Adjust < 32) {

$today->modify("-1 day");

$var_sermon = $today->format("d-m-Y");
// dispaly podcast
// todo: get folder name parmaeter
if(file_exists("sermons/" . $var_sermon . ".mp3")){
    include("template/sermonlinks.php");
}

$Adjust++;
}
}
?>
