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
session_set_cookie_params($time, $path=null, $domain=null, $secure=true, $httponly=true);
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

     <?php // insert page content 
     if (isset($target)){
        switch(strtolower($target)){
        case "podcast":
            include("System/mp3.php");
            break;
        case "news":
            include("System/news.php");
            break;
        default:
            echo "Sorry content type incorrect";
        }
    }

?>
