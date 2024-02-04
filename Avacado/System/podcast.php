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

div#edit {
        width: 75%;
        border: 1px outset blue;
        float: none;
}

@media screen and (max-width: 1025px){
    div#edit {
        width: 100%;
}
}

div.podcastHeadDiv {
border: 1px outset red;
  text-align: center;
  margin: 0;
padding: 0;
font-size: 1.1em;
position: relative;
width: 100%;

}

div.podcastLinksDiv {
    border: 1px outset green;
  text-align: center;
  float: left;
 width: 30%;
 text-align: left;
 margin: 0;
padding: 0;
font-size: 1.1em;
position: relative;
}

div.podcastInfoDiv {
    border: 0px outset black;
 /*text-align: center;
  float: right;*/
 width: 70%;
 text-align: left;
 margin: 0;
padding: 0;
font-size: 1.1em;

}

@media screen and (max-width: 1025px){
    div.podcastInfoDiv {
        width: 100%;
}

</style>
<?php

$system = true;


if(preg_match("/".'editor'."/i", $_SESSION['security'])){
echo '<div id="edit">';
echo '<a href="?target=System&amp;section=Settings&amp;subsection=podcastuploads">Upload file</a>';
echo '&nbsp;&nbsp;&nbsp;&nbsp;<a href="?target=Settings&amp;limit=podcast">Podcast Settings</a>';
echo '</div>';

    //If the podcast is being deletd mark record as deleted.
if(isset($_REQUEST['delete']) && $_REQUEST['delete'] !=null){
    $UUIDDelete = validate(decryptfe($_REQUEST['delete']),'hd');

    //Fine Filename
    $SelectDelete = "UUID, name, file_name, type, size, file_type, Meta_1, Meta_2, Meta_3, Meta_4, Description, Date, deleted";
$FromDelete = "tblattachment";
$dieDelete = "Sorry something went wrong, please try again later";
$whereDelete = "UUID = $UUIDDelete";
$LimitDelete = 1;
$sortDelete = null;
$PodcastDeleteResult = SQL($SelectDelete, $FromDelete, $dieDelete, $whereDelete, $LimitDelete, null, $sortDelete);

$PotcastDelete_Rows = num_rows($PodcastDeleteResult);
//echo $Potcast_Rows;
if ($PotcastDelete_Rows > 0){

// display podcast record.
while ($PodCastDeleteRow = fetch_array($PodcastDeleteResult)){
    $File_NameDelete = validate($PodCastDeleteRow['file_name'],'hd');
if (null == (parameters('Podcast_Folder')) || strlen(parameters('Podcast_Folder')) == 0){
    $locationDelete = "podcast";
}else{
    $locationDelete = parameters('Podcast_Folder');
}

unlink("$locationDelete/" . $File_NameDelete);
    $deleted = "1";
        $whereDelete = "UUID = '$UUIDDelete'";
        $setDelete = "Deleted = '$deleted'";
    SQLU($FromDelete, $setDelete, $whereDelete, $LimitDelete, $dieDelete);

}}}}
?>


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
$Select = "UUID, name, file_name, duration, type, size, file_type, Meta_1, Meta_2, Meta_3, Meta_4, Description, Date, deleted";
$From = "tblattachment";
$die = "Sorry something went wrong, please try again later";
$where = "type = 'podcast' && deleted != 1";
if (isset($History)){
 $where .= " and Month(Date) = $History";
}else{
    $Limit = parameters('Podcast_Limit');
}
$sort = "Date DESC";
$PodcastResult = SQL($Select, $From, $die, $where, $Limit, null, $sort);

//get months for history
$Select = "Month(Date) as Month";
$Limit = 12;
$where = "type = 'podcast' && deleted != 1";
$Group = "Month(Date)";
$HistoryResult = SQL($Select, $From, $die, $where, $Limit, $Group, $sort);

echo '<div id="edit">';
echo "<table><tr><th>History: </th><td>";
while ($PodCastHistory = fetch_array($HistoryResult)){
    $monthNum = validate($PodCastHistory['Month'],'hd');
//    echo $monthNum;
    $monthName = date('M', mktime(0, 0, 0, $monthNum, 10)); // March
//    echo $monthName;
    echo "<a href=\"?target=$target";
    if(isset($section)){echo "&amp;section=$section";}
    if(isset($subsection)){echo "&amp;subsection=$subsection";}
    if (isset($History) && $History == $monthNum ){
      echo "&amp;Month=\">" . $monthName . "<sup>x</sup></a> ";
    }else{
    echo "&amp;Month=$monthNum\">" . $monthName . "</a> ";
}}
echo "</td></tr></table></div>";
echo "<br />";
if (isset($PodcastResult)){
$Potcast_Rows = num_rows($PodcastResult);
//echo $Potcast_Rows;
}else{
    $PodcastResult == 0;
}
if ($Potcast_Rows > 0){

// display podcast record. 
while ($PodCastRow = fetch_array($PodcastResult)){

$Title = validate($PodCastRow['name'],'hd');
$File_Name = validate($PodCastRow['file_name'],'hd');
$Duration = validate($PodCastRow['duration'],'hd');
$Meta_1 = validate($PodCastRow['Meta_1'],'hd');
$Meta_2 = validate($PodCastRow['Meta_2'],'hd');
$Meta_3 = validate($PodCastRow['Meta_3'],'hd');
$Meta_4 = validate($PodCastRow['Meta_4'],'hd');
$fsize = round(validate($PodCastRow['size'],'hd')/1024,2);
$Date = validate($PodCastRow['Date'],'d');

if (null == (parameters('Podcast_Folder')) || strlen(parameters('Podcast_Folder')) == 0){
    $location = "podcast";
}else{
    $location = parameters('Podcast_Folder');
}
// check if the podcast file exists and only show if it does
if(file_exists("$location/" . $File_Name )){
?>

<div class="podcastInfoDiv">

<table width="100%"> <!--class="sermons"-->
<tr>
<td colspan="2" align="center">
<strong>

<?php
$DateTime = new DateTime($Date);
$DateTime->format('d-m-Y');
echo $DateTime->format('d-m-Y');
if (isset($Title) && $Title !=NULL){
    echo " - ". $Title;
}
?>

</strong>

</td>
</tr>
<tr width="30%">
<td>
- <a href="download.php?target=podcast&amp;d=<?php echo $File_Name; ?>">Download</a><br />
- <a href="?target=play&amp;d=<?php echo encryptfe(validate($PodCastRow['UUID'],'hd')); ?>">Play</a><br />
<?php
if(preg_match("/".'editor'."/i", $_SESSION['security'])){
    //echo '<p class="right">';
    echo ' - <a href="?target=System&amp;section=Settings&amp;subsection=podcastuploads&amp;edit=' . encryptfe(validate($PodCastRow['UUID'],'hd')) . '">Edit</a><br />';
    echo ' - <a href="?';
    if(isset($target)){ echo 'target=' . $target;}
    if(isset($section)){ echo '&amp;section=' . $section;}
    if(isset($subsection)){ echo '&amp;subsection=' . $subsection;}
    echo '&amp;delete=' . encryptfe(validate($PodCastRow['UUID'],'hd')) . '">Delete</a>';
    //echo '</p>';
}
?>

</td>
<td align="right" width="70%">
<?php
echo "<table border='0' width='100%'>";
if (isset($Title) && $Title !=NULL){
    echo "<tr>";
    echo "<td><strong>Title: </strong></td><td width='60%'>" . $Title . "</td>";
    echo "</tr>";
}
if (isset($Duration) && $Duration !=NULL && $Duration != 0){
    echo "<tr>";
    echo "<td><strong>Duration: </strong></td><td width='60%'>" . $Duration . "</td>";
    echo "</tr>";
}
if (isset($Meta_1) && $Meta_1 !=NULL && parameters('Podcast_Meta_1')!= NULL) {
        echo "<tr>";
    echo "<td><strong>" . parameters('Podcast_Meta_1'). ": </strong></td><td>" . $Meta_1 . "</td>";
    echo "</tr>";
}
if (isset($Meta_2) && $Meta_2 !=NULL && parameters('Podcast_Meta_2')!= NULL){
        echo "<tr>";
    echo "<td><strong>" . parameters('Podcast_Meta_2'). ": </strong></td><td>" . $Meta_2 . "</td>";
        echo "</tr>";
}
if (isset($Meta_3) && $Meta_3 !=NULL && parameters('Podcast_Meta_3')!= NULL){
    echo "<tr>";
    echo "<td><strong>" . parameters('Podcast_Meta_3'). ": </strong></td><td>" . $Meta_3 . "</td>";
        echo "</tr>";
}
if (isset($Meta_4) && $Meta_4 !=NULL && parameters('Podcast_Meta_4')!= NULL){
        echo "<tr>";
    echo "<td><strong>" . parameters('Podcast_Meta_4'). ": </strong></td><td>" . $Meta_4 . "</td>";
        echo "</tr>";
}
if (isset($fsize) && $fsize !=NULL){
        echo "<tr>";
    echo "<td><strong> Size: </strong></td><td>" . $fsize . "MB</td>";
        echo "</tr>";
}
echo "</table>";
?>
</td>
</tr>
</table>
</div>

<?php
}else{
    //If the podcast file does not exist mark record as deleted.
    $deleted = "1";
    $DeleteUUID = validate($PodCastRow['UUID'],'hd');
    $DeleteDescription = validate($PodCastRow['Description'],'hd') . " - Deleted due to missing file";

        $Deleteselect = 'UUID, Description';
        $Deletewhere = "UUID = '$DeleteUUID'";
        $Deleteupdate = "tblattachment";
        $Deletelimit = "1";
        $Deleteset = "Deleted = '$deleted', Description = '$DeleteDescription'";
    SQLU($Deleteupdate, $Deleteset, $Deletewhere, $Deletelimit, $die);
}
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

