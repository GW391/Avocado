<?php
$system = true;

$LLUUUID = validate(decryptfe($_SESSION['puid']),'hd');

if (isset($_POST['username'])){
    if(strlen(trim($_POST['username'])) != 0){
    $credentials = getUNPW($_POST['Username'], null);
    $PW = $credentials[0];
    }
}

if (isset($_POST['name'])){
    if(strlen(trim($_POST['name'])) != 0){
        $name = validate($_POST['name'],'h');
        $name = encrypt(strtolower($name));
    }
}

if (isset($_POST['Security'])){
    if(count($_POST['Security']) != 0){
    $count = count($_POST['Security'])-1;
    $i = 0;
    $security = implode(" ", $_POST['Security']);
    $security = validate($security, 'h');
    }
}

$DateCreate = Date('Ymd');
$WhoCreate = validate($_SESSION['puid'],'h');

$DateUpdate = Date('Ymd');
$WhoUpdate = validate($_SESSION['puid'],'h');

if (isset($_POST['password'])){
    if(strlen(trim($_POST['password'])) != 0){
    $credentials = getUNPW($_POST['Username'], $_POST['password']);
    $PW = $credentials[1];
    }
}

if (isset($_POST['email'])){
    if(strlen(trim($_POST['email'])) != 0){
        $email = validate($_POST['email'],'h');
        $email = encrypt(strtolower($email));
    }
}

$die = "Sorry there is a problem on this page, please try again later. ";

if (isset($_POST['CALID'])){

// Update

$UUID = validate(decryptfe($_POST['CALID']),'hd');

$where = "UUID = '$UUID'";
$update = "tblpdu";
$limit = "1";
$set = "PLCDate = '$DateCreate', whoupdate = '$WhoUpdate'";


if (isset($name)){
    $set .= ", PRNME = '$name'";
}
if (isset($security)){
    $set .= ", PSY = '$security'";
}
if (isset($PWn)){
    $set .= ", PRD = '$PWn'";
}

if (isset($email)){
    $set .= ", PEL = '$email'";
}

SQLU($update, $set, $where, $limit, $die);

echo " Updated";

}else{

 // echo "increate";

$where = "UUID = '$UUID'";
$db = "tblpdu";
$limit = "1";
$cols = "PRNME, PSY"; //PRDate, whocreate";
if (isset($PWn)){
    $cols .= ", PRD";
}
if (isset($email)){
    $cols .= ", PEL";
}
if (isset($username)){
    $cols .= ", PUME";
}


// echo $cols;
$values = "'$name', '$security'"; //, '$DateUpdate', '$WhoCreate'";
if (isset($PWn)){
    $values .= ", '$PWn'";
}
if (isset($email)){
    $values .= ", '$email'";
}
if (isset($username)){
    $values .= ", '$username'";
}


SQLI($db, $cols, $values, $die, $limit);

echo " Created";

}

if ($UUID == $LLUUUID){
    require "MyAccount.php";
}else{
require "Users.php";
}
?>