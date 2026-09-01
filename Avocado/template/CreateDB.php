<?php

//set up database connection

if (isset($DatabaseUserNameE)){
  $DatabaseUserName = new Decrypt($DatabaseUserNameE);
}else{
  $DatabaseUserNameE = new Encrypt($DatabaseUserName);
  $SaveConfig = True;
}

if (isset($DatabasePasswordE)){
  $DatabasePassword = new Decrypt($DatabasePasswordE);
}else{
  $DatabasePasswordE = new Encrypt($DatabasePassword);
  $SaveConfig = True;
}

$DataBaseName = validate($_POST['DatabaseName'],'hd');
$DatabaseAdminName = validate($_POST['DatabaseAdminUserName'],'hd');
$DatabaseAdminPassword = validate($_POST['DatabaseAdminPassword'],'hd');

echo "DataBaseName: " . $DataBaseName . "<br />";
echo "DatabaseServerName: " . $DatabaseServerName . "<br />";
echo "DataBaseServerPort: " . $DatabaseServerPort . "<br />";

$con = mysqli_connect($DatabaseServerName . ":" . $DatabaseServerPort, $DatabaseAdminName, $DatabaseAdminPassword);

// Create Database
        $sql="CREATE DATABASE /*!32312 IF NOT EXISTS*/ `$DataBaseName` /*!40100 DEFAULT CHARACTER SET latin1*/";

        mysqli_query($con, $sql);
      if (!$con) {
    echo "Error: Unable to connect to MySQL." . PHP_EOL;
    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
    exit;
}else{
    echo "Database $DataBaseName Crated <br />";
}

// insert tables into Database
require 'template/CreateTables.php';

// Create new user for new Database

// $sql_CreateUser = "CREATE USER $DatabaseUserName@localhost IDENTIFIED BY $DatabasePassword;";
$sql_CreateUser = "CREATE USER '$DatabaseUserName'@'localhost' IDENTIFIED BY '$DatabasePassword';";

mysqli_query($con, $sql_CreateUser);
      if (!$con) {
    echo "Error: Unable to connect to MySQL." . PHP_EOL;
    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
    exit;
}else{
    echo "Database user $DatabaseUserName Crated <br />";
}

$sql_SetPermissions = "GRANT ALTER, ALTER ROUTINE, CREATE, CREATE ROUTINE, CREATE TEMPORARY TABLES, CREATE VIEW, DELETE, EXECUTE, INDEX, INSERT, LOCK TABLES, REFERENCES, SELECT, SHOW VIEW, UPDATE ON `$DataBaseName`.* TO '$DatabaseUserName'@'localhost'";

// 

mysqli_query($con, $sql_SetPermissions);
      if (!$con) {
    echo "Error: Unable to connect to MySQL." . PHP_EOL;
    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
    exit;
}else{
    echo "User Permissions for user $DatabaseUserName set<br />";
}

// Add default Data
include 'template/default/SettingsData.php';
$sql_InsertSettingsData = "INSERT INTO `$DataBaseName`.tblsettings VALUES " . $tblSettingsData;

mysqli_query($con, $sql_InsertSettingsData);
      if (!$con) {
    echo "Error: Unable to connect to MySQL." . PHP_EOL;
    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
    exit;
}else{
    echo "Settings Added<br />";
}

include 'template/default/MenuData.php';
$sql_InsertMenuData = "INSERT INTO `$DataBaseName`.tblmenu VALUES " . $tblMenuData;

mysqli_query($con, $sql_InsertMenuData);
      if (!$con) {
    echo "Error: Unable to connect to MySQL." . PHP_EOL;
    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
    exit;
}else{
    echo "Menu Data Added<br />";
}
