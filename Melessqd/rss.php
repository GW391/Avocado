<?php
header("Content-Type: application/xml");
echo '<?xml version="1.0" encoding="utf-8" ?>';
?>
<rss xmlns:atom="http://www.w3.org/2005/Atom" xmlns:media="http://search.yahoo.com/mrss/" xmlns:itunes="http://www.itunes.com/dtds/podcast-1.0.dtd" version="2.0">
<?php
require_once '../template/library/HTMLPurifier.auto.php';
require_once '../template/functions.php';
require_once '../template/config.php';
require_once '../template/hotsprings_'.$DatabaseType.'.php';
//echo "databse loaded";
require_once '../template/SQL_'.$DatabaseType.'.php';
require_once '../template/vars.php';
require_once '../template/errorlog.php';
require_once '../template/asc_shift.php';
    
date_default_timezone_set('Europe/London');

if (isset($_GET['feed'])){
    $feed = validate(decryptfe($_GET['feed']),'hd');
        if(file_exists("System/rss" . $feed . "rss.php")){
        require "System/rss" . $feed . ".php";
    }
}