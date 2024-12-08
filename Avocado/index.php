<!DOCTYPE html>
<?php
/* 
 * Copyright (C) 2020 Gregor
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */
    
date_default_timezone_set('Europe/London');

//start session
$time = 3600;
$ses = 'Session';
$httpolny = true;
if (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on"){
    //Use secure cookies when SSL is on
    session_set_cookie_params($time, $path=null, $domain=$_SERVER['HTTP_HOST'], $secure=true, $httponly=true);
}else{
    //dont use secure cookies when SSL is not on
    session_set_cookie_params($time, $path=null, $domain=$_SERVER['HTTP_HOST'], $secure=false, $httponly=true);
}
session_name($ses);
session_start();

// Reset the expiration time upon page load
if (isset($_COOKIE[$ses])){
    if (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on"){
	    setcookie($ses, $_COOKIE[$ses], time() + $time, "/", $domain=$_SERVER['HTTP_HOST'], $secure=true, $httponly=true);
    }else{
        setcookie($ses, $_COOKIE[$ses], time() + $time, "/", $domain=$_SERVER['HTTP_HOST'], $secure=false, $httponly=true);
    }
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

require_once 'template/asc_shift.php';
require_once 'template/hotsprings_'.$DatabaseType.'.php';
//echo "databse loaded";
require_once 'template/SQL_'.$DatabaseType.'.php';

require_once 'template/vars.php';
require_once 'template/errorlog.php';


//echo "templates loaded";
?>

<?php


// check if the user has logged out
if (isset($_GET['Logout']) || isset($_GET['logout']) || !$referrer){
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
<?php include("template/htmlhead.php");?>
</head>
<body>

        <div id="maincontent">

     <?php // insert page content
     include("template/content.php"); ?>
        </div>
 <!--   <center> -->

<div class='lockheader'>
    <div class="header">

        
        <?php include("template/header.php"); ?>

        <!-- menu -->
        <?php include("template/menu.php"); ?>

       <?php if (parameters('Breadcrumbs')){ ?>
           <?php // if breadcrumbs has been requested put it in ?>
           <div id="breadcrumbs">
               <?php require("template/breadcrumbs.php"); ?>
           </div>
      <?php } ?>
        </div>
    </div>

    
    


    <div id="footer">
    <?php // insert page footer 
    include ("./template/footer.php");
?>
</div>
<!--</center>-->
</body>
</html>
