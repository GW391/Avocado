<!DOCTYPE html>
<?php
    
date_default_timezone_set('Europe/London');
  
//start session
$time = 3600;
$ses = 'Session';
session_set_cookie_params($time);
session_name($ses);
session_start();

// Reset the expiration time upon page load
if (isset($_COOKIE[$ses])){
	setcookie($ses, $_COOKIE[$ses], time() + $time, "/");
}
?>

<?php
error_reporting(E_ALL);
// echo $_SERVER['HTTP_HOST'];

if(isset($_SERVER['HTTP_REFERER'])){
//        echo $_SERVER['HTTP_REFERER'];
    if(preg_match("/".$_SERVER['HTTP_HOST']."/i", $_SERVER['HTTP_REFERER'])){
        $referrer = TRUE;
    }else{
        $referrer = FALSE;
    }

}else{
    $referrer = FALSE;
}

//echo $referrer;

?>

<?php

//echo "//setup imports";

require_once 'template/library/HTMLPurifier.auto.php';
require_once 'template/functions.php';

//echo "functions loaded";

//Check Configuration is set-up
$filename = 'template/config.php';

if (file_exists($filename)) {
//  echo "The file $filename exists";
    require_once 'template/config.php';
} else {
 // echo "The file $filename does not exist";
    require_once 'template/setup.php';
    die();
}

//echo "config loaded";

require_once 'template/hotsprings_'.$DatabaseType.'.php';
//echo "databse loaded";
require_once 'template/SQL_'.$DatabaseType.'.php';
require_once 'template/vars.php';
require_once 'template/errorlog.php';
require_once 'template/asc_shift.php';

//echo "templates loaded";
?>

<?php

if (isset($_POST['Username']) && $referrer) {
// echo "login";

    $credentials = getUNPW($_POST['Username'], $_POST['password']);
    $UN = $credentials[0];
    $PW = $credentials[1];
             
    $select = "UUID, PUME, PRD, PRNME, PEL, PSY, PVD";
    $From = "tblpdu";
    $Where = "(PUME = '$UN' AND PRD = '$PW') AND Deleted != '1'";
    $die = "Sorry Login Failed";

    $result = SQL($select, $From, $die, $Where, null, null, null);
    $count=num_rows($result);

    if($count==1){
        welcome($result, false);
    }else{
         
    // check old method  
            
    $UN = hash('sha256',$_POST['Username']);
    $password = str_split($_POST['password'],(strlen($_POST['password'])/2)+1);
    $SEASALT = $_POST['Username'];
    $PW = hash('whirlpool',$SEASALT.$password[0].$Salt.$password[1]);

        $select = "UUID, PUME, PRD, PRNME, PEL, PSY, PVD";
        $From = "tblpdu";
        $Where = "(PUME = '$UN' AND PRD = '$PW') AND Deleted != '1'";
        $die = "Sorry Login Failed";
        $limit = NULL; 
        $Group = NULL; 
        $sort = NULL;

        $result = SQL($select, $From, $die, $Where, $limit, $Group, $sort);

	$count=num_rows($result);
        
            if($count==1){
                echo 'Old Login';
                //set to old login method
                $Old = true;
                welcome($result, $Old);
            }else{
                echo "die";
                $llfail = true;
            }
        }
}

function welcome($result, $Old){
    echo $Old;
    $row=fetch_array($result);
    //echo "count = $count";
 global $namea;
     $namea = str_word_count(decrypt($row['PRNME']), 1);
    $_SESSION['security'] = validate($row['PSY'],'hd');
    $_SESSION['securty_array'] = explode(" ", validate($row['PSY'],'hd'));
    $_SESSION['user'] = ucfirst($namea[0]);
    $_SESSION['puid'] = validate(encryptfe(validate($row['UUID'],'hd')),'hd');
    $LDate = date("Y-m-d H:i:s");
    $UUID = $row['UUID'];
    $update = 'tblpdu';
    $set = "PLLDate = '$LDate'";
    $where = "UUID = '$UUID'";
    $limit = null;
    $die = "Something has gone wrong, sorry :(";
                
                if ($Old){
                    echo "in Old";
                    // we have old method, so replace Username and Password 
                    $credentials = getUNPW($_POST['Username'], $_POST['password']);
                    $UNn = $credentials[0];
                    $PWn = $credentials[1];
                    $set .= ", PRD = '$PWn'";
                    $set .= ", PUME = '$UNn'";
                    $set .= ", PUDate = '$LDate'";
                }
                
		SQLU($update, $set, $where, $limit, $die);
}

if (isset($_GET['Logout']) || isset($_GET['logout']) || !$referrer){
	//unset($_SESSION['user']);
	//unset($_SESSION['security']);
	//unset($_SESSION['uuid']);
        //unset($_SESSION['security_array']);
        session_unset();
}


?>
    <?php
    // get parameters
    if (!isset($_session['Organisation'])){
        $Organisation = parameters('Organisation');
        $_session['Organisation'] = $Organisation;
    }else{
        $Organisation = validate($_session['Organisation'],'hd');
    }
    // get parameters
    if (!isset($_session['IncDate'])){
        $incdate = parameters('IncYear');
        $_session['Incdate'] = $incdate;
    }else{
        $incdate = validate($_session['incdate'],'hd');
    }
    if (!isset($_session['ArticleEditor'])){
        $ArticleEditor = parameters('ArticleEditor');
        $_session['ArticleEditor'] = $ArticleEditor;
    }else{
        $ArticleEditor = validate($_session['ArticleEditor'],'hd');
    }
    if (!isset($_SESSION['security'])){
        $_SESSION['security'] = "none";
    }

?>

<?php
 // 

//<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
//        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

 ?>
			 


<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<?php include("template/htmlhead.php"); ?>
</head>
<body>
 <!--   <center> -->

<div class='lockheader'>
    <div class="header">

        
        <?php include("template/header.php"); ?>
        
        <!-- menu -->
        <?php include("template/menu.php"); ?>

       <?php if (parameters('Breadcrumbs')){ ?>
                   <?php // breadcrumbs ?>
        <div id="breadcrumbs">
<?php require("template/breadcrumbs.php"); ?>
        </div>
       <?php } ?>
</div>
</div>

       
        <div id="maincontent">
 
     <?php // content ?>       
<?php include("template/content.php"); ?>
        
    <div id="footer">
    <?php // footer ?>
<?php
// echo "footer";
include ("./template/footer.php");
?>
</div>
</div>

<!--</center>-->
</body>
</html>