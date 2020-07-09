<?php

// Set to system page
$system = true;

$confirm = validate($_REQUEST['confirm'],"n");
echo $confirm ;

    $update = "tblnewsletter";
    $set = "PVD = 1";
    $where = "idtblnewsletter = $confirm";
    $limit = 1;
    $die = 'Sorry there has been a problem please try again';

$result = SQLU($update, $set, $where, $limit, $die);

//mysql_close($con);
//TODO: ## Parameterise content 
echo "Subscription complete <br />";

?>