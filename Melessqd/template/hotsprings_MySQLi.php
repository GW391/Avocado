<?php

/*$con = mysqli_connect("localhost", $username, $password) or die(mysql_error()); // make connection to mysql
*/

//global $con;
$con = mysqli_connect($DatabaseServerName . ":" . $DatabaseServerPort, $DatabaseUserName, $DatabasePassword, $DatabaseName);

if (!$con) {
    echo "Error: Unable to connect to MySQL." . PHP_EOL;
    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
    exit;
}

if (!$con)
  {
  die(sqlerror('Sorry an unknown error has occured please try again later'));
  }

//mysql_select_db($DatabaseName, $con);

?>
