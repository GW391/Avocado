<?php

require_once 'template/library/HTMLPurifier.auto.php';
require_once 'template/functions.php';

require_once 'template/config.php';
require_once 'template/hotsprings_'.$DatabaseType.'.php';
require_once 'template/SQL_'.$DatabaseType.'.php';


$confirm = validate($_REQUEST['confirm'],"n");

$update = "tblpdu";
$set = "PVD = '1'";

$where = "UUID = $confirm";
$limit = null;
$die = 'Sorry there has been a problem please try again ';

$result = SQLU($update, $set, $where, $limit, $die);


sqlclose($con);
//TODO: ## Parameterise content 
echo "Registration complete <br />";

echo "Note:  Although you can now log in, a site administrator needs to complete part of your registration to determine your level of access, there are 3 levels of access to the site these are: <br />
Members, Attendees and Guests. The additional portions of the site will not be visible until this is completed, which will be done in due course.";
?>
