<?php

// $num = intval($_POST['number']);

 // echo "Num = " .  $num . "<br />";

// for ($c=1; $c < $num; $c++) {

// $Date = date('Ymd', strtotime($_POST['Date']));
$system = true;
$ID = validate(decryptfe($_POST['ID']),'h');

    //var_dump($_POST['value']);
    if (is_array($_POST['value'])){
        $tempvalue = implode("\n", $_POST['value']);
       // var_dump($tempvalue);
        $value = validate($tempvalue, 'h');
    }else{
 $value = validate($_POST['value'],'h');
    }

$WhoCreate = validate($_SESSION['puid'],'h');
$DateUpdate = Date('Ymd');
$WhoUpdate = validate($_SESSION['puid'],'h');
$DateCreate = Date('Ymd');

$select = 'UUID, name';
$from = "tblsettings";
$where = "UUID = '$ID'";


$lookup = SQL($select, $from, null, $where, null, null, null);

while ($row = fetch_assoc($lookup)) {
    $name = $row["name"];
}

$num_rows = num_rows($lookup);
// echo "Num_Rows = " .  $num_rows . "<br />";

if ($num_rows == '1'){

$update = "tblsettings";
$set = "value = '$value', whoupdate = '$WhoUpdate', Updated = '$DateUpdate' ";
$where = "UUID = '$ID'";
$limit = '1';
$die = 'Sorry there has been a problem please try again ';

$result = SQLU($update, $set, $where, $limit, $die);

	echo "$name Updated <br />";
}else{

echo "Nothing to do";
//}
}
if (isset($_POST['Grouping'])){
    //echo "1";
    $Grouping = validate($_POST['Grouping'], 'hd');
}
require ('Settings.php');

?>
