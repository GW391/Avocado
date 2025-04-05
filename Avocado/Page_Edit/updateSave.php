<?php
$system = true;
// is request to active article
if (isset($_REQUEST['Activate'])) {
        $ID = validate(decryptfe($_REQUEST['Activate']),'h');
        $select = 'UUID, target, section, subsection';
        $from = "tblcontent";
        $where = "UUID = '$ID'";


        $lookup = SQL($select, $from, null, $where, null, null, null);

        while ($row = fetch_assoc($lookup)) {
            $target = validate($row["target"],'h');
            if (isset($row["section"])){
            $section = validate($row["section"],'h');}else{
            unset( $section);}
            if (isset($row["subsection"])){
            $subsection = validate($row["subsection"],'h');}else{
            unset( $subsection);}
        }

        $num_rows = num_rows($lookup);
        // echo "Num_Rows = " .  $num_rows . "<br />";

        if ($num_rows == '1'){

            $update = "tblcontent";
            $set = "active = '1'";

            // whoupdate = '$WhoUpdate', Updated = '$DateUpdate' ";
            $where = "UUID = '$ID'";
            $limit = '1';
            $die = 'Sorry there has been a problem please try again ';

            $result = SQLU($update, $set, $where, $limit, $die);

            	echo "$target";
        if (isset($section)){
            echo ": " . $section;
        }

        if (isset($subsection)){
            echo ": " . $subsection;
        }
            echo " Activated <br />";
            require ('template/content.php');
        }


}elseif (isset($_REQUEST['Move'])) {
        $ID = validate(decryptfe($_REQUEST['Move']),'h');
        $SortOrder = validate(($_REQUEST['sortorder']),'n');
        $select = 'UUID, target, section, subsection';
        $from = "tblcontent";
        $where = "UUID = '$ID'";


        $lookup = SQL($select, $from, null, $where, null, null, null);

        while ($row = fetch_assoc($lookup)) {
            $target = trim(validate($row["target"],'h'));
            if (isset($row["section"])){
            $section = validate($row["section"],'h');}else{
            unset( $section);}
            if (isset($row["subsection"])){
            $subsection = validate($row["subsection"],'h');}else{
            unset( $subsection);}
        }

        $num_rows = num_rows($lookup);
        // echo "Num_Rows = " .  $num_rows . "<br />";

        if ($num_rows == '1'){

            $update = "tblcontent";
            $set = "sortorder = $SortOrder";

            // whoupdate = '$WhoUpdate', Updated = '$DateUpdate' ";
            $where = "UUID = '$ID'";
            $limit = '1';
            $die = 'Sorry there has been a problem please try again ';

            $result = SQLU($update, $set, $where, $limit, $die);

            	echo "$target";
        if (isset($section)){
            echo ": " . $section;
        }

        if (isset($subsection)){
            echo ": " . $subsection;
        }
            echo " Sorted <br />";
            require ('template/content.php');
        }


}else{
// if not activate set for add or update
   // if (!isset ($_POST[$security]) || strlen(trim($_POST[$security])) == 0){
  //  $security = null;
  //  }else{
$security = trim(validate($_POST['security'],'h'));
//}

if (isset($_POST['format'])){
    if(strlen(trim($_POST['format'])) != 0){
$format = validate($_POST['format'],'h');
}}
if (isset($_POST['active'])){
    if(strlen(trim($_POST['active'])) != 0){
$active = validate($_POST['active'],'n');
}}
if (isset($_POST['header'])){
//echo validate($_POST['header'],'h');
    if(strlen(trim($_POST['header'])) != 0){
$header = validate($_POST['header'],'h');
}else{
$header = null;
}}
$page = validate($_POST['page'],'h');
$WhoCreate = validate($_SESSION['puid'],'h');
$DateUpdate = Date('Ymd');
$WhoUpdate = validate($_SESSION['puid'],'h');
$DateCreate = Date('Ymd');
$sdate = validate($_POST['sdate'],'d');
$fdate = validate($_POST['fdate'],'d');
if (isset($_POST['System'])){
    if(strlen(trim($_POST['System'])) != 0){
        $SystemPage = validate($_POST['System'],'h');
}}

if (isset($_POST['etarget'])){
    if(strlen(trim($_POST['etarget'])) != 0){
        $etarget = validate($_POST['etarget'],'h');
}}
if (isset($_POST['esection'])){
    if(strlen(trim($_POST['esection'])) != 0){
        $esection = validate($_POST['esection'],'h');
}}
if (isset($_POST['esubsection'])){
    if(strlen(trim($_POST['esubsection'])) != 0){
        $esubsection = validate($_POST['esubsection'],'h');
}}

//does article exist if so update, ortherwise create.

if(isset($_POST['ID'])){

$ID = validate(decryptfe($_POST['ID']),'h');

$select = 'UUID, target, section, subsection';
$from = "tblcontent";
$where = "UUID = '$ID'";


$lookup = SQL($select, $from, null, $where, null, null, null);

while ($row = fetch_assoc($lookup)) {
    $target = $row["target"];
    $section = $row["section"];
    $subsection = $row["subsection"];
}

$num_rows = num_rows($lookup);
// echo "Num_Rows = " .  $num_rows . "<br />";


if ($num_rows == '1'){

  
$update = "tblcontent";
$set = "format = '$format', active = '$active', page = '$page', sdate = '$sdate', fdate = '$fdate'";
    if (!isset ($security) || strlen(trim($security)) == 0){
        $set.= ", security = null";
    }else{
        $set .= ", security = '$security'";
    }

    if (!isset ($etarget) || strlen(trim($etarget)) == 0){
        $set.= ", target = null";
    }else{
        $set .= ", target = '$etarget'";
    }
    if (!isset ($esection) || strlen(trim($esection)) == 0){
        $set.= ", section = null";
    }else{
        $set .= ", section = '$esection'";
    }
    if (!isset ($esubsection) || strlen(trim($esubsection)) == 0){
        $set.= ", subsection = null";
    }else{
        $set .= ", subsection = '$esubsection'";
    }
    if (!isset ($header) || strlen(trim($header)) == 0){
        $set.= ", header = null";
    }else{
        $set .= ", header = '$header'";
    }
    if (!isset ($SystemPage) || strlen(trim($SystemPage)) == 0){
        $set.= ", System = null";
    }else{
        $set .= ", System = '$SystemPage'";
    }

// whoupdate = '$WhoUpdate', Updated = '$DateUpdate' ";
$where = "UUID = '$ID'";
$limit = '1';
$die = 'Sorry there has been a problem please try again ';

$result = SQLU($update, $set, $where, $limit, $die);

	$message = "<strong>$target";
        if (isset($section)){
            $message .= ": " . $section;
        }

        if (isset($subsection)){
            $message .= ": " . $subsection;
        }

$message .= " Updated </strong> <br />";
$message .= "Sdate: $sdate";
//echo "</div>";
require ('template/content.php');

        }else{

echo "Nothing to do";
//}
}
}else{
    
    $etarget = validate($_POST['etarget'],'h');
    if (isset($_POST['esection'])){
    if(strlen(trim($_POST['esection'])) != 0){
        $esection = validate($_POST['esection'],'h');
}}
//    $esection = validate($_POST['esection'],'h');
if (isset($_POST['esubsection'])){
    if(strlen(trim($_POST['esubsection'])) != 0){
        $esection = validate($_POST['esubsection'],'h');
}}

//$esubsection = validate($_POST['esubsection'],'h');
if (isset($_POST['sortorder'])){
    if(strlen(trim($_POST['sortorder'])) != 0){
$sortorder = validate($_POST['sortorder'],'h');
}}

    if (!isset ($format) || strlen(trim($format)) == 0){

    }else{
        $cols = "format";
        $vals = "'$format'";
    }

    if (!isset ($security) || strlen(trim($security)) == 0){

    }else{
        $cols .= ", security";
        $vals .= ", '$security'";
    }
    
    if (!isset ($SystemPage) || strlen(trim($SystemPage)) == 0){
       $cols .= ", System";
       $vals .= ", NULL";
    }else{
        $cols .= ", System";
       $vals .= ", '$SystemPage'";
   }
   
    if (!isset ($page) || strlen(trim($page)) == 0){

    }else{
        $cols .= ", page";
        $vals .= ", '$page'";
    }
    if (!isset ($header) || strlen(trim($header)) == 0){

    }else{
        $cols .= ", header";
        $vals .= ", '$header'";
    }

    if (!isset($etarget) || strlen(trim($etarget)) == 0) {

    }else{
        $cols .= ", target";
        $vals .= ",'$etarget'";
        }
    if (!isset($esection) || strlen(trim($esection)) == 0){
    }else{
        $cols .= ", section";
        $vals .= ",'$esection'";
        }
    if (!isset($esubsection) || strlen(trim($esubsection)) == 0){
    }else{
        $cols .= ", subsection";
        $vals .= ",'$esubsection'";
        }
    if (!isset($sdate) || strlen(trim($sdate)) == 0){
    }else{
        $cols .= ", sdate";
        $vals .= ",'$sdate'";
        }
    if (!isset($fdate) || strlen(trim($fdate)) == 0){
    }else{
        $cols .= ", fdate";
        $vals .= ",'$fdate'";
        }
   if (!isset($sortorder) || strlen(trim($sortorder)) == 0){
    }else{
        $cols .= ", sortorder";
        $vals .= ",'$sortorder'";
        }

        
    $db = "tblcontent";
//    $cols = "page, target, section, subsection";
//    $vals = "'$page', '$etarget', '$esection', '$esubsection'";
    $die = "Sorry I have been unable to save the article";
 //   echo 'data compiled and ready to save';
 //    echo $cols;
 //   echo "<br />". $vals;
    $result = SQLI($db, $cols, $vals, $die);
    
    	$message = "$etarget";
        if (!isset($esection) || strlen(trim($esection)) == 0){
        }else{
            $message .= ": " . $esection;
        }

        if (!isset($esubsection) || strlen(trim($esubsection)) == 0){
        }else{
            $message .= ": " . $esubsection;
        }

    $message .= " Added <br />";
    $target = $etarget;
    if (!isset($esection) || strlen(trim($esection)) == 0){
    }else{
        $section = $esection;
    }
    if (!isset($esubsection) || strlen(trim($esubsection)) == 0){
    }else{
        $subsection = $esubsection;
    }
//echo "</div>";
require ('template/content.php');
}
    }
?>
