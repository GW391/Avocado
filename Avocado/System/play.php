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
$play = false; // set play to false, will be set true if there is something to play
$system = true;  // Page is system page and can't be edited

// check secuirty
$security = new securityCheck(parameters('EditPodcastSecurity'));
if ($security->output)
{

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
    $SelectItemDelete = "UUID, AttachmentUUID, file_name, type, size, file_type, deleted";
    $FromItemDelete = "tblattachmentItems";
    $whereItemDelete = "UUID = $UUIDDelete";
    $LimitItemDelete = null;
    $dieDelete = "Sorry something went wrong, please try again later";
    $sortDelete = null;

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
                $whereDelete = "UUID = '$UUIDDelete'";
                $setItemDelete = "Deleted = '$deleted'";
                // update database with delete flag
                SQLU($FromItemDelete, $setItemDelete, $whereItemDelete, $LimitItemDelete, $dieDelete);  // update SQL to delete record
            }
        }
}
}
?>


<?php
if (isset($_REQUEST["d"])){
    $UUID = decryptfe(validate($_REQUEST['d'],'hd'));

    //Get Podcast data file from old method;

    $Select = "UUID, name, file_name, type, size, file_type, Meta_1, Meta_2, Meta_3, Meta_4, Description, Date";
    $From = "tblattachment";
    $die = "Sorry something went wrong, please try again later";
    $where = "UUID = '$UUID'";
    $Limit = 1;
    $sort = null;
    $play = true;

}

if (isset($_REQUEST["i"])){
    $ItemUUID = decryptfe(validate($_REQUEST['i'],'hd'));

    // get the itmes

    //echo "UUID =" . $ItemUUID;

    $SelectItem = "UUID, AttachmentUUID, file_name, type, size, file_type";
    $FromItem = "tblattachmentItems";
    $whereItem = "UUID = '$ItemUUID'";
    $LimitItem = 1;
    $sort = null;
    $die = "Sorry something went wrong, please try again later";
    $PodcastItemResult = SQL($SelectItem, $FromItem, $die, $whereItem, $LimitItem, null, $sort);

    //echo num_rows($PodcastItemResult);

    while ($PodCastItemRow = fetch_array($PodcastItemResult)){
        if(parameters('developer_mode')){
            echo "In While";
        }
        $File_Name = validate($PodCastItemRow['file_name'],'hd');
        $fsize = round(validate($PodCastItemRow['size'],'hd')/1024,2);
        $UUID = validate($PodCastItemRow['AttachmentUUID'],'hd');
        $file_type = validate($PodCastItemRow['file_type'],'hd');
        if(parameters('developer_mode')){
            echo "File Name: " .$File_Name;
            echo "Size: " .$fsize;
        }
    }
    $Select = "UUID, name, Meta_1, Meta_2, Meta_3, Meta_4, Description, Date";
    $From = "tblattachment";
    $die = "Sorry something went wrong, please try again later";
    $where = "UUID = '$UUID'";
    $Limit = 1;
    $sort = null;
    $play=true;
}

if ($play){
$PodcastResult = SQL($Select, $From, $die, $where, $Limit, null, $sort);

while ($PodCastRow = fetch_array($PodcastResult)){
     if(parameters('developer_mode')){
        echo "In PodCastRow While";
     }
$Title = validate($PodCastRow['name'],'hd');
if (!isset($File_Name)){
    $File_Name = validate($PodCastRow['file_name'],'hd');
}
$Meta_1 = validate($PodCastRow['Meta_1'],'hd');
$Meta_2 = validate($PodCastRow['Meta_2'],'hd');
$Meta_3 = validate($PodCastRow['Meta_3'],'hd');
$Meta_4 = validate($PodCastRow['Meta_4'],'hd');
if (!isset($fsize)){
    $fsize = round(validate($PodCastRow['size'],'hd')/1024,2);
}
$Date = validate($PodCastRow['Date'],'d');
if (!isset($file_type)){
    $file_type = validate($PodCastRow['file_type'],'hd');
}
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

        if (null == (parameters('Podcast_Folder')) || strlen(parameters('Podcast_Folder')) == 0){
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

$ftype = substr($file_type,0,strpos($file_type,"/"));

if($ftype == 'video'){
    $width = 1024;
    $height = 500;
}else{
    $width = 300;
    $height = 75;
}
?>

<object width="<?php echo $width;?>" height="<?php echo $height;?>">


<param name="src" value="<?php echo $fileloc; ?>">
<param name="autoplay" value="true">
<param name="controller" value="true">
<param name="bgcolor" value="#FFFFFF">
<embed type="<?php echo $file_type;?>" src="<?php echo $fileloc; ?>" loop="false" width="<?php echo $width;?>" height="<?php echo $height;?>" controller="true" bgcolor="#FBFBFF">
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
<?php
// check if security allows for podcast edit, and if so display edit links.
$security = new securityCheck(parameters('EditPodcastSecurity'));
if ($security->output)
{
//if(security_check(parameters('EditPodcastSecurity'))){
    if(isset($ItemUUID)){
    echo '<a href="?';
    if(isset($target)){ echo 'target=' . $target;}
    if(isset($section)){ echo '&amp;section=' . $section;}
    if(isset($subsection)){ echo '&amp;subsection=' . $subsection;}
    echo '&amp;delete=';
    echo urlencode(encryptfe(validate($ItemUUID,'hd')));
    echo '">';new Icon("delete"); echo '</a>';
    }
}
?>
</td>
</tr>
<?php

}else{
echo "No file selected to play";
}
?>
</table>
