<?php

//$con = mysqli_connect("localhost", $DatabaseUserName, $DatabasePassword, $DatabaseName) or die("db connect error: ".mysqli_connect_error());

$con = mysql_connect("localhost", $DatabaseUserName, $DatabasePassword);
if (!$con)
  {
  die(sqlerror('Sorry an unknown error has occured please try again later'. mysql_error()));
  }

mysql_select_db($DatabaseName, $con);

?>
