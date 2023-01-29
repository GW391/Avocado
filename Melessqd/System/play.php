<?php
error_reporting(E_ALL);
// echo $_SERVER['HTTP_HOST'];

/*if(isset($_SERVER['HTTP_REFERER'])){
//        echo $_SERVER['HTTP_REFERER'];
    if(preg_match("/".$_SERVER['HTTP_HOST']."/i", $_SERVER['HTTP_REFERER'])){
        $referrer = TRUE;
    }else{
        $referrer = FALSE;
    }

}else{
    $referrer = FALSE;
}
*/
//echo $referrer;

?>

<?php

//echo "//setup imports";
/*
require_once 'template/library/HTMLPurifier.auto.php';
require_once 'template/functions.php';

//echo "functions loaded";

//Check Configuration is set-up
$filename = 'template/config.php';

if (file_exists($filename)) {
//  echo "The file $filename exists";
    require_once 'template/config.php';
} else {
 // echo "The file $filename does not exist";
    require_once 'template/setup.php';
    die();
}

//echo "config loaded";

require_once 'template/hotsprings_'.$DatabaseType.'.php';
//echo "databse loaded";
require_once 'template/SQL_'.$DatabaseType.'.php';
require_once 'template/vars.php';
require_once 'template/errorlog.php';
require_once 'template/asc_shift.php';

//echo "templates loaded";
*/
?>

<?php
if (isset($_REQUEST["d"])){
$UUID = decryptfe(validate($_REQUEST['d'],'hd'));

//echo $file;

$Select = "UUID, name, file_name, type, size, file_type, Meta_1, Meta_2, Meta_3, Meta_4, Description, Date";
$From = "tblattachment";
$die = "Sorry something went wrong, please try again later";
$where = "UUID = '$UUID'";
$Limit = 1;
$sort = null;
$PodcastResult = SQL($Select, $From, $die, $where, $Limit, null, $sort);

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
<table width=99% border=0>
<tr>
<td colspan=2 align=center>
<h3>
<?php
echo $Title .' - ';

$DateTime = new DateTime($Date);
$DateTime->format('d-m-Y');
echo $DateTime->format('d-m-Y');

        //validate(,'hd');

        if (null !== (parameters('Podcast_Folder')) || strlen(parameters('Podcast_Folder')) == 0){
            $location = "podcast";
        }else{
            $location = parameters('Podcast_Folder');
        }

$fileloc = "./" . $location . '/' . $File_Name;

//if (isset($_REQUEST["d"])){
// todo: check validation
//$file = validate($_REQUEST["d"], 'hd');
//echo $file;
//$addpath='';
//$addext='';

//$PodCast = PodCastURL();

?>
</h3>
</td>
</tr>
<tr>
<td>

<?php 
// embed audio player into page with podcast file.
/*<param name="src" value="<?php echo $PodCast?>/<?php echo $addpath; ?><?php echo $file; ?><?php echo $addext; ?>.mp3">
<embed src="<?php echo parameters('Podcast_Folder')?>/<?php echo $file; ?>.mp3" loop="false" width="300" controller="true"
*/
?>
<object width="300">

<param name="src" value="<?php echo $fileloc; ?>">
<param name="autoplay" value="true">
<param name="controller" value="true">
<param name="bgcolor" value="#FFFFFF">
<embed src="<?php echo $fileloc; ?>" loop="false" width="300" controller="true" bgcolor="#FBFBFF"></embed>
</object>

</td>
<td align=right>

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
}
?>

</td>
</tr>
<?php

if (isset($Meta_2)){
?>
<tr>
<td colspan="2">
<iframe src="https://www.biblegateway.com/passage/?search=<?php echo $Meta_2 ?>;&amp;version="NIV" width="100%" height="500" border="0" marginwidth="0" frameborder="0"></iframe>
</tr>
<?php
}
}else{
echo "No file selected to play";
}
?>
</table>
