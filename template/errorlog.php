<?php
// setup error and failure actions template
function logerror($error){

    if ($error == '404') {
        require_once "template/content_404.php";
    }else {
        echo validate($error,'hd');
        //error in SQL, trying to run an update
        echo "<br />There is an error, trying to run an update <br />";
        include "template/updateDB.php";
        echo "Update complete try relaoding the page <br />";
        }

        global $con;
    if (isset($error)){
        $err = validate($error,'hd');
                 $err .= validate(sqlerror($con),'hd');
    }else{
       $err = validate(sqlerror($con),'hd');
    }
    
    $Date = date("Y-m-d H:i:s");
    $ip = $_SERVER['REMOTE_ADDR'];

    $cols='`err`,`Date`,`IPAdd`';
    $values="'$err','$Date','$ip'";

if (isset($_REQUEST["target"])){
	$target=validate($_REQUEST["target"],'hd');
}

if (isset($_REQUEST["section"])){
	$section=validate($_REQUEST["section"],'hd');
}

if (isset($_REQUEST["subsection"])){
	$subsection=validate($_REQUEST["subsection"],'hd');
}

    if (isset($target)){
        $cols = $cols . ',`target`';
        $values = $values . ",'$target'";
    }
    if (isset($section)){
        $cols = $cols . ',`section`';
        $values = $values . ",'$section'";
    }
    if (isset($subsection)){
        $cols = $cols . ',`subsection`';
        $values = $values . ",'$subsection'";
    }

    if (isset($_SESSION['user'])){
        $cols = $cols . ',`uname`';
        $values = $values . ",'" . validate($_SESSION['user'],'hd') . "'";
    }

if (isset($_SERVER['HTTP_REFERER'])){
    $cols = $cols . ',`referer`';
    $values = $values . ",'" . validate($_SERVER['HTTP_REFERER'],'hd') . "'";
}
 //TODO: ## investegate logging does not seem to be working

    if (!isset($logged)){
    $db = "tblelg";
    $die = " Sorry there has been an unrecoverable error please try again later. ..." . sqlerror($con);
    SQLI($db, $cols, $values, $die);
    $logged=true;
    }
    include("template/footer.php");
}

?>
