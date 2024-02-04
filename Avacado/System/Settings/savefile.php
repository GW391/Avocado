<?php
$system = true;

//check security
if(preg_match("/".'editor'."/i", $_SESSION['security'])){

if(isset($_POST['UUID'])){
    // editing record
    echo "Editing record \n\r";
    $ID = validate(decryptfe($_POST['UUID']),'h');
    $edit = true;
    $set ="";
}else{
    $edit = false;
 // adding new record
}
if (isset($_FILES["file"]["name"]) and strlen(trim($_FILES["file"]["name"])) != 0){
if (upload_check()){

$file_name = validate($_FILES["file"]["name"],'h');
$file_type = validate($_FILES["file"]["type"],'h');
//$file_type = validate($_POST['FileType'],'h');
$Size = validate($_FILES["file"]["size"],'n') / 1024;
}}

if (isset($_POST['type'])){
    if(strlen(trim($_POST['type'])) != 0){
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
if (isset($_POST['Duration'])){
    if(strlen(trim($_POST['Duration'])) != 0){
    $Duration = validate($_POST['Duration'],'h');
}}

if (!$edit){
$WhoCreate = validate($_SESSION['puid'],'h');
$DateCreate = Date('Ymd');
}
if ($edit){
$DateUpdate = Date('Ymd');
$WhoUpdate = validate($_SESSION['puid'],'h');
}

echo "type: ". $type;
switch ($type){
    case "podcast":
 //   echo "podcast";
        if (null == (parameters('Podcast_Folder')) || strlen(parameters('Podcast_Folder')) == 0){
            $location = "podcast";
        }else{
            $location = parameters('Podcast_Folder');
        }
        echo $location . "< /br>";
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
if (!isset ($location) || strlen(trim($location)) == 0){
}else{
    echo "location: " . $location . "<br />";
}
if (!isset ($file_name) || strlen(trim($file_name)) == 0){
}else{
    echo "Upload: " . $file_name . "<br />";
}
if (!isset ($file_type) || strlen(trim($file_type)) == 0){
}else{
    echo "file_Type: " . $file_type . "<br />";
}
if (!isset ($Size) || strlen(trim($Size)) == 0){
}else{
    echo "Size: " . $Size  . " kB<br />" ;
}
//  echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br>";

    // check if the folder exists, if not create, before moving file into it.
    if ( !file_exists( $location ) && !is_dir( $location ) ) {
     mkdir($location);
    }
if (!isset ($file_name) || strlen(trim($file_name)) == 0){
}else{
    if (file_exists("$location/" . $file_name) || !$edit)
      {
      echo $file_name . " already exists. ";
      }
    else
     {
      echo move_uploaded_file($_FILES["file"]["tmp_name"], "$location/" . $file_name);
      echo "Stored in: " . "$location/" . $file_name;
      $filetime = validate(filectime($location ."/" . $file_name),'h');
      }
}

    if (!isset ($file_name) || strlen(trim($file_name)) == 0){
    }else{
        if ($edit){
            if (isset($set) && strlen(trim($set)) != 0){
                $set .= ', ';
            }
            $set .= "file_name = '$file_name'";
    }else{
        $cols = "file_name";
        $vals = "'$file_name'";
    }
}
    
    if (!isset ($name) || strlen(trim($name)) == 0){
          //  echo "I have no name";
    }else{
        if ($edit){
            if (isset($set) && strlen(trim($set)) != 0){
                $set .= ', ';
            }
            $set .= "name = '$name'";
        }else{
        $cols .= ", name";
        $vals .= ", '$name'";
    }}
    
    if (!isset ($Size) || strlen(trim($Size)) == 0){

    }else{
        if ($edit){
            if (isset($set) && strlen(trim($set)) != 0){
                $set .= ', ';
            }
            $set .= "size = '$Size'";
        }else{
        $cols .= ", size";
        $vals .= ", '$Size'";
    }}
    if (!isset ($type) || strlen(trim($type)) == 0){

    }else{
        if ($edit){
            if (isset($set) && strlen(trim($set)) != 0){
                $set .= ', ';
            }
            $set .= "type = '$type'";
        }else{
        $cols .= ", type";
        $vals .= ", '$type'";
    }}
    
    if (!isset ($file_type) || strlen(trim($file_type)) == 0){

    }else{
        if ($edit){
            if (isset($set) && strlen(trim($set)) != 0){
                $set .= ', ';
            }
            $set .= "file_type = '$file_type'";
        }else{
        $cols .= ", file_type";
        $vals .= ", '$file_type'";
    }}
    

    if (!isset ($Meta_1) || strlen(trim($Meta_1)) == 0){

    }else{
         if ($edit){
            if (isset($set) && strlen(trim($set)) != 0){
                $set .= ', ';
            }
            $set .= "Meta_1 = '$Meta_1'";
        }else{
        $cols .= ", Meta_1";
        $vals .= ", '$Meta_1'";
    }}
    
    if (!isset ($Meta_2) || strlen(trim($Meta_2)) == 0){

    }else{
        if ($edit){
            if (isset($set) && strlen(trim($set)) != 0){
                $set .= ', ';
            }
            $set .= "Meta_2 = '$Meta_2'";
        }else{
        $cols .= ", Meta_2";
        $vals .= ", '$Meta_2'";
    }}
    
    if (!isset ($Meta_3) || strlen(trim($Meta_3)) == 0){

    }else{
        if ($edit){
            if (isset($set) && strlen(trim($set)) != 0){
                $set .= ', ';
            }
            $set .= "Meta_3 = '$Meta_3'";
        }else{
        $cols .= ", Meta_3";
        $vals .= ", '$Meta_3'";
    }}
    
    if (!isset ($Meta_4) || strlen(trim($Meta_4)) == 0){

    }else{
        if ($edit){
            if (isset($set) && strlen(trim($set)) != 0){
                $set .= ', ';
            }
            $set .= "Meta_4 = '$Meta_4'";
        }else{
        $cols .= ", Meta_4";
        $vals .= ", '$Meta_4'";
    }}
    if (!isset ($Description) || strlen(trim($Description)) == 0){

    }else{
        if ($edit){
            if (isset($set) && strlen(trim($set)) != 0){
                $set .= ', ';
            }
            $set .= "Description = '$Description'";
        }else{
        $cols .= ", Description";
        $vals .= ", '$Description'";
    }}
    if (!isset ($WhoCreate) || strlen(trim($WhoCreate)) == 0){

    }else{
        if ($edit){
            // do nothing, filed only used when creating.
        }else{
        $cols .= ", WhoCreate";
        $vals .= ", '$WhoCreate'";
    }}
    if (!isset ($DateCreate) || strlen(trim($DateCreate)) == 0){

    }else{
        if ($edit){
            // do nothing, filed only used when creating.
        }else{
        $cols .= ", DateCreate";
        $vals .= ", '$DateCreate'";
    }}

        if (!isset ($WhoUpdate) || strlen(trim($WhoUpdate)) == 0){

    }else{
        if ($edit){
            if (isset($set) && strlen(trim($set)) != 0){
                $set .= ', ';
            }
            $set .= "WhoUpdate = '$WhoUpdate'";
        }else{
            // do nothing, filed only used when creating.
    }}
    if (!isset ($DateUpdate) || strlen(trim($DateUpdate)) == 0){

    }else{
        if ($edit){
            if (isset($set) && strlen(trim($set)) != 0){
                $set .= ', ';
            }
            $set .= "DateUpdate = '$DateUpdate'";
        }else{
            // do nothing, filed only used when creating.
    }}


    if (!isset ($Date) || strlen(trim($Date)) == 0){

    }else{
        if ($edit){
            if (isset($set) && strlen(trim($set)) != 0){
                $set .= ', ';
            }
            $set .= "Date = '$Date'";
        }else{
        $cols .= ", Date";
        $vals .= ", '$Date'";
    }}

        if (!isset ($Duration) || strlen(trim($Duration)) == 0){

    }else{
        if ($edit){
            if (isset($set) && strlen(trim($set)) != 0){
                $set .= ', ';
            }
            $set .= "Duration = '$Duration'";
        }else{
        $cols .= ", Duration";
        $vals .= ", '$Duration'";
    }}

if (!isset ($filetime) || strlen(trim($filetime)) == 0){

    }else{
        if ($edit){
            if (isset($set) && strlen(trim($set)) != 0){
                $set .= ', ';
            }
            $set .= "FileTime = '$filetime'";
        }else{
        $cols .= ", FileTime";
        $vals .= ", '$filetime'";
    }}
 
// Add / update file to databse :
    $db = "tblattachment";
    $die = "Sorry I have been unable to save the" . $type;
    if ($edit){
        echo 'edit';
        $update = "tblsettings";
        $where = "UUID = '$ID'";
        $limit = '1';
        $result = SQLU($db, $set, $where, $limit, $die);
    }else{
        $result = SQLI($db, $cols, $vals, $die, null, null, null);
    }

// end security check
}else{

echo parameters('PermissionsMessage');
}
?> 



