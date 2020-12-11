<?php
// Read SQL Data
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
//$query .= ";";
//echo $query;
global $con;
$result = mysqli_query($con, "$query") or die(logerror($die));
return $result;
}

// Insert SQL Data

function SQLI($db, $cols, $values, $die){
global $con;
mysqli_query($con,"INSERT INTO $db ($cols) VALUES ($values)") or die($die . mysqli_error($con));

return mysqli_insert_id($con);
}

// Update SQL Data 
function SQLU($update, $set, $where, $limit, $die){

$update = "UPDATE $update SET $set WHERE $where
    ";

if (isset($limit)){
          $update =  $update . "LIMIT $limit
        ";
}
// echo $update;
global $con;
$result = mysqli_query($con,"$update") or die($die . mysqli_error($con));
}

function free_results($result) {
    mysqli_free_result($result);
}

function fetch_array($row) {
    $result = mysqli_fetch_array($row);
    return $result;
}

function fetch_assoc($row) {
    $result = mysqli_fetch_assoc($row);
    return $result;
}

function num_rows($row) {
    $result = mysqli_num_rows($row);
    return $result;
}

function escape_string($string) {
    global $con;
$result = mysqli_escape_string($con, $string);
return $result;
}

function sqlerror(){
    global $con;
    return mysqli_error($con);
}

function sqlclose($con){
    return mysqli_close($con);
}?>