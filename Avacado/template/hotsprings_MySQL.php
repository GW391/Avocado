<?php

/*$con = mysqli_connect("localhost", $username, $password) or die(mysql_error()); // make connection to mysql
*/
$con = mysql_connect("localhost", $DatabaseUserName, $DatabasePassword);
if (!$con)
  {
  die(sqlerror('Sorry an unknown error has occured please try again later'. mysql_error()));
  }

mysql_select_db($DatabaseName, $con);

?>
