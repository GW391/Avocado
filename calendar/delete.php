<?php
$system = true;
if (isset($_SESSION['security'])){
 if(stripos($_SESSION['security'], 'editor') !== false || stripos($_SESSION['security'], 'Calendar') !== false){
if (isset($_POST['DEL'])){

// Update

$UUID = validate($_POST['DEL'],"n");
$DateUpdated = Date('Ymd');
$WhoUpdate = $_SESSION['user'];
$update = "Pcalder";
$set = "Deleted = '1', whoupdated = '$WhoUpdate', dateupdated = '$DateUpdated'";
$where = "UID = '$UUID'";
$limit = 1;
$die = "Sorry there has been a problem please try again";
$result = SQLU($update, $set, $where, $limit, $die);
echo "Event Deleted";

}else{

echo "Sorry unable to delete record";
}

}else{
echo "Sorry you do not have the permission to use this facility";
}
}else{
echo "Sorry you need to login to use this page";
}

$CalendarStyle='List';

require ("./calendar.php");

?>
