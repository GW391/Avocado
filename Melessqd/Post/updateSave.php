<?php
$system = true;

$security = trim(validate($_POST['security'],'h'));

$format = 'HTML';
$active = validate($_POST['active'],'n');
$header = validate($_POST['header'],'h');
$page = validate($_POST['page'],'h');
$WhoCreate = validate($_SESSION['puid'],'h');
$DateUpdate = Date('Ymd');
$WhoUpdate = validate($_SESSION['puid'],'h');
$DateCreate = Date('Ymd');
$sdate = validate($_POST['sdate'],'d');
$fdate = validate($_POST['fdate'],'d');
$content = validate($_POST['Content'],'h');
//TODO: Check validation of email address.
$email = validate($_POST['email'],'h');



//does article exist if so update, ortherwise create.

if(isset($_POST['ID'])){

$ID = validate(decryptfe($_POST['ID']),'h');

$select = 'UUID, target, section, subsection';
$from = "tblcontent";
$where = "UUID = '$ID'";


$lookup = SQL($select, $from, null, $where, null, null);

while ($row = fetch_assoc($lookup)) {
    $target = $row["target"];
    $section = $row["section"];
    $subsection = $row["subsection"];
}

$num_rows = num_rows($lookup);
// echo "Num_Rows = " .  $num_rows . "<br />";


if ($num_rows == '1'){

$update = "tblcontent";
$set = "security = '$security', format = '$format', active = '$active', header = '$header',  page = '$page', sdate = '$sdate', fdate = '$fdate'";

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
echo "</div>";
require ('./template/content.php');

        }else{

echo "Nothing to do";
}
}else{
    
    $etarget = validate($_POST['etarget'],'h');
    $esection = validate($_POST['esection'],'h');
    $esubsection = validate($_POST['esubsection'],'h');


    if (!isset ($format) || strlen(trim($format)) == 0){

    }else{
        $cols .= "format";
        $vals .= "'$format'";
    }

    if (!isset ($security) || strlen(trim($security)) == 0){

    }else{
        $cols .= "security";
        $vals .= "'$security'";
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

    if (!isset($etarget) || strlen(trim(etarget)) == 0) {

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

    $db = "tblcontent";
    $die = "Sorry I have been unable to save the post";
    $result = SQLI($db, $cols, $vals, $die);

    $ToEmail = parameters('ArticleApproverEmailAddress');
    $body = $page . '  ' .  " Please log into the website to approve the $content" ;
    mail($ToEmail, "Subject: $subject",
    $body, "From: $email" );
    //
    echo "<p>Your ". $content . " has been posted and will appear shortly \n <br /></p>";

    	$message = "$etarget";
        if (isset($esection)){
            $message .= ": " . $esection;
        }

        if (isset($esubsection)){
            $message .= ": " . $esubsection;
        }

    $message .= "<br />
    <h2>Thank you for your ";
    $message .= $content;
    $message .= " it has been added and will appear shortly</h2><br />";
echo "</div>";

require ('template/content.php');
}


?>