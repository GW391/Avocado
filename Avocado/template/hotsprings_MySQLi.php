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
// if DB username is encrypted decrypt is for use
if (isset($DatabaseUserNameE)){
  $DatabaseUserName = new Decrypt($DatabaseUserNameE);
}else{
  // if not encrypted encrypt it, and set system to re-write cinfig file.
  $DatabaseUserNameE = new Encrypt($DatabaseUserName);
  $SaveConfig = True;
}

// if DB Password is encrypted decrypt is for use
if (isset($DatabasePasswordE)){
  $DatabasePassword = new Decrypt($DatabasePasswordE);
}else{
  // if not encrypted encrypt it, and set system to re-write cinfig file.
  $DatabasePasswordE = new Encrypt($DatabasePassword);
  $SaveConfig = True;
}

// if DB username or password was not encrypted, re-write the Config file with the encrypted
// DB username and password
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
    // write config file
    file_put_contents($filename, $config);
    //write backup config file
    file_put_contents($backupFile, $config);
}

// try to connect to Database
$con = mysqli_connect($DatabaseServerName, $DatabaseUserName, $DatabasePassword, $DatabaseName);

// cleanly fail if database is not connected
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

?>
