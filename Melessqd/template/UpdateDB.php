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

/*
$sql_AlterContent ="
        
DROP PROCEDURE IF EXISTS $DatabaseName.?;
DELIMITER //
CREATE PROCEDURE $DatabaseName.?()
BEGIN
  DECLARE CONTINUE HANDLER FOR SQLEXCEPTION BEGIN END;
  ALTER TABLE $DatabaseName.tblcontent ADD COLUMN System VARCHAR(45) DEFAULT NULL;
END //
DELIMITER ;
CALL $DatabaseName.?();
DROP PROCEDURE $DatabaseName.?;

ALTER TABLE $DatabaseName.tblcontent CHANGE COLUMN page page LONGTEXT CHARACTER SET 'utf8' NULL
ALTER TABLE $DatabaseName.tblsettings CHANGE COLUMN Value Value LONGTEXT NULL DEFAULT NULL;
        ";
        //. ""
        //. "ALTER TABLE $DatabaseName.tblcontent ADD COLUMN System VARCHAR(45) DEFAULT NULL AFTER sortorder, "
        //. " CHANGE COLUMN page page LONGTEXT CHARACTER SET 'utf8' NULL" ;

mysqli_query($con, $sql_AlterContent);
      if (!$con) {
    echo "Error: Unable to connect to MySQL." . PHP_EOL;
    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
    exit;
}else{
    echo "Content Table Updated<br />";
}
 * 
 */