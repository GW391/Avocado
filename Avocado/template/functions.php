<?php
// load classes when required
function load_model($class_name)
{
	$path_to_file = './template/class/' . $class_name . '.php';

	if (file_exists($path_to_file)) {
		require $path_to_file;
	}
}


spl_autoload_register('load_model');
//end load classes

function getCharacters(){
      
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    
    for ($IV =  0; $IV < 5000; $IV++){
        for ($i = 0; $i < 62; $i++) {
            $CharsString .= $characters[rand(0, strlen($characters) - 1)];
        }
        $characters = $CharsString;
  }
  return $characters;
}

function generateRandomString($length = 10) {
     $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
     
  if(!isset($characters)){
      $characters = getCharacters();
  }
    
    $randomString = '';
   for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
     
    return $randomString;
}

function parameters($ParameterName)

/*
 * function to check parameters and add them to the session
 */

{
    if (!isset($_SESSION[$ParameterName])){
        global $con;
        $ParameterSelect = "Name, Value, num_rows";
        $ParameterFrom = "tblsettings";
        $Parameterwhere = "Name = '$ParameterName'";
        $ParameterLimit = "1";
        $Parameterdie = "Sorry there is a problem on the page, please try again later.";

        $ParameterResult = SQL($ParameterSelect, $ParameterFrom, $Parameterdie, $Parameterwhere, $ParameterLimit, null, null);
        // check for a result
        $count=num_rows($ParameterResult);
        if ($count===0){
            // no parameters, run upgrade
            include 'template/UpdateDB.php';
            // re-find the parameter, assume it was in the update
            $ParameterResult = SQL($ParameterSelect, $ParameterFrom, $Parameterdie, $Parameterwhere, $ParameterLimit, null, null);
        }
    
        $ParameterRow=fetch_array($ParameterResult);
        if (strtoupper(validate($ParameterRow['num_rows'],'hd')) == 'P'){
            $ParameterReturnValue = new Decrypt(validate(isset($ParameterRow['Value']) ? $ParameterRow['Value'] : NULL ,'hd'));
        }else{
            $ParameterReturnValue = validate(isset($ParameterRow['Value']) ? $ParameterRow['Value'] : NULL ,'hd');
            $_SESSION[$ParameterName] = $ParameterReturnValue;
        }
        return $ParameterReturnValue;
    }else{
        $ParameterReturnValue = validate($_SESSION[$ParameterName],'hd');
        return $ParameterReturnValue;
    }
}

// why do I have 2 of these ???
function curPageURL($ssl, $uri) {
     $pageURL = 'http';
 if (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on" || $ssl) {$pageURL .= "s";}
 $pageURL .= "://";
  if ($_SERVER["SERVER_PORT"] != "80" && $_SERVER["SERVER_PORT"] != "443") {
  $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"];
 } else {
  $pageURL .= $_SERVER["SERVER_NAME"];
 }
if ($uri || !isset($uri)){
    $pageURL .= $_SERVER["PHP_SELF"];
    }

 return $pageURL;
}

function curURL($ssl, $uri) {
     $pageURL = 'http';
 if ($ssl) {$pageURL .= "s";}
 $pageURL .= "://";
  if ($_SERVER["SERVER_PORT"] != "80" && $_SERVER["SERVER_PORT"] != "443") {
  $pageURL .= validate($_SERVER["SERVER_NAME"],'hd').":".validate($_SERVER["SERVER_PORT"],'hd');
 } else {
  $pageURL .= validate($_SERVER["SERVER_NAME"],'hd');
 }
 if ($uri || !isset($uri)){
    $pageURL .= validate($_SERVER["PHP_SELF"],'hd');
    }else{
        //TODO: Need to check this does not break anything, it's needed for PodCasts,

    $pageURL .= validate(dirname($_SERVER['PHP_SELF']),'hd');
    }
 return $pageURL;
}

// special fields:
function FieldSecurity() {

        echo "<select name=\"Security[]\" size=\"5\" multiple>";


        // get security parameters
	$Security = nl2br(parameters('Security'));
        $SecurityArray = explode('<br />', trim($Security));
        $num = count($SecurityArray);
        $i = 0;
while ($num >= $i) {
    echo "<option value=\"" . trim($SecurityArray[$i]) . "\"";
            if(stripos(validate($row['PSY'],'hd'), trim($SecurityArray[$i])) !== FALSE){
            echo "selected";
            }
echo ">" . trim($SecurityArray[$i]) . "</option>\r\n";
    $i++;
}
        
echo "</select>";
}

function DefaultSettings() {

        echo "<select name=\"Security[]\" size=\"5\" multiple>";


        // get security parameters
	$Security = nl2br(parameters('Security'));
        $SecurityArray = explode('<br />', trim($Security));
        $num = count($SecurityArray);
        $i = 0;
while ($num >= $i) {
    echo "<option value=\"" . trim($SecurityArray[$i]) . "\"";
        if(stripos(validate($row['PSY'],'hd'), trim($SecurityArray[$i])) !== FALSE){
            echo "selected";
            }
echo ">" . trim($SecurityArray[$i]) . "</option>\r\n";
    $i++;
}

echo "</select>";
}

// added rounds parameter, previously was 1000
function getUNPW($username, $passwd, $rounds){
    
        global $Salt;
        $UNn = hash('sha256',strtolower($username));
        if ($passwd != null){
            $password = str_split($passwd,(floor(strlen($passwd)/2))+1);
            $SEASALT = strtolower($username);
            $PWn = hash('whirlpool',$SEASALT.$password[0].$Salt.$password[1]);
        }
        for ($I =  0; $I < $rounds; $I++){
	$UNn = hash('sha256',$UNn);
        if ($passwd != null){
            $PWn = hash('whirlpool',$PWn);
        }
    }
if ($passwd == null){
    $PWn = null;
}
    $creds = [$UNn, $PWn];
    // I have creds, unset variables no longer needed.
    unset($passwd, $SEASALT, $PWn, $UNn, $username, $password);
    return $creds;
}

function security_check($required_security){
    if (isset($_SESSION['securty_array'])){
        // echo "required_security: " . $required_security;
        $security = $_SESSION['securty_array'];
        // print_r ($security);
        if (in_array($required_security, $security, true)){
            return TRUE;
        }else{
            return FALSE;
        }
    }else{
        return FALSE;
    }
}

function upload_check(){
$allowedExts = array("gif", "jpeg", "jpg", "png", "pdf" , "mp3", "mp4");
$allowedTypes = array("image/gif", "image/jpeg", "image/jpg", "image/pjpeg", "image/x-png", "image/png", "application/pdf", "audio/mpeg", "video/mp4");
//$temp = explode(".", $_FILES["file"]["name"]);
//print_r ($temp);

// todo: can't make mime_content_type work need it to make sure file uploads are secure.

//$temp_file = $_FILES["file"]["tmp_name"];
//$buffer = file_get_contents($temp_file);
//$finfo = new finfo(FILEINFO_MIME_TYPE);
//$ext = $finfo->buffer($buffer);
//echo "mime type: " . $ext;

//echo "mime_content_type: " . mime_content_type("news\17-05-2020.pdf");
if (!isset($_FILES['file']) || !is_array($_FILES['file'])) {
    echo "No File uploaded" . "<br>";
    return false;
}

$file = $_FILES['file'];

if (!isset($file['error']) || $file['error'] !== UPLOAD_ERR_OK){
    echo "Return Code: " . $file['error'] . "<br>";
    return false;
}

//$_FILES["file"]["name"];

//$extension = strtolower(end($temp));

    $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    if (!in_array($extension, $allowedExts, true)) {
        echo "File type not allowed: " . $extension . "<br>";
        return false;
    }

    if ($file['size'] > parameters('maxfileuploadsize')) {
        echo "File too big: " . $file['size']/1024/1024  . "<br>";
        return false;
    }

    $mime = null;
    if (function_exists('finfo_open')) {
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mime = $finfo->file($file['tmp_name']);
    } elseif (function_exists('mime_content_type')) {
        $mime = mime_content_type($file['tmp_name']);
    }

    if ($mime === false || $mime === null) {
        echo "No MIME type";
        return false;
    }

    if (!in_array($mime, $allowedTypes, true)) {
        echo "MIME type invalid " . $mime . "<br>";
        return false;
    }

    return true;


/* if ( in_array($_FILES["file"]["type"], $allowedTypes)
&& ($_FILES["file"]["size"] < parameters('maxfileuploadsize')) // 20000000
&& in_array($extension, $allowedExts)
//&& in_array(mime_content_type($_FILES["file"]["tmp_name"]), $allowedTypes)  
        )
  {
/*  if ($_FILES["file"]["error"] > 0)
    {
    echo "Return Code: " . $_FILES["file"]["error"] . "<br>";
    }else{
    return true;
    }*//*
}else
  {
  echo "Invalid file: " . $_FILES["file"]["type"] . "<br />";
  echo "Size: " . $_FILES["file"]["size"]/1024/1024 . "MB <br />";
  echo "Extention: " . $extension;
  echo "mime_content_type: " . $_FILES["file"]["tmp_name"];
return FALSE;
  }*/
}

function PodCastURL(){
    $PodCast = '';
    if (parameters('Podcast_URL')){
        $PodCast .= validate(parameters('Podcast_URL'),'hd');
    }else{

        $PodCast .= curURL(parameters('SSL'), 0);
 
    $PodCast .= dirname($_SERVER['PHP_SELF']);
        global $nofolder;
        if (!isset($nofolder) || $nofolder == 0){
            if (parameters('Podcast_Folder')){
                $PodCast .= '/'. validate(parameters('Podcast_Folder'),'hd');
            }else{
                $PodCast .= '/podcast';
            }
        }
    
    }
    return $PodCast;
    }
    
function Displaycaptcha(){
    //quick and dirty for the moment drop a hidden filed into the form
    echo "<label style=\"visibility:collapse\"> Leave blank</label>";
    echo "<input type=\"text\" name=\"Captcha\" value=\"\" style=\"visibility:collapse\">";
    
}

function CheckCaptcha(){
    if (!isset($_REQUEST['Captcha']) || strlen($_REQUEST['Captcha'] == 0)){
        echo "Captchaisset: " . '"' . ($_REQUEST['Captcha']) . '"';
        echo strlen($_REQUEST['Captcha']);
        return 'Fail';
    }else{
        return 'Pass';
    }
}

function Junk_Check($Check){
    $count = 0;
    
    $JunkCheck = strtolower(parameters('Junk_Check'));
    $JunkCheckArray = explode(PHP_EOL, trim($JunkCheck));
    str_replace($JunkCheckArray, ' ', strtolower($Check), $count);
    //echo "Check: " . strtolower($Check) . "<br />";
    //echo "JunkCheck: " . $JunkCheck . "<br />";
    //print_r($JunkCheckArray);
    //echo $count;
    if ($count != 0){
        return TRUE;
    }else{
        return FALSE;
    }
    }
?>
