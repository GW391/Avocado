<style>
div.history {
  margin: 5px;
  border: 1px solid #ccc;
  float: left;
  width: 150px;
  border-radius: 2px;
  text-align: center;
}

div.IconLink {
  margin: 0px;
  border: 0px solid #ccc;
  float: left;
 /* width: 25%;*/
  border-radius: 25px;
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

$system = true;  // Page is system page and can't be edited

// check secuirty
$security = new securityCheck(parameters('EditPodcastSecurity'));
if ($security->output)
{
    ?>
    <style>
    div.IconLink {
          width: 25%;
    }
    </style>
    <?php

// if user is podcast editior add upload file link
echo '<div id="edit">';
echo '<a href="?target=System&amp;section=Settings&amp;subsection=podcastuploads">Upload file</a>';
  // check if current user can edit parameters
$security = new securityCheck(parameters('SettingsSecurity'));
if ($security->output)
{
    // if current user can edit parameters, display parameters link.
echo '&nbsp;&nbsp;&nbsp;&nbsp;<a href="?target=Settings&amp;limit=podcast">Podcast Settings</a>';
  }
echo '</div>';

    //If the podcast is being deleted mark record as deleted.
if(isset($_REQUEST['delete']) && $_REQUEST['delete'] !=null){
    // get reocrd ID from delete
    $UUIDDelete = validate(decryptfe($_REQUEST['delete']),'hd');

    // get podcast folder
    if (null == (parameters('Podcast_Folder')) || strlen(parameters('Podcast_Folder')) == 0){
        $locationDelete = "podcast";
    }else{
        $locationDelete = parameters('Podcast_Folder');
    }

    //Find Filename
    $SelectDelete = "UUID, name, file_name, type, size, file_type, Meta_1, Meta_2, Meta_3, Meta_4, Description, Date, deleted";
    $FromDelete = "tblattachment";
    $dieDelete = "Sorry something went wrong, please try again later";
    $whereDelete = "UUID = $UUIDDelete";
    $LimitDelete = 1;
    $sortDelete = null;
    $PodcastDeleteResult = SQL($SelectDelete, $FromDelete, $dieDelete, $whereDelete, $LimitDelete, null, $sortDelete);

    //Find Filename
    $SelectItemDelete = "UUID, AttachmentUUID, file_name, type, size, file_type, deleted";
    $FromItemDelete = "tblattachmentItems";
    $whereItemDelete = "AttachmentUUID = $UUIDDelete";
    $LimitItemDelete = null;
    $PodcastItemDeleteResult = SQL($SelectItemDelete, $FromItemDelete, $dieDelete, $whereItemDelete, $LimitItemDelete, null, $sortDelete);
    $PotcastItemDelete_Rows = num_rows($PodcastItemDeleteResult);

        //echo $Potcast_Rows;
        if ($PotcastItemDelete_Rows > 0){

            // find file location
            while ($PodCastItemDeleteRow = fetch_array($PodcastItemDeleteResult)){
                $File_NameItemDelete = validate($PodCastItemDeleteRow['file_name'],'hd');

                // remove associated files
                unlink("$locationDelete/" . $File_NameItemDelete); // remove file associate with record
                $deleted = "1";
                $whereDelete = "AttachmentUUID = '$UUIDDelete'";
                $setItemDelete = "Deleted = '$deleted'";
                // update database with delete flag
                SQLU($FromItemDelete, $setItemDelete, $whereItemDelete, $LimitItemDelete, $dieDelete);  // update SQL to delete record
            }
        }

    $PotcastDelete_Rows = num_rows($PodcastDeleteResult);
    //echo $Potcast_Rows;
    if ($PotcastDelete_Rows > 0){

        // find file location
        while ($PodCastDeleteRow = fetch_array($PodcastDeleteResult)){
            $File_NameDelete = validate($PodCastDeleteRow['file_name'],'hd');

            // remove associated files
            unlink("$locationDelete/" . $File_NameDelete); // remove file associate with record
            $deleted = "1";
            $whereDelete = "UUID = '$UUIDDelete'";
            $setDelete = "Deleted = '$deleted'";
            // update database with delete flag
            SQLU($FromDelete, $setDelete, $whereDelete, $LimitDelete, $dieDelete);  // update SQL to delete record
        }
    }
}
}
?>

<p>

<?php 
if(isset($_REQUEST['Month']) && $_REQUEST['Month'] !=null){
    $History = validate($_REQUEST['Month'],'n');
}
if(isset($_REQUEST['Filter1']) && $_REQUEST['Filter1'] !=null){
    $Filter1 = validate($_REQUEST['Filter1'],'hd');
}

// build podcast URL
$URL = curURL(parameters('SSL'), 0);

 if (parameters('developer_mode')){
    var_dump(parse_url($URL));
 }


$PodCast = $URL;
//add the xml 
$check_paramater = parameters('Podcast_URL');
if (!isset($check_paramater) || strlen($check_paramater) == 0){
    if (substr($PodCast, -1) != "/") {
       // no '/' found in PodCast add it;
       $PodCast .= '/';
    }
    $PodCast .= 'rss.php?feed=podcast';
}
//display podcast URL
?>
Podcast URL:  <a href="<?php echo validate($PodCast, 'hd'); ?>"><?php echo validate($PodCast, 'hd'); ?></a><br />
</p>
<?php 
// display podcast text parameter
if (parameters('Podcast_Text')){
    echo "<p>";
    echo validate(parameters('Podcast_Text'),'hd');
    echo "</p>";

}
?>

<?php

// Get PodCast for dispaly
$Select = "UUID, name, file_name, duration, type, size, file_type, Meta_1, Meta_2, Meta_3, Meta_4, Description, Date, deleted";
$From = "tblattachment";
$die = "Sorry something went wrong, please try again later";
$where = "type = 'podcast' && deleted != 1";
    $Limit = parameters('Podcast_Limit');
if (isset($History)){
 $where .= " and Month(Date) = $History";
 $Limit = null;
}
if (isset($Filter1)){
 $where .= " and Meta_1 = $Filter1";
 $Limit = null;
}

$sort = "Date DESC";
$PodcastResult = SQL($Select, $From, $die, $where, $Limit, null, $sort);


// create custom sort for podcast history links
$Sortdate = new DateTime(date('Y-m-d'));
$Adjust = 1;
$custsort ='';
while ($Adjust <= 12) {
    $Sortdate->modify("-1 month");
    $SortMonth = $Sortdate->format("m");
    $custsort .=",'" . $SortMonth . "'";
//    echo $custsort;
    $Adjust++;
}

//echo $custsort;
$sort = 'FIELD(MONTH(Date)' . $custsort . ')';
//echo $sort;

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
    echo "<a href=\"?";
    if(isset($target)){echo "target=$target";}
    if(isset($section)){echo "&amp;section=$section";}
    if(isset($subsection)){echo "&amp;subsection=$subsection";}
    if (isset($History) && $History == $monthNum ){
        echo "&amp;Month=\">" . $monthName . "<sup>x</sup></a> ";
        }else{
        echo "&amp;Month=$monthNum\">" . $monthName . "</a> ";
        }
}
echo "</td></tr></table></div>";
echo "<br />";
/*
echo '<div id="edit">';
echo "<table><tr><th>Filters: </th><th>" . parameters('Podcast_Meta_1') . " </th><td>";

echo "</td></tr></table></div>";
echo "<br />";
*/
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
$File_Exists = file_exists("$location/" . $File_Name );

$UUID = $PodCastRow['UUID'];
$SelectItem = "UUID, AttachmentUUID, file_name, type, size, file_type";
$FromItem = "tblattachmentItems";
$whereItem = "AttachmentUUID = '$UUID' && deleted != 1";
$LimitItem = null;
$PodcastItemResult = SQL($SelectItem, $FromItem, $die, $whereItem, $LimitItem, null, $sort);

if (num_rows($PodcastItemResult) > 0 && !$File_Exists){
    echo "File not exist checking items table";
while ($PodCastItemRow = fetch_array($PodcastItemResult)){
    $file_type = validate($PodCastItemRow['file_type'],'hd');
    $Item_file_name = validate($PodCastItemRow['file_name'],'hd');
    $ftype = substr($file_type,0,strpos($file_type,"/"));
    $File_Exists = file_exists("$location/" . $Item_file_name );
}
}
if($File_Exists){
?>

<div class="podcastInfoDiv">

<table width="100%" border="0">
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

$UUID = $PodCastRow['UUID'];
$SelectItem = "UUID, AttachmentUUID, file_name, type, size, file_type";
$FromItem = "tblattachmentItems";
$whereItem = "AttachmentUUID = '$UUID' && deleted !=1";
$LimitItem = null;
$PodcastItemResult = SQL($SelectItem, $FromItem, $die, $whereItem, $LimitItem, null, $sort);

?>

</strong>

</td>
</tr>
<tr width="20%">
<td>

<?php

if (num_rows($PodcastItemResult) > 0){
while ($PodCastItemRow = fetch_array($PodcastItemResult)){
    $file_type = validate($PodCastItemRow['file_type'],'hd');
    $file_name = validate($PodCastItemRow['file_name'],'hd');
    $ftype = substr($file_type,0,strpos($file_type,"/"));
    if(file_exists("$location/" . $file_name )){
    ?>
    <a href="download.php?target=podcast&amp;d=<?php echo $file_name; ?>"><?php new Icon("download". $ftype)?></a><br />
       <a href="?target=<?php echo $target; ?>&amp;section=play&amp;i=<?php echo urlencode(encryptfe(validate($PodCastItemRow['UUID'],'hd'))); ?>"><?php new Icon("play" . $ftype)?></a><br />
    <?php
    }
}
}else{
?>
<a href="download.php?target=podcast&amp;d=<?php echo $file_name; ?>"><?php new Icon("download")?></a><br />
<a href="?target=<?php echo $target; ?>&amp;section=play&amp;d=<?php echo urlencode(encryptfe(validate($PodCastRow['UUID'],'hd'))); ?>"><?php new Icon("play")?></a><br />
<?php

}
?>
<?php
// check if security allows for podcast edit, and if so display edit links.
$security = new securityCheck(parameters('EditPodcastSecurity'));
if ($security->output)
{
//if(security_check(parameters('EditPodcastSecurity'))){
    echo '<a href="?target=System&amp;section=Settings&amp;subsection=podcastuploads&amp;edit=' . urlencode(encryptfe(validate($PodCastRow['UUID'],'hd'))) . '">';
    new Icon("edit");
    echo '</a><br />';
    echo '<a href="?';
    if(isset($target)){ echo 'target=' . $target;}
    if(isset($section)){ echo '&amp;section=' . $section;}
    if(isset($subsection)){ echo '&amp;subsection=' . $subsection;}
    echo '&amp;delete=' . urlencode(encryptfe(validate($PodCastRow['UUID'],'hd'))) . '">';new Icon("delete"); echo '</a>';
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

$UUID = $PodCastRow['UUID'];
$SelectItem = "UUID, AttachmentUUID, file_name, type, size, file_type";
$FromItem = "tblattachmentItems";
$whereItem = "AttachmentUUID = '$UUID' && deleted != 1";
$LimitItem = null;
$PodcastItemResult = SQL($SelectItem, $FromItem, $die, $whereItem, $LimitItem, null, $sort);

if (num_rows($PodcastItemResult) > 0){
    $num_icons = num_rows($PodcastItemResult);
    $security = new securityCheck(parameters('EditPodcastSecurity'));
    if ($security->output)
    {
        $IconLinkWidth = (100/($num_icons+4))-$num_icons;
    }else{
        $IconLinkWidth = (100/($num_icons+2))-$num_icons;
    }
}else{
    $security = new securityCheck(parameters('EditPodcastSecurity'));
    if ($security->output)
    {
        $IconLinkWidth = 20;
    }else{
        $IconLinkWidth = 20;
    }
}
?>
<tr>
<td colspan = "2" align="center">

<?php



if (num_rows($PodcastItemResult) > 0){
while ($PodCastItemRow = fetch_array($PodcastItemResult)){
    $file_type = validate($PodCastItemRow['file_type'],'hd');
    $file_name = validate($PodCastItemRow['file_name'],'hd');
    $ftype = substr($file_type,0,strpos($file_type,"/"));
    if(file_exists("$location/" . $file_name )){
    ?>
    <div class='IconLink' style="width: <?php echo $IconLinkWidth . "%"; ?>">
        <a href="download.php?target=podcast&amp;d=<?php echo $file_name; ?>"><?php new Icon("download". $ftype)?></a><br />
        </div>
    <div class='IconLink' style="width: <?php echo $IconLinkWidth . "%"; ?>">
       <a href="?target=<?php echo $target; ?>&amp;section=play&amp;i=<?php echo urlencode(encryptfe(validate($PodCastItemRow['UUID'],'hd'))); ?>"><?php new Icon("play" . $ftype)?></a>
    </div>
    <?php
    }
}
}else{
?>
<div class='IconLink' style="width: <?php echo $IconLinkWidth . "%"; ?>">
<a href="download.php?target=podcast&amp;d=<?php echo $File_Name; ?>"><?php new Icon("download")?></a>
</div>
    <div class='IconLink' style="width: <?php echo $IconLinkWidth . "%"; ?>">
        <a href="?target=<?php echo $target; ?>&amp;section=play&amp;d=<?php echo urlencode(encryptfe(validate($PodCastRow['UUID'],'hd'))); ?>"><?php new Icon("play")?></a>
    </div>
<?php

}
?>



<?php
// check if security allows for podcast edit, and if so display edit links.
$security = new securityCheck(parameters('EditPodcastSecurity'));
if ($security->output)
{
//if(security_check(parameters('EditPodcastSecurity'))){
    echo '<div class=\'IconLink\'  style="width: ' . $IconLinkWidth . '%"><a href="?target=System&amp;section=Settings&amp;subsection=podcastuploads&amp;edit=' . urlencode(encryptfe(validate($PodCastRow['UUID'],'hd'))) . '">';
    new Icon("edit");
    echo '</a></div>';
    echo '<div class=\'IconLink\'   style="width: ' . $IconLinkWidth . '%"><a href="?';
    if(isset($target)){ echo 'target=' . $target;}
    if(isset($section)){ echo '&amp;section=' . $section;}
    if(isset($subsection)){ echo '&amp;subsection=' . $subsection;}
    echo '&amp;delete=' . urlencode(encryptfe(validate($PodCastRow['UUID'],'hd'))) . '">';new Icon("delete"); echo '</a>';
}
?>

</td>
<?php
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
 //   OLD CODE - Commented out as I would like to make it work again

/*
//check for podcast files, specified by the filename being a date for the podcast file. 
$today = new DateTime(date('d-m-Y'));
$today->modify("+1 day");
$Adjust = 1;
while ($Adjust < 32) {

$today->modify("-1 day");

$var_sermon = $today->format("d-m-Y");
// dispaly podcast
// Get folder name parmaeter
        if (null == (parameters('Podcast_Folder')) || strlen(parameters('Podcast_Folder')) == 0){
            $location = "podcast";
        }else{
            $location= parameters('Podcast_Folder');
        }
// check if dated file exists
if(file_exists($location . "/" . $var_sermon . ".mp3")){
    include("template/sermonlinks.php"); // display file
}

$Adjust++;
}
*/
}

?>

