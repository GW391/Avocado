<?php

$system = false;
$varsloaded = True;

//TODO: Paramatrise this array so it is customisable
// selection of characters I don't want in the URL strings
// this is an extra layer and not really needed as validate covers
// but used to speed up processing, and simply drops the Target, section or subsection if detected.
$badstringarray = ['%27',"'","(","!","%"];

function str_contains_any(string $haystack, array $needles): bool
{
    return array_reduce($needles, fn($a, $n) => $a || str_contains($haystack, $n), false);
}

// see if a Target is set
if (isset($_REQUEST["target"])){

    $target=validate($_REQUEST["target"],'h');
    //drop target if badstringarray is in it
    //this is an extra layer and not really needed as validate covers
    if (str_contains_any($target, $badstringarray)) {
        $target=404;
    }
    // see if target is in session, if so set a previous target
    // then assign new target to session
    if(isset($_SESSION["target"])){
            $_SESSION['ptarget'] = $_SESSION["target"];
    }
                $_SESSION["target"] = $target;

}

// see if a section is set
if (isset($_REQUEST["section"]) && isset($target)){
	$section=validate($_REQUEST["section"],'h');
    //drop section if badstringarray is in it
    //this is an extra layer and not really needed as validate covers
        if (str_contains_any($section, $badstringarray)) {
        $section=404;
    }
    // see if section is in session, if so set a previous target
    // then assign new section to session
            if(isset($_SESSION["section"])){
            $_SESSION['psection'] = $_SESSION["section"];

    }
                $_SESSION["section"] = $section;
}

// see if a subsection is set
if (isset($_REQUEST["subsection"]) && isset($target) && isset($section)){
	$subsection=validate($_REQUEST["subsection"],'h');
    //drop subsection if badstringarray is in it
    //this is an extra layer and not really needed as validate covers
        if (str_contains_any($subsection, $badstringarray)) {
        $subsection=404;
    }
    // see if subsection is in session, if so set a previous target
    // then assign new subsection to session
            if(isset($_SESSION["subsection"])){
            $_SESSION['psubsection'] = $_SESSION["subsection"];

    }
            $_SESSION["subsection"] = $subsection;

}
?>

<?php

// function for validating user input to protect against malitious user input
// from causing damage to the stystem or releasing sensitive data
function validate($string, $param){
global $con;
switch ($param) {
    case "h":
        // input is HTML
	$purifier = new HTMLPurifier();
	$string = $purifier->purify($string);
    $string = escape_string($string);
        break;
    case "hd":
        // input is HTML - for display
	$purifier = new HTMLPurifier();
	$string = $purifier->purify($string);
        break;
    case "n":
	// input is number
	$string = floatval($string);
	break;
    case "d":
	// input is date
	if ($string == '0000-00-00' or $string == null or $string == '1970-01-01'){
	$string = '0000-00-00';
	}else{
	$pos = strpos($string, '/');

	if ($pos === false) {
		$string = date('Ymd', strtotime($string));
	}elseif ($pos === 4) { 
		$string = date('Ymd', strtotime($string));
	}elseif ($pos === 2) {
		$TDateDay = substr($string,0,2); 
		$TDateMonth = substr($string,3,2); 
		$TDateYear = substr($string,6,4);
		$string = date('Ymd', strtotime($TDateYear . $TDateMonth . $TDateDay));
	}
	}
	break;
    case "i":
        // input is ISBN
	break;
    case "enc":
        // input is string for encryption
	$string = escape_string($string);
	break;		
    case "e":
      if(stripos($field, 'to:') !== false || stripos($field, 'cc:') || stripos($field, 'bcc:') !== false)
    {
    return TRUE;
    }
  else
    {
    return FALSE;
    }
break;
    
    default:
	// input type is undefined
        $string = preg_replace( '/\/"/'  , '' , $string);
        $string = htmlspecialchars(escape_string($string));
}
        // always trim any nulls off the end
	$string = trim($string);
        // return the validated input
	return $string;
}
?>
