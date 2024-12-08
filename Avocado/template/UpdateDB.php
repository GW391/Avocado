<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
global $con;
require 'template/config.php';

// insert Missing tables into Database
require 'template/CreateTables.php';

// Grab Settings Data
include 'template/default/SettingsData.php';
//echo $tblSettingsData;

// Insert settings data into databse, skip/ignore any dupicates.
$sql_InsertSettingsData = "INSERT IGNORE INTO $DatabaseName.tblsettings VALUES " . $tblSettingsData;


mysqli_query($con, $sql_InsertSettingsData);
    if (!$con) {
        echo "Error: Unable to connect to MySQL." . PHP_EOL;
        echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
        echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
        exit;
    }else{
        echo "New Settings Inserted<br />";
    }

if (function_exists('parameters')){
}else{
    require 'template/functions.php';
}
$version = parameters('version');
$build = parameters('build');

if ($build <= 20240128){
// Update settings that have changed 
    //"UPDATE $update SET $set WHERE $where

    $update = "$DatabaseName.tblsettings";
    $limit = 1;
    $die = null;

    $set = "Value='Calendar\nContact\nData\ncalendar/WeekView\ncalendar/ThreeMonthView\ncalendar/CompactListView\nYouTube\npodcast\nnews/subscribe'";
    $where = "UUID='59'";

    SQLU($update, $set, $where, $limit, $die);

/*$sql_UpdateSettingsData = "UPDATE $DatabaseName.tblsettings SET `Value`='Calendar\nContact\nData\ncalendar/WeekView\ncalendar/ThreeMonthView\ncalendar/CompactListView\nYouTube\npodcast\nnews/subscribe' WHERE UUID='59'";

mysqli_query($con, $sql_UpdateSettingsData);
      if (!$con) {
    echo "Error: Unable to connect to MySQL." . PHP_EOL;
    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
    exit;
}else{
    echo "Settings Updatd<br />";
}*/

$sql_UpdateSettingsData2 = "UPDATE $DatabaseName.tblsettings SET `Options`='parameter:AvailableFonts' WHERE UUID='38';";
mysqli_query($con, $sql_UpdateSettingsData2);
      if (!$con) {
    echo "Error: Unable to connect to MySQL." . PHP_EOL;
    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
    exit;
}else{
    echo "Settings Updatd<br />";
}
$sql_UpdateSettingsData4 = "UPDATE $DatabaseName.tblsettings SET `Options`='List\r\nCompact List\r\nCalendar\r\nDay\r\nWeek\r\nThree Month\r\nrss\r\nList2' WHERE UUID='57';";
mysqli_query($con, $sql_UpdateSettingsData4);
      if (!$con) {
    echo "Error: Unable to connect to MySQL." . PHP_EOL;
    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
    exit;
}else{
    echo "Settings Updatd<br />";
}
$sql_UpdateSettingsData5 = "UPDATE $DatabaseName.tblsettings SET `Options`='List\r\nCompactList\r\nCalendar\r\nDay\r\nWeek\r\nThreeMonth\r\nrss\r\nList2' WHERE UUID='22';";
mysqli_query($con, $sql_UpdateSettingsData5);
      if (!$con) {
    echo "Error: Unable to connect to MySQL." . PHP_EOL;
    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
    exit;
}else{
    echo "Settings Updatd<br />";
}

$sql_UpdateSettingsData6 = "UPDATE $DatabaseName.tblsettings SET `num_rows`='5' WHERE UUID='21';";
mysqli_query($con, $sql_UpdateSettingsData5);
      if (!$con) {
    echo "Error: Unable to connect to MySQL." . PHP_EOL;
    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
    exit;
}else{
    echo "Settings Updatd<br />";
}

}elseif ($build <= 20240331){

    $update = "$DatabaseName.tblsettings";
    $limit = 1;
    $die = null;

    $set = "Value='Blue_Square_Menu\r\nWhite_Square_Menu\r\nWhite_Rounded_Steel_Menu\r\nSquare_Menu\r\n3colum_vertical_Menu\r\nTop_Right_Menu'";
    $where = "UUID='35'";

    SQLU($update, $set, $where, $limit, $die);
    echo "Settings Updatd<br />";

    $update2 = "$DatabaseName.tblsettings";
    $limit = 1;
    $die = null;

    $set = "Name='Header', Value='<div class=\"logo\">
<a href=\"?\"><img src=\"images/logo_mobile.png\" height=\"50\" hspace=\"0\" vspace=\"0\" border=\"0\" alt=\":Organisation Logo\" title=\":Organisation Logo\" /></a>
</div>

<div class=\"MobileLogo\">
<a href=\"?\"><img src=\"images/logo_mobile.png\" width=\"40\" hspace=\"0\" vspace=\"0\" border=\"0\" alt=\":Organisation Logo\" title=\":Organisation Logo\" /></a>
</div>

<h1>:Organisation</h1>', help='Please enter any HTML for the header'";
    $where = "UUID='17'";

    SQLU($update2, $set, $where, $limit, $die);
    echo "Settings Updatd<br />";

}elseif ($build <= 20240831){

    $update = "$DatabaseName.tblsettings";
    $limit = 1;
    $die = null;

    $set = "Grouping='General Contact email'";
    $where = "UUID='16'";

    SQLU($update, $set, $where, $limit, $die);
    echo "Settings Updatd<br />";
}


// Function to add / Update database columns.

if (function_exists('updateColumns')){
}else{
    function updateColumns($TableName, $ColumnName, $ColumnType, $NULL, $Default){
        global $DatabaseName;
        global $con;
        $ShowColumns = "SHOW COLUMNS FROM $DatabaseName.$TableName LIKE '$ColumnName'";
        $ColumnCheck = 0;
        $ColumnCheck = mysqli_query($con, $ShowColumns);
        if (!$con) {
            echo "Error: Unable to connect to MySQL." . PHP_EOL;
            echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
            echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
            exit;
        }else{
            $exists = (mysqli_num_rows($ColumnCheck))?TRUE:FALSE;
            if($exists) {
                //   echo "exists";
                $UpdateColumn = "ALTER TABLE $DatabaseName.$TableName CHANGE COLUMN $ColumnName $ColumnName $ColumnType $NULL DEFAULT $Default";
                mysqli_query($con, $UpdateColumn);
                if (!$con) {
                    echo "Error: Unable to connect to MySQL." . PHP_EOL;
                    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
                    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
                    exit;
                }else{
                        echo "Database Updated $ColumnName updated in $TableName<br />";
                    }}else{
                        // todo: did not seem to work on hosting provider
                        // need to investegate
                    $InsertColumn="alter table $DatabaseName.$TableName add column $ColumnName $ColumnType $NULL DEFAULT $Default";
                    mysqli_query($con, $InsertColumn);
                    if (!$con) {
                        echo "Error: Unable to connect to MySQL." . PHP_EOL;
                        echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
                        echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
                        exit;
                    }else{
                        echo "Database Updated $ColumnName added to $TableName<br />";
                    }
                }
            }
        } // close function
    } // end if function existis

 /*   
 
 // Function to Add and update Indexes 
    if (function_exists('AddIndex')){
}else{
    function AddIndex($TableName, $ColumnName, $IndexName){
        global $DatabaseName;
        global $con;
        $ShowColumns = "SHOW COLUMNS FROM $DatabaseName.$TableName LIKE '$ColumnName'";
        $ColumnCheck = mysqli_query($con, $ShowColumns);
        if (!$con) {
            echo "Error: Unable to connect to MySQL." . PHP_EOL;
            echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
            echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
            exit;
        }else{
            $exists = (mysqli_num_rows($ColumnCheck))?TRUE:FALSE;
            if($exists) {
                //   echo "exists";
                $UpdateColumn = "ALTER TABLE $DatabaseName.$TableName CHANGE COLUMN $ColumnName $ColumnName $ColumnType $NULL DEFAULT $Default";
                mysqli_query($con, $UpdateColumn);
                if (!$con) {
                    echo "Error: Unable to connect to MySQL." . PHP_EOL;
                    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
                    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
                    exit;
                }else{
                        echo "Database Updated $ColumnName updated in $TableName<br />";
                    }}else{
                    $InsertColumn="alter table $DatabaseName.$TableName add column $ColumnName $ColumnType $NULL DEFAULT $Default";
                    mysqli_query($con, $InsertColumn);
                    if (!$con) {
                        echo "Error: Unable to connect to MySQL." . PHP_EOL;
                        echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
                        echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
                        exit;
                    }else{
                        echo "Database Updated $ColumnName added to $TableName<br />";
                    }
                }
            }
        } // close function
    } // end if function existis
    ALTER TABLE `pcalder`
	ADD INDEX `thumbnail` (`thumbnail`);
	*/


// add / update columns
echo "checking Database Structure";
if ($build <= 20240128){
updateColumns('tblmenu','sitemap','tinyint(1)','NOT NULL', '1');
updateColumns('tblcontent','sortorder','INT','NULL', '0');
updateColumns('tblcontent','page','longtext','NULL', 'NULL');
updateColumns('Pcalder','thumbnail','text','NULL', 'NULL');
updateColumns('Pcalder','seriesID',' bigint(20)','NULL', 'NULL');
updateColumns('tblsettings','value','longtext','NULL', 'NULL');
updateColumns('tblattachment','value','binary(1)','NULL', '0');
updateColumns('tblattachment','duration','varchar(45)','NULL', '0');
updateColumns('tblattachment','WhoUpdate','varchar(45)','NULL', '0');
updateColumns('tblattachment','DateUpdate','date','NULL', '0');
updateColumns('tblnewsletter','Test','binary(1)','NOT NULL', '0');
}elseif ($build <= 20240831){


}

// finally update the version number
    $update = "$DatabaseName.tblsettings";
    $limit = 1;
    $die = null;

    $set = "Value='1.24.2'";
    $where = "UUID='88'";

    SQLU($update, $set, $where, $limit, $die);

// finally update the build number
    $update = "$DatabaseName.tblsettings";
    $limit = 1;
    $die = null;

    $set = "Value='20241208'";
    $where = "UUID='89'";

    SQLU($update, $set, $where, $limit, $die);
