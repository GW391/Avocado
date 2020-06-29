<?php
$system = true;

if(preg_match("/".'admin'."/i", $_SESSION['security'])){

$security = "";
$deleted = "1";

$die = "Sorry there is a problem on this page, please try again later. ";

if (isset($_POST['DEL'])){

// Update

$UUID = validate(decryptfe($_POST['DEL']),'hd');

$where = "UUID = '$UUID'";
$update = "tblpdu";
$limit = "1";
$set = "PLCDate = '$DateCreate', whoupdate = '$WhoUpdate', PSY = '$security', Deleted = '$deleted'";


SQLU($update, $set, $where, $limit, $die);

echo " Deleted";


}
}else{
    echo "Sorry you don't heve permission to delete";

}
require "Users.php";
?>