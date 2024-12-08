<?php

/*$con = mysqli_connect("localhost", $username, $password) or die(mysql_error()); // make connection to mysql
*/

//global $con;
if (isset($DatabaseServerPort)){
    $DatabaseServerName .= ":" . $DatabaseServerPort;
    //echo $DatabaseServerName;
}
//check if DB username and password are Encrypted, if not re-write the settings file with encrypted values.
$SaveConfig = False;
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

if($SaveConfig){
  echo "It has been detected your config needs an update, updating now";

  $filename = 'template/config.php';
  $backupFile = 'template/config' . Date('dmYHis') . '.php';

      $config = "
        <?php
    $" . "DatabaseType = \"" . $DatabaseType . "\";
    $" . "DatabaseName = \"" . $DatabaseName . "\";
    $" . "DatabaseServerName = \"" . $DatabaseServerName . "\";";
            if (isset($DatabaseServerPort) & strlen($DatabaseServerPort) !=0){
    $config .= "$" . "DatabaseServerPort = \"" . $DatabaseServerPort . "\";";
        }
    $config .= "
    $" . "DatabaseUserNameE = \"" . new Encrypt($DatabaseUserName) . "\";
    $" . "DatabasePasswordE = \"" . new Encrypt($DatabasePassword) . "\";
    $" . "DataKey = \"" . $DataKey . "\";
    $" . "PostKey = \"" . $PostKey . "\";
    $" . "Salt = \"" . $Salt . "\";
?>
";
    file_put_contents($filename, $config);
    file_put_contents($backupFile, $config);
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
