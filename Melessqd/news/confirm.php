<?php

// Set to system page
$system = true;

require ("template/hotsprings.php");

$confirm = validate($_REQUEST['confirm'],"n");
echo $confirm ;

mysql_query("UPDATE tblnewsletter SET PVD = '1'
WHERE idtblnewsletter = $confirm");

mysql_close($con);
//TODO: ## Parameterise content 
echo "Subscription complete <br />";

?>