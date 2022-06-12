<?php

if (upload_check()){

$name = validate($_FILES["file"]["name"],'h');
$file_type = validate($_FILES["file"]["type"],'h');
$type = 'Images';
$Size = validate($_FILES["file"]["size"],'n') / 1024;

    echo "Upload: " . $name . "<br>";
    echo "Type: " . $file_type . "<br>";
    echo "Size: " . $Size  . " kB<br>" ;
//  echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br>";

    if (file_exists("images/" . $_FILES["file"]["name"]))
      {
      echo $_FILES["file"]["name"] . " already exists. ";
      }
    else
     {
      echo move_uploaded_file($_FILES["file"]["tmp_name"], "images/" . $_FILES["file"]["name"]);
      echo "Stored in: " . "images/" . $_FILES["file"]["name"];
      }
    }
    
/* 
// TODO: Add image to databse : 
    $db = "tblattachment";
    $cols = "name, size, type, file_type";
    $vals = "'$name', '$Size', '$type', '$file_type'";
    $die = "Sorry I have been unable to save the image";
    $result = SQLI($db, $cols, $vals, $die, null, null, null);
*/
require ('images.php');
?> 



