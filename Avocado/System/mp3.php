<?php
/*
require_once '../template/library/HTMLPurifier.auto.php';
require_once '../template/functions.php';

//echo "functions loaded";

//Check Configuration is set-up
$filename = '../template/config.php';

if (file_exists($filename)) {
  echo "The file $filename exists";
    require_once '../template/config.php';
} else {
 echo "The file $filename does not exist";
    require_once '../template/setup.php';
    die();
}

//echo "config loaded";

require_once '../template/hotsprings_'.$DatabaseType.'.php';
//echo "databse loaded";
require_once '../template/SQL_'.$DatabaseType.'.php';
require_once '../template/vars.php';
require_once '../template/errorlog.php';
require_once '../template/asc_shift.php';

*/

// todo: check validation it does not seem to work when wanting to download the file.
$file = validate($_REQUEST['d'],'hd');

echo $file;
        //validate(,'hd');
        
        if (null == (parameters('Podcast_Folder')) || strlen(parameters('Podcast_Folder')) == 0){
            $location = "podcast";
        }else{
            $location = parameters('Podcast_Folder');
        }
        
$fileloc = "./" . $location . '/' . $file; //. '.mp3';

header('Pragma: public');
header('Expires: 0');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header('Cache-Control: public');
header('Content-Description: File Transfer');
header('Content-Type: audio/mpeg');
header('Content-Disposition: attachment; filename=' . $file);
header('Content-Transfer-Encoding: binary');
header('Content-Length:' . filesize($fileloc));

    ob_clean();
    flush();
    readfile($fileloc);
    exit;

?>
