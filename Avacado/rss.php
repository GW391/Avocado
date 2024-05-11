<?php
header("Content-Type: application/xml");
echo '<?xml version="1.0" encoding="utf-8" ?>';

/*<rss version="2.0">
<rss xmlns:atom="http://www.w3.org/2005/Atom" xmlns:media="http://search.yahoo.com/mrss/" xmlns:itunes="http://www.itunes.com/dtds/podcast-1.0.dtd" version="2.0">*/
?>
<?php

//echo "//setup imports";

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
?>
<?php
date_default_timezone_set('Europe/London');

if (isset($_GET['feed'])){
    $feed = "template/rss" . validate($_GET['feed'],'hd') . ".php";

        if(file_exists($feed)){
        require_once $feed;
    }else{echo "      <channel>      </channel>";}
}
?>
