<?php 
/*
echo 'content: ';
echo $target; 
if (isset($section)){
echo $section; 
}
if (isset($subsection)){
echo $subsection;
}
*/
// set up searches for content

$FromMenu = "tblmenu";
$SelectMenu = "UUID, target, section, subsection, Articles, ShortArticle, PublicPost, ContName";
$Select = "UUID, header, page, security, target, section, subsection, sdate, CDate, fdate, format, active, System, sortorder, lag(sortorder) OVER ( order by sortorder) AS previoussort, LEAD(sortorder) OVER ( order by sortorder) AS nextsort";
$From = "tblcontent";
$die = "404 ...  " ;

//$today = date("Y-m-d");

if (isset($_GET['Article'])){
    $where = "UUID = " . validate(decryptfe($_GET['Article']),'enc');
    $Limit = "1";
    $Sort = null;
    //echo "Article";
}else{
// check parameters
if (isset($target)){
//echo 'T: ' . $target;
	$where = "target='$target'";
}else{
    if((parameters('homepage') != null) && (parameters('homepage') != '')) {
        $target = parameters('homepage');
        $where = "target='$target'";
    }else{
        $where = "target='home'";
    }
}
//echo $where;
if (isset($section)){
	$where .= " and section='$section'";
}else{
	$where .= " and section IS NULL";
}
if (isset($subsection)){
	$where .= " and subsection='$subsection'";
}else{
    	$where .= " and subsection IS NULL";
}
$where .= " and Deleted!=1";

$whereMenu = $where;

//echo $whereMenu;

$Limit = null;
$sort = "sortorder, CDate Desc";

// find the max number of articles to show on page
$resultmenu = SQL($SelectMenu, $FromMenu, $die, $whereMenu, $Limit, null, null);
$rowmenu = fetch_array($resultmenu);
if (isset($rowmenu['ShortArticle'])){
  $short = validate($rowmenu['ShortArticle'],'n');  
}else {
    $short=null;
}
if (isset($rowmenu['Articles'])){
  $NoOfArticles = validate($rowmenu['Articles'],'n');
}else{
    $NoOfArticles = 0;
}
if (isset($rowmenu['PublicPost'])){
  $Public = validate($rowmenu['PublicPost'],'n');
}
if (isset($rowmenu['ContName'])){
  $NoOfArticles = validate($rowmenu['ContName'],'n');
}

//echo $NoOfArticles;
// get articles per page
//$pagelimit = parameter('Articles');

//  Limit the display to the maximum number of articles
    if(stripos($_SESSION['security'], 'editor') == false){
    if ($NoOfArticles != 0){
        $Limit = $NoOfArticles;
//echo 'here';
    }
}

    if(stripos($_SESSION['security'], $ArticleEditor) == false){
    $where .= " and active=1";
    
    $where .= " and ((now() between sdate and fdate)
    or (sdate IS NULL and fdate IS NULL)
    or (sdate IS NULL and now() <= fdate)
    or (now() >= sdate and fdate IS NULL)
    )";
}

// target, section, subsection, Deleted, SDate, page
// echo $where;
}
//echo $where;

$ContentResult = SQL($Select, $From, $die, $where, $Limit, null, $sort);

$ContentRows = num_rows($ContentResult);

// is there a databse record for parameters

// <!--page content goes here -->

// <!-- right column goes here -->
require "SideContent.php";

// <!-- Main Page Content goes here -->

require "MainContent.php";

//    <!-- end of content -->
