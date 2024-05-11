<?php
function SQL($select, $from, $die, $where, $limit, $Group, $sort){

$query = "SELECT $select
";
$query =  $query . "FROM $from
";
if (isset($left)){
        $query =  $query . "LEFT JOIN $left
        ";
}
if (isset($on)){
        $query =  $query . "ON $on
        ";
}

if (isset($where)){
        $query =  $query . "WHERE $where
        ";
}
if (isset($Group)){
        $query =  $query . "GROUP BY $Group
        ";
}
if (isset($sort)){
        $query =  $query . "ORDER BY $sort
        ";
}
if (isset($limit)){
        $query =  $query . "LIMIT $limit
        ";
}



//echo $query;
$result = mysql_query("$query") or die(logerror($die));


return $result;
}

function SQLI($db, $cols, $values, $die){

mysql_query("INSERT INTO $db ($cols) VALUES ($values)") or die(logerror($die));

return mysql_insert_id();
mysql_close($con);
    //or die(logerror($die));


//    if (!mysql_query($sql,$con)) {
  //      echo $die . mysql_error('$sql'); // @include("template/diefooter.php");
    //    die($die . mysql_error());
    //}
}

function SQLU($update, $set, $where, $limit, $die){

$update = "UPDATE $update SET $set WHERE $where
    ";

if (isset($limit)){
          $update =  $update . "LIMIT $limit
        ";
}
// echo $update;

$result = mysql_query("$update") or die(logerror($die));
}
?>
