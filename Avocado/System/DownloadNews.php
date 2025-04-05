<?php


// todo: check validation it does not seem to work when wanting to download the file.
$file = validate($_REQUEST['d'],'hd');

echo $file;
        
        if (null == (parameters('News_Folder')) || strlen(parameters('News_Folder')) == 0){
            $location = "news";
        }else{
            $location = parameters('News_Folder');
        }
        
$fileloc = "./" . $location . '/' . $file; //. '.mp3';

header('Pragma: public');
header('Expires: 0');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header('Cache-Control: public');
header('Content-Description: File Transfer');
header('Content-Type: application/pdf');
header('Content-Disposition: attachment; filename=' . $file);
header('Content-Transfer-Encoding: binary');
header('Content-Length:' . filesize($fileloc));

    ob_clean();
    flush();
    readfile($fileloc);
    exit;

?>
