<?php
$system = true;

if (upload_check()){

$file_name = validate($_FILES["file"]["name"],'h');
$file_type = validate($_FILES["file"]["type"],'h');
//$file_type = validate($_POST['FileType'],'h');
$Size = validate($_FILES["file"]["size"],'n') / 1024;

echo "type: "  . $_POST['type'];


if (isset($_POST['type'])){
    if(strlen(trim($_POST['type'])) != 0){
    echo "Type: " . $_POST['type'];
$type = validate($_POST['type'],'h');
}}

if (isset($_POST['name'])){
    if(strlen(trim($_POST['name'])) != 0){
$name = validate($_POST['name'],'h');
echo "Name: " . $name ;
}}

if (isset($_POST['Meta_1'])){
    if(strlen(trim($_POST['Meta_1'])) != 0){
$Meta_1 = validate($_POST['Meta_1'],'h');
}}

if (isset($_POST['Meta_2'])){
    if(strlen(trim($_POST['Meta_2'])) != 0){
$Meta_2 = validate($_POST['Meta_2'],'h');
}}
if (isset($_POST['Meta_3'])){
    if(strlen(trim($_POST['Meta_3'])) != 0){
$Meta_3 = validate($_POST['Meta_3'],'h');
}}
if (isset($_POST['Meta_4'])){
    if(strlen(trim($_POST['Meta_4'])) != 0){
$Meta_4 = validate($_POST['Meta_4'],'h');
}}
if (isset($_POST['Description'])){
    if(strlen(trim($_POST['Description'])) != 0){
$Description = validate($_POST['Description'],'h');
}}
if (isset($_POST['Date'])){
    if(strlen(trim($_POST['Date'])) != 0){
    $Date = validate($_POST['Date'],'d');
}}else{
    $Date = Date('Ymd');
}

$WhoCreate = validate($_SESSION['puid'],'h');
$DateUpdate = Date('Ymd');
$WhoUpdate = validate($_SESSION['puid'],'h');
$DateCreate = Date('Ymd'); 


echo "type: ". $type;
switch ($type){
    case "podcast":
 //   echo "podcast";
        if (null !== (parameters('Podcast_Folder')) || strlen(parameters('Podcast_Folder')) == 0){
            $location = "podcast";
        }else{
            $location = parameters('Podcast_Folder');
        }
        break;
    case "news":
      //  echo "news";
        $location = "news";
        break;
    case "images":
        $location = "images";
        break;
    case "icons":
        $location = "images/icons";
        break;
    case "bookcovers":
        $location = "images/covers";
        break;
    default:
        $location = "attachments";
        break;
}
echo "location: " . $location;
    echo "Upload: " . $file_name . "<br>";
    echo "file_Type: " . $file_type . "<br>";
    echo "Size: " . $Size  . " kB<br>" ;
//  echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br>";

    if (file_exists("$location/" . $_FILES["file"]["name"]))
      {
      echo $_FILES["file"]["name"] . " already exists. ";
      }
    else
     {
      echo move_uploaded_file($_FILES["file"]["tmp_name"], "$location/" . $_FILES["file"]["name"]);
      echo "Stored in: " . "$location/" . $_FILES["file"]["name"];
      }
    }
    if (!isset ($file_name) || strlen(trim($file_name)) == 0){

    }else{
        $cols = "file_name";
        $vals = "'$file_name'";
    }
    
    if (!isset ($name) || strlen(trim($name)) == 0){
echo "I have no name";
    }else{
        $cols .= ", name";
        $vals .= ", '$name'";
    }
    
    if (!isset ($Size) || strlen(trim($Size)) == 0){

    }else{
        $cols .= ", size";
        $vals .= ", '$Size'";
    }
    if (!isset ($type) || strlen(trim($type)) == 0){

    }else{
        $cols .= ", type";
        $vals .= ", '$type'";
    }
    
    if (!isset ($file_type) || strlen(trim($file_type)) == 0){

    }else{
        $cols .= ", file_type";
        $vals .= ", '$file_type'";
    }
    

    if (!isset ($Meta_1) || strlen(trim($Meta_1)) == 0){

    }else{
        $cols .= ", Meta_1";
        $vals .= ", '$Meta_1'";
    }
    
    if (!isset ($Meta_2) || strlen(trim($Meta_2)) == 0){

    }else{
        $cols .= ", Meta_2";
        $vals .= ", '$Meta_2'";
    }
    
    if (!isset ($Meta_3) || strlen(trim($Meta_3)) == 0){

    }else{
        $cols .= ", Meta_3";
        $vals .= ", '$Meta_3'";
    }
    
    if (!isset ($Meta_4) || strlen(trim($Meta_4)) == 0){

    }else{
        $cols .= ", Meta_4";
        $vals .= ", '$Meta_4'";
    }
    if (!isset ($Description) || strlen(trim($Description)) == 0){

    }else{
        $cols .= ", Description";
        $vals .= ", '$Description'";
    }
    if (!isset ($WhoCreate) || strlen(trim($WhoCreate)) == 0){

    }else{
        $cols .= ", WhoCreate";
        $vals .= ", '$WhoCreate'";
    }
    if (!isset ($DateCreate) || strlen(trim($DateCreate)) == 0){

    }else{
        $cols .= ", DateCreate";
        $vals .= ", '$DateCreate'";
    }
    if (!isset ($Date) || strlen(trim($Date)) == 0){

    }else{
        $cols .= ", Date";
        $vals .= ", '$Date'";
    }
    
 
// Add file to databse : 
    $db = "tblattachment";
    $die = "Sorry I have been unable to save the" . $type;
    $result = SQLI($db, $cols, $vals, $die, null, null, null);

// require ('images.php');
?> 



