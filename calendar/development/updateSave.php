<?php

//require ("template/hotsprings.php");

$Type = validate($_POST['Type']);
$Item = validate($_POST['Item'],'h');
$Priority = validate($_POST['Priority']);
$DateCreate = Date('Ymd');
$WhoCreate = $_SESSION['user'];
$DateUpdate = Date('Ymd');
$WhoUpdate = $_SESSION['user'];
$target = validate($_POST['ltarget']);
$section = validate($_POST['lsection']);
$subsection = validate($_POST['lsubsection']);


if (isset($_POST['UUID'])){

// Update

$UUID = validate($_POST['UUID'],"n");
echo $UUID;

$update = "tblpdev";
$set = "Type = '$Type', Item = '$Item', Priority = '$Priority', dateupdated = '$DateUpdate', whoupdated = '$WhoUpdate', target = '$target', section='$section', subsection='$subsection' ";
$where = "UID = '$UUID'";
$limit = '1';
$die = 'Sorry there has been a problem please try again ';

$result = SQLU($update, $set, $where, $limit, $die);

echo "Item Updated";

}else{

$db = "tblpdev";
$cols = "Type, Item, Priority, datecreted, whocreated, target, section, subsection";
$values = "'$Type','$Item','$Priority','$DateCreate','$WhoCreate','$target','$section','$lsubsection'";
$die = 'Sorry there has been a problem please try again';

$result = SQLI($db, $cols, $values, $die);

echo "Item Created";

}

?>