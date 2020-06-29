<?php
$system = true;

$LLUUUID = validate(decryptfe($_SESSION['puid']),'hd');
$UUID = validate(decryptfe($_POST['DEL']),'hd');

if(preg_match("/".'admin'."/i", $_SESSION['security']) || $UUID == $LLUUUID){

    $security = "";
    $deleted = "1";
    $DateCreate = date("Y-m-d");

$die = "Sorry there is a problem on this page, please try again later. ";

if (isset($_POST['DEL'])){

// Update

$UUID = validate(decryptfe($_POST['DEL']),'hd');

$where = "UUID = '$UUID'";
$update = "tblpdu";
$limit = "1";
$set = "PSY = '$security', Deleted = '$deleted'";
//PLCDate = '$DateCreate', whoupdate = '$WhoUpdate',

SQLU($update, $set, $where, $limit, $die);

echo " Deleted";


}
}else{
    echo "Sorry you don't heve permission to delete";

}

if ($UUID == $LLUUUID){
    require "MyAccount.php";
}else{
require "Users.php";
}
?>