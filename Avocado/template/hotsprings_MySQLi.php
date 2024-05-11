<?php

/*$con = mysqli_connect("localhost", $username, $password) or die(mysql_error()); // make connection to mysql
*/

//global $con;
if (isset($DatabaseServerPort)){
    $DatabaseServerName .= ":" . $DatabaseServerPort;
    //echo $DatabaseServerName;
}
$con = mysqli_connect($DatabaseServerName, $DatabaseUserName, $DatabasePassword, $DatabaseName);
//$this->con = new mysqli( $this->$DatabaseServerName, $this->$DatabaseUserName, $this->$DatabasePassword, $this->db_name );

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
