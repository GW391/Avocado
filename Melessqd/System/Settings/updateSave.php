<?php
$system = true;

if (isset($_POST['eDispName'])){
    $DispName = validate($_POST['eDispName'],'h');
}
if (isset($_POST['etarget'])){
    $target = validate($_POST['etarget'],'h');
}
if (isset($_POST['esection'])){
    $section = validate($_POST['esection'],'h');
}
if (isset($_POST['esubsection'])){
    $subsection = validate($_POST['esubsection'],'h');
}
if (isset($_POST['eextra'])){
    $extra = validate($_POST['eextra'],'h');
}
if (isset($_POST['esecurity'])){
    $security = validate($_POST['esecurity'],'h');
}

if (isset($_POST["esitemap"])){
    if (is_null($_POST["esitemap"]) || strlen($_POST["esitemap"])==0){
    $sitemap = 0;
}else{
    $sitemap = 1;
}}else{
    $sitemap = 0;
}

if (isset($_POST['esortorder'])){
    $sortorder = validate($_POST['esortorder'],'h');
}

//echo "ETLD: " . $_POST["eTLD"];
if (isset($_POST["eTLD"])){
    if (is_null($_POST["eTLD"]) || strlen($_POST["eTLD"])==0){
    $TLD = 0;
}else{
    $TLD = 1;
}}else{
    $TLD = 0;
}
//echo "TLD: " . $TLD;

if (isset($_POST['ehistory'])){
    $History = validate($_POST['ehistory'],'h');
}
if (isset($_POST['earticles'])){
    $Articles = validate($_POST['earticles'],'h');
}
if (isset($_POST['eShortArticle'])){
    $ShortArticle = validate($_POST['eShortArticle'],'n');
}
if (isset($_POST['deleted'])){
    $Deleted = validate($_POST['deleted'],'n');
}
$WhoCreate = validate($_SESSION['puid'],'h');
$DateUpdate = Date('Ymd');
$WhoUpdate = validate($_SESSION['puid'],'h');
$DateCreate = Date('Ymd');
if (isset($_POST['eContName'])){
    $ContName = validate($_POST['eContName'],'h');
}
if (isset($_POST['ePublic'])){
    $PublicPost = validate($_POST['ePublic'],'n');
}
//echo $ContName;

if(isset($_POST['ID'])){
//echo $_POST['ID'];
$ID = validate(decryptfe($_POST['ID']),'h');
//echo $ID;
$select = 'UUID, target';
$from = "tblmenu";
$where = "UUID = '$ID'";


$lookup = SQL($select, $from, null, $where, null, null, null);

$num_rows = num_rows($lookup);
//echo "Num_Rows = " .  $num_rows . "<br />";

if ($num_rows == '1'){

$update = "tblmenu";
$set = '';
//
// echo strlen(trim($DispName));

if (!isset($DispName) || strlen(trim($DispName)) == 0 ){
    // echo $DispName;
    $set .= "DispName = NULL";
}else{
    $set .= "DispName = '$DispName'";
}
//echo strlen(trim($section));
if (!isset($target) || strlen(trim($target)) == 0 ){
    $set .= ", target = NULL";
}else{
    $set .= ", target = '$target'";
}

//echo strlen(trim($section));

if (!isset($section) || strlen(trim($section)) == 0 ){
    $set .= ", section = NULL";
}else{
    $set .= ", section = '$section'";
}

if (!isset($subsection) || strlen(trim($subsection)) == 0 ){
//    echo "1";
    $set .= ", subsection = NULL";
}else{
//    echo "2";
    $set .= ", subsection = '$subsection'";
}
if (!isset($extra) || strlen(trim($extra)) == 0 ){
//    echo "1";
    $set .= ", extra = NULL";
}else{
//    echo "2";
    $set .= ", extra = '$extra'";
}
if (!isset($security) || strlen(trim($security)) == 0 ){
     $set .= ", security = NULL";
}else{
    $set .= ", security = '$security'";
}
if (!isset($sitemap) || strlen(trim($sitemap)) == 0 ){
     $set .= ", sitemap = 0";
}else{
    $set .= ", sitemap = '$sitemap'";
}
if (!isset($sortorder) || strlen(trim($sortorder)) == 0 ){
    $set .= ", sortorder = NULL";
}else{
    $set .= ", sortorder = '$sortorder'";
}
    echo $TLD;
if (!isset($TLD) || strlen(trim($TLD)) == 0 ){
    $set .= ", TLD = 0";
}else{
    $set .= ", TLD = '$TLD'";
}
if (!isset($History) || strlen(trim($History)) == 0 ){
    $set .= ", History = 0";
}else{
    $set .= ", History = '$History'";
}
if (!isset ($Articles) || strlen(trim($Articles)) == 0 ){
    $set .= ", Articles = 1";
}else{
    $set .= ", Articles = '$Articles'";
}
if (!isset ($ShortArticle) || strlen(trim($ShortArticle)) == 0 ){
    $set .= ", ShortArticle = 0";
}else{
    $set .= ", ShortArticle = '$ShortArticle'";
}
if (!isset($Deleted) || strlen(trim($Deleted)) == 0 || $Deleted == 0){
    $set .= ", deleted = 0";
}else{
    $set = "deleted = '$Deleted'";
}
  if (!isset ($PublicPost) || strlen(trim($PublicPost)) == 0 ){
      $set .= ", PublicPost = 0";
    }else{
    $set .= ", PublicPost = '$PublicPost'";
}
  if (!isset ($ContName) || strlen(trim($ContName)) == 0 ){
   $set .= ", ContName = NULL";
 }else{
    $set .= ", ContName = '$ContName'";
}

$set .= ", UDate = '$DateUpdate', whoupdate = '$WhoUpdate'";

// echo $set;

// whoupdate = '$WhoUpdate', Updated = '$DateUpdate' ";
$where = "UUID = '$ID'";
$limit = '1';
$die = 'Sorry there has been a problem please try again ';

$result = SQLU($update, $set, $where, $limit, $die, null, null);

	echo "<center><h2>Menu item $DispName ";
if (isset($Deleted) && $Deleted == '1'){
echo "Deleted";
}else{
echo "Updated";
}
echo "</h2></center>";
}else{

echo "Nothing to do";
//}
}
}else{
    
  $cols = "WhoCreate, DateCreate";
  $vals = "'$WhoCreate','$DateCreate'";


    if (!isset ($DispName) || strlen(trim($DispName)) == 0){

    }else{
        $cols .= ", DispName";
        $vals .= ",'$DispName'";
    }

    if (!isset($target) || strlen(trim($target)) == 0) {

    }else{
        $cols .= ", target";
        $vals .= ",'$target'";
        }
    if (!isset($section) || strlen(trim($section)) == 0){
    }else{
        $cols .= ", section";
        $vals .= ",'$section'";
        }
    if (!isset($subsection) || strlen(trim($subsection)) == 0){
    }else{
        $cols .= ", subsection";
        $vals .= ",'$subsection'";
        }
    if (!isset($extra) || strlen(trim($extra)) == 0){
    }else{
        $cols .= ", extra";
        $vals .= ",'$extra'";
        }
    if (!isset($security) || strlen(trim($security)) == 0){
    }else{
        $cols .= ", security";
        $vals .= ",'$security'";
        }
    if (!isset($sitemap) || strlen(trim($sitemap)) == 0){
    }else{
        $cols .= ", sitemap";
        $vals .= ",'$sitemap'";
        }
    if (!isset($sortorder) || strlen(trim($sortorder)) == 0){
    }else{
        $cols .= ", sortorder";
        $vals .= ",'$sortorder'";
        }


    if (!isset($TLD) || strlen(trim($TLD)) == 0 || $TLD == 0){
        $cols .= ", TLD";
        $vals .= ",'0'";
    }else{
        $cols .= ", TLD";
        $vals .= ",'1'";
        }

    if (!isset($History) || strlen(trim($History)) == 0){
    }else{
        $cols .= ", History";
        $vals .= ",'$History'";
        }

    if (!isset($Articles) || strlen(trim($Articles)) == 0){
    }else{
        $cols .= ", Articles";
        $vals .= ",'$Articles'";
        }
   if (!isset ($ShortArticle) || strlen(trim($ShortArticle)) == 0 ){
    }else{
    $cols .= ", ShortArticle";
    $vals .= ",'$ShortArticle'";
}
   if (!isset ($PublicPost) || strlen(trim($PublicPost)) == 0 ){
    }else{
    $cols .= ", PublicPost";
    $vals .= ",'$PublicPost'";
}
  if (!isset ($ContName) || strlen(trim($ContName)) == 0 ){
    }else{
    $cols .= ", ContName";
    $vals .= ",'$ContName'";
}
    $db = "tblmenu";
//    $cols = "page, target, section, subsection";
//    $vals = "'$page', '$etarget', '$esection', '$esubsection'";
    $die = "Sorry I have been unable to save the new menu";
    $result = SQLI($db, $cols, $vals, $die, null, null, null);

    echo "Menu item $DispName Added <br />";
}

require ('Menu.php');

?>