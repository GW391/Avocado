

<center><h2>Save Image</h2></center>

<?php
if (isset($_POST['CALID'])){

$UUID = validate($_POST['CALID'], "hd");
$image = validate($_POST['image'], "hd");
$DateUpdate = Date('Ymd');
$WhoUpdate = validate($_SESSION['user'], 'h');

$update = "Pcalder";
$set = "thumbnail = '$image', dateupdated = '$DateUpdate', whoupdated = '$WhoUpdate'";
$where = "UID = '$UUID'";
$limit = '1';
$die = 'Sorry there has been a problem please try again';

$result = SQLU($update, $set, $where, $limit, $die);

echo parameters('CalendarUpdateRecordText');
}
else {
echo "Nothing to do";
}

?>
