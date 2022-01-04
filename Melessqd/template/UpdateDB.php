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

$sql_UpdateSettingsData = "UPDATE $DatabaseName.tblsettings SET Value='Calendar\nContact\nData\ncalendar/WeekView\ncalendar/ThreeMonthView' WHERE UUID='59';";

mysqli_query($con, $sql_UpdateSettingsData);
      if (!$con) {
    echo "Error: Unable to connect to MySQL." . PHP_EOL;
    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
    exit;
}else{
    echo "New Settings Inserted<br />";
}

// add / update columns
echo "checking Database Structure";
updateColumns('tblmenu','sitemap','tinyint(1)','NOT NULL', '1');

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
 //  print_r($ColumnCheck);
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
}