<?php
$system = true;

if(preg_match("/".parameters('ArticleEditor')."/i", $_SESSION['security'])){

$security = "";
$deleted = "1";

$die = "Sorry there is a problem on this page, please try again later. ";

if (isset($_GET['DEL'])){

// Update

$UUID = validate(decryptfe($_GET['DEL']),'hd');

        $select = 'UUID, target, section, subsection';
        $from = "tblcontent";
        $lookupwhere = "UUID = '$UUID'";
        $lookupLimit = '1';


        $lookup = SQL($select, $from, null, $lookupwhere, $lookupLimit, null, null);

        while ($row = fetch_assoc($lookup)) {
            $target = validate($row["target"],'h');
            if (isset($row["section"])){
            $section = validate($row["section"],'h');}else{
            unset( $section);}
            if (isset($row["subsection"])){
            $subsection = validate($row["subsection"],'h');}else{
            unset( $subsection);}
        }


$where = "UUID = '$UUID'";
$update = "tblcontent";
$limit = "1";
$set = "Deleted = '$deleted'";


SQLU($update, $set, $where, $limit, $die);

$message = " Deleted";


}
}else{
    $message = "Sorry you don't heve permission to delete";

}

/*
$HTTP_REFERER =validate($_SERVER['HTTP_REFERER'],'hd');
$ref= explode("?",$HTTP_REFERER);
$query=validate($ref[1],'hd');
                        $div = explode("&",$query);
                        foreach($div as $var){
                        if(preg_match("/target=/",$var)){
$var = str_replace("target=","",$var);
$target = $var;
}
                        if(preg_match("/subsection=/",$var)){
$var = str_replace("subsection=","",$var);
$subsection = $var;
}
                        if(preg_match("/section=/",$var)){
$var = str_replace("section=","",$var);
$section = $var;
}
                        if(preg_match("/article=/",$var)){
$var = str_replace("article=","",$var);
$article = $var;
}
}*/
//echo "</div>";
require ('template/content.php');
?>
