<?php

//require ("./template/hotsprings.php");

if (isset($_POST['DEL'])){

// Update

$UUID = $_POST['DEL'];
$DateUpdated = Date('Ymd');
$WhoUpdate = $_SESSION['user'];
$update = "tblpdev";
$set = "Deleted = '1', whoupdated = '$WhoUpdate', dateupdated = '$DateUpdated'";
$where = "UID = '$UUID'";
$limit = 1;
$die = "Sorry there has been a problem please try again";
$result = SQLU($update, $set, $where, $limit, $die);

echo "Item Deleted";

}else{

echo "Sorry unable to delete record";
}


?>