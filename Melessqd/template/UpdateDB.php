<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

    // Connect to DB engine
//echo $DatabaseAdminName;
//echo $DatabaseAdminPassword;
global $con;
require 'template/config.php';
//require_once 'template/hotsprings_'.$DatabaseType.'.php';
//require_once 'template/SQL_'.$DatabaseType.'.php';
//require_once 'template/errorlog.php';
//require_once 'template/asc_shift.php';

include 'template/default/SettingsData.php';
//echo $tblSettingsData;
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

$sql_UpdateSettingsData = "UPDATE $DatabaseName.tblsettings SET `Value`='Calendar\nContact\nData\ncalendar/WeekView\ncalendar/ThreeMonthView\ncalendar/CompactListView' WHERE UUID='59'";

mysqli_query($con, $sql_UpdateSettingsData);
      if (!$con) {
    echo "Error: Unable to connect to MySQL." . PHP_EOL;
    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
    exit;
}else{
    echo "Settings Updatd<br />";
}

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

$sql_UpdateSettingsData3 = "UPDATE $DatabaseName.tblsettings SET `Value`='Blue_Square_Menu\r\nWhite_Square_Menu\r\nWhite_Rounded_Steel_Menu\r\nSquare_Menu\r\n3colum_vertical_Menu' WHERE UUID='35';";
mysqli_query($con, $sql_UpdateSettingsData3);
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


// add / update columns
echo "checking Database Structure";
updateColumns('tblmenu','sitemap','tinyint(1)','NOT NULL', '1');
updateColumns('tblcontent','sortorder','INT','NULL', '0');

function updateColumns($TableName, $ColumnName, $ColumnType, $NULL, $Default){
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
}}
