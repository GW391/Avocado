<?php

$filename = $_REQUEST['d'];
$filename = $filename . '.mp3';

header('Pragma: public');
header('Expires: 0');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header('Cache-Control: public');
header('Content-Description: File Transfer');
header('Content-Type: audio/mpeg');
header('Content-Disposition: attachment; filename=' . $filename);
header('Content-Transfer-Encoding: binary');
header('Content-Length:' . filesize($filename));

    ob_clean();
    flush();
    readfile($filename);
    exit;

?>