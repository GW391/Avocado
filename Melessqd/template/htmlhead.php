	<!--<meta http-equiv="content-type" content="text/html; charset=iso-8859-15" />-->
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<link rel="icon" href="favicon.ico" type="image/x-icon" />
	<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
        <meta content="width=device-width, initial-scale=1" name="viewport" />

<?php
// set meta tags

$keywords = parameters('Keywords');

if (strlen(trim($keywords)) != 0){
    echo "<meta name=\"keywords\" content=\"" . $keywords . "\" />
";
}
$description = parameters('Description');
if (strlen(trim($description)) != 0){
    echo "<meta name=\"description\" content=\"" . $description . "\" />
";
}

// set copyright meta data
$copyright = parameters('Copyright');
if (strlen(trim($copyright)) != 0){
echo "<meta name=\"copyright\" content=\"" . $copyright . "\" />
";
}else{
    echo "<meta name=\"copyright\" content=\"&copy; ";
    // if incate not set leave it out.
    if($incdate != date('Y') && strlen($incdate)!=0 ){
        echo $incdate . " - ";
    }
            echo date('Y') . " " . $Organisation . "\" />
";

}

// set site author details pulled from parameters.
$author = parameters('Author');
if (strlen(trim($author)) != 0){
    echo "<meta name=\"author\" content=\"" . $author . "\" />
";
}
?>


<?php


// see if there is any special extra headers files.
// todo: get this from databse
if (isset($target)){
    if(file_exists("./template/" . $target . ".head")){
        require_once "./template/" . $target . ".head";
    }
}
?>


<?php //set the page title ?>
    <title>
      <?php echo $Organisation;

if (isset($target)){
    $header = " - " . validate($target,'hd');
    if (isset($section)){
        $header .= " - " . validate($section,'hd');
    }
}
if(isset($header)){
    echo ucwords($header);
}


?>
    </title>

<?php

$Fonts = array("small","large","elarge","");

// check for new font selection

if (isset($_REQUEST["font"])){
	if (!in_array($_REQUEST['font'], $Fonts)) {
		$style = "";
		if (isset($_SESSION["font"])){
			unset($_SESSION["font"]);
		}
	}else{
		$_SESSION['font'] = validate($_REQUEST['font'],'hd');
	}
}


// check for existing font selection

if (isset($_SESSION["font"])){
	if (!in_array($_SESSION["font"], $Fonts)) {
		$style = "";
		if (isset($_SESSION["font"])){
			unset($_SESSION["font"]);
		}
	}else{
		$style = validate($_SESSION["font"],'hd');
	}
}else{
		$style = "";
}

?>
<style>
        /* - Old might not be needed - */
:root {
    --main-Font: <?php echo validate(parameters('MainFont'),'hd'); ?> ;
}
</style>
        
     <?php
     //check for default colours file for this Theme
        $DefaultColours = 'css/' . parameters('style') . '/DefaultColours.php';
  //      echo $DefaultColours;
        if (file_exists($DefaultColours)){
        include './'.$DefaultColours;
        }
        ?>
        
         <?php
         //check for default menu colours file for this theam
        $DefaultMenuColours = 'css/' . parameters('style') . '/DefaultMenuColours.php';
//        echo $DefaultMenuColours;
        if (file_exists($DefaultMenuColours)){
        include './'.$DefaultMenuColours;
        }
        ?>

<link rel="stylesheet" href="./css/<?php echo parameters('style')?>/menu.css" type="text/css" />
<!--// Fix for IE!-->

<!--[if IE]>
<style type="text/css" media="screen">
 #menu ul li {float: left; width: 100%;}
</style>
<![endif]-->
<!--[if lt IE 9]>
<style type="text/css" media="screen">
body {
behavior: url(./css/csshover.htc);
font-size: 100%;
}

#menu ul li a {height: 1%;}

#menu a, #menu h2 {
font: bold 0.7em/1.4em arial, helvetica, sans-serif;
}
</style>
<![endif]-->

        <link rel="stylesheet" href="./css/<?php echo parameters('style')?>/style.css" media="all" type="text/css" />
