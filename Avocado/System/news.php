
<centre><h1>News</h1></centre>

<?php

$security = new securityCheck(parameters('EditPodcastSecurity'));
if ($security->output)
{
//if(security_check(parameters('EditPodcastSecurity'))){
echo '<div id="edit">';
echo '<a href="?target=news&amp;section=Mail">Send / upload News letter</a>';
  // check if current user can edit parameters
$security = new securityCheck(parameters('SettingsSecurity'));
if ($security->output)
{
//  if(security_check(parameters('SettingsSecurity'))){
    // if current user can edit parameters, display parameters link.
echo '&nbsp;&nbsp;&nbsp;&nbsp;<a href="?target=Settings&amp;limit=news">News Settings</a>';
  }
echo '</div>';
}

// check if news items can be located in Database

if(isset($_REQUEST['Month']) && $_REQUEST['Month'] !=null){
    $History = validate($_REQUEST['Month'],'n');
}

$Select = "UUID, name, file_name, duration, type, size, file_type, Meta_1, Meta_2, Meta_3, Meta_4, Description, Date, deleted";
$From = "tblattachment";
$die = "Sorry something went wrong, please try again later";
$where = "type = 'news' && deleted != 1";
if (isset($History)){
 $where .= " and Month(Date) = $History";
}else{
    $Limit = parameters('News_Limit');
}
$sort = "Date DESC";
$NewsResult = SQL($Select, $From, $die, $where, $Limit, null, $sort);

$Sortdate = new DateTime(date('Y-m-d'));
$Adjust = 1;
while ($Adjust <= 12) {
    $Sortdate->modify("-1 month");
    $SortMonth = $Sortdate->format("M");
    $custsort=",'" . $SortMonth . "'";
    $Adjust++;
}
$sort = 'FIELD(Date' . $custsort . ')';

//get months for history
$Select = "Month(Date) as Month";
$Limit = 12;
$where = "type = 'news' && deleted != 1";
$Group = "Month(Date)";
$HistoryResult = SQL($Select, $From, $die, $where, $Limit, $Group, $sort);


echo '<div id="edit">';
echo "<table><tr><th>History: </th><td>";
while ($NewsHistory = fetch_array($HistoryResult)){
    $monthNum = validate($NewsHistory['Month'],'hd');
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
if (isset($NewsResult)){
$News_Rows = num_rows($NewsResult);
//echo $News_Rows;
}else{
    $NewsResult == 0;
}
if ($News_Rows > 0){

// display podcast record.
    ?>
    <table width='70%'>
    <?php
while ($NewsRow = fetch_array($NewsResult)){


$Title = validate($NewsRow['name'],'hd');
$File_Name = validate($NewsRow['file_name'],'hd');
$Duration = validate($NewsRow['duration'],'hd');
$Meta_1 = validate($NewsRow['Meta_1'],'hd');
$Meta_2 = validate($NewsRow['Meta_2'],'hd');
$Meta_3 = validate($NewsRow['Meta_3'],'hd');
$Meta_4 = validate($NewsRow['Meta_4'],'hd');
$fsize = round(validate($NewsRow['size'],'hd')/1024,2);
$Date = validate($NewsRow['Date'],'d');

if (null == (parameters('news_Folder')) || strlen(parameters('news_Folder')) == 0){
    $location = "news";
}else{
    $location = parameters('news_Folder');
}
// check if the news file exists and only show if it does
if(file_exists("$location/" . $File_Name )){

?>


    <tr>
    <td>
         <a href="news/<?php echo $File_Name?>" name="<?php echo $File_Name?>" alt="view"><?php echo $Title;?></a>
    </td>
    <td>
        <a href="news/<?php echo $File_Name?>" name="<?php echo $File_Name?>" alt="view"><?php new Icon("view");?></a>

    </td>
    <td>
        <a href="download.php?target=News&amp;d=<?php echo $File_Name?>" name="<?php echo $File_Name?>"><?php new Icon("download");?></a>
    </td>
    </tr>

<?php
}else{
    //If the news file does not exist mark record as deleted.
    $deleted = "1";
    $DeleteUUID = validate($NewsRow['UUID'],'hd');
    $DeleteDescription = validate($NewsRow['Description'],'hd') . " - Deleted due to missing file";
    $Deleteselect = 'UUID, Description';
    $Deletewhere = "UUID = '$DeleteUUID'";
    $Deleteupdate = "tblattachment";
    $Deletelimit = "1";
    $Deleteset = "Deleted = '$deleted', Description = '$DeleteDescription'";
    SQLU($Deleteupdate, $Deleteset, $Deletewhere, $Deletelimit, $die);
}
}
?>
</table>
<?php
}
else{

//todo : update news to list from Database rather than hard coded file name format.
$system = true;
if (isset($_REQUEST["news"])){
$news = validate($_REQUEST["news"],'hd');

}else{
$date = new DateTime(date('Y-m-d'));
$date->modify("+1 month");
	$news = $date->format("My") . "w.pdf";

	if(file_exists("news/" . $news)){

	}else{
$date->modify("-1 month");
$news = $date->format("My") . "w.pdf";
if(file_exists("news/" . $news)){

	}else{
$date->modify("-1 month");
$news = $date->format("My") . "w.pdf";
	}
	}
}
?>
<a href="news/<?php echo $news?>" name="<?php echo $news?>">view</a><br /> <a href="download.php?target=News&amp;d=<?php echo $news?>" name="<?php echo $news?>">download</a><br />
<embed src="news/<?php echo $news?>" width="98%" height="600" scrolling="auto" border="0" marginwidth="0"  src="news/<?php echo $news?>" style="border:none;" frameborder="0" type="application/pdf"></embed>

<?php } ?>
