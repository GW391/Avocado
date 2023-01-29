<?php

// Set to system page
$system = true;

if (isset($shiftloaded)){
	if ($shiftloaded){
	}else{
		require ("template/asc_shift.php");
	}
}else{
	require ("template/asc_shift.php");
}

//echo "33";
// set security
if(stripos($_SESSION['security'], parameters('SendNewsSecurity')) !== FALSE){
// clear any open SQL
//mysql_free_result($result);
echo "security cleared";
$Select = "Email, RName, Deleted, PVD";
$From = "tblnewsletter";
$GROUP = null;
$die = "Sorry there is a problem on this page please, try again later";
$where = "Deleted = 0 AND (PVD is null or PVD = 0)";
$Limit = null;
$sort = null;
$result = SQL($Select, $From, $die, $where, $Limit, $GROUP, $sort);

//echo $result;
while ($row = fetch_array($result)){
        $to = validate(decrypt($row['RName']),'hd') . "&lt;" . validate(decrypt($row['Email']),'hd') . "&gt;";
        
	echo $to;
	echo "<br />";
}
}
free_results($result);
?>
