<?php

$dir = "../images/";

// Sort in ascending order - this is default
$files = array_diff(scandir($dir), array('.', '..'));

// Sort in descending order
$b = scandir($dir,1);

foreach ($files as $key => $value) {
    // $arr[3] will be updated with each value from $arr...
    //echo "{$key} => {$value} ";
    echo "title: '" .$value . "', value: 'images/" . $value . "'},\r\n";
    //print_r($files);
}

?>
