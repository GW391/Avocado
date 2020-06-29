<!--page content goes here-->
<div id="maincontent">

    <!-- right column goes here-->
            <div id="rightcolumn">
<?php

$side="";
if (isset($target)){
	if (isset($section)){
		if (isset($subsection)){
			if(file_exists("Side/" . $subsection . ".side.php")){
        			require_once "./Side/" . $subsection . ".side.php";
                                $side="narrow";
			}
		}else{
			if(file_exists("Side/" . $section . ".side.php")){
        			require_once "./Side/" . $section . ".side.php";
                                $side="narrow";
			}
		}
	}else{
    if(file_exists("Side/" . $target . ".side.php")){
        require_once "./Side/" . $target . ".side.php";
        $side="narrow";
    }
}
}
else{
    if(file_exists("Side/home.side.php")){
        require_once "./Side/home.side.php";
        $side="narrow";
    }
}

?>
</div>

<?php 
if (isset($message)){
echo validate($message, 'hd');
}

?>


<?php

$FromMenu = "tblmenu";
$SelectMenu = "UUID, target, section, subsection, Articles, ShortArticle, PublicPost, ContName";

$Select = "UUID, header, page, security, target, section, subsection, sdate, fdate, format, active";
$From = "tblcontent";
$die = "404" ;

//$today = date("Y-m-d");

if (isset($_GET['Article'])){
    $where = "UUID = " . validate(decryptfe($_GET['Article']));
    $Limit = "1";
    $Sort = null;
    //echo "Article";
}else{
// check parameters
if (isset($target)){
	$where = "target='$target'";
}else{
    $where = "target='home'";
}
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
$sort = "CDate Desc";

// find the max number of articles to show on page
$resultmenu = SQL($SelectMenu, $FromMenu, $die, $whereMenu, $Limit, null, null);
$rowmenu = fetch_array($resultmenu);
$NoOfArticles = validate($rowmenu['Articles'],'n');
$short = validate($rowmenu['ShortArticle'],'n');
$Public = validate($rowmenu['PublicPost'],'n');
$ContType = validate($rowmenu['ContName'],'hd');

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

$result = SQL($Select, $From, $die, $where, $Limit, null, $sort);

$rows = num_rows($result);
//echo $rows;
//echo $Limit;
// is there a databse record for parameters

if ($rows > 0){
while ($row = fetch_array($result))
  {

    //echo $row['fdate'];
 
    /*      
            }
 */
   $format=validate($row['format'],'hd');
    //echo $format;
    //echo strtotime(("now")) . '--';
    //echo strtotime($row['sdate']);

if (stripos($_SESSION['security'], $row['security']) !== false || $row['security'] = null || strlen($row['security'])==0){

    if($row['active'] == 0){
echo "<div id=\"inactive" . $side . "\">";
echo "<div id=\"Edit" . $side . "\">";
        echo "Article Preview";
        echo "</div>";
    }elseif ( strtotime($row['sdate']) > strtotime("now")){
        echo "<div id=\"inactive" . $side . "\">";
        echo "<div id=\"Edit" . $side . "\">";
        echo "Automaticaly live on " . date('d-m-Y', strtotime($row['sdate']));
        echo "</div>";
   }else{
         echo "<div id=\"article" . $side . "\">";
   }
 
   //   if (sha1(validate(($row['page']))) = ){
   if (isset($row['header']) && strlen(trim($row['header'])) != 0 ){
     echo "<p>";
   if (strtoupper($format) == 'TEXT'){
           // if data is text then set new lines to <br />
           $HeaderTag = parameters('HeaderTag');
           $HeadStart = substr($HeaderTag,0,strpos($HeaderTag,'Header'));
           $HeadEnd = substr($HeaderTag,strpos($HeaderTag,'Header')+6,strlen($HeaderTag));
           echo validate($HeadStart . nl2br(($row['header'])) . $HeadEnd, 'hd');
}else{
    // otherwise assume HTML and don't add <br />
       echo validate(($row['header']), 'hd');
 }
   echo "</p>";
}
  echo "<p>";
   if (isset($row['page']) && strlen(trim($row['page'])) != 0 ){
       if (strtoupper($format) == 'TEXT'){
           // if data is text then set new lines to <br />
        $page =  nl2br($row['page']);
}else{
    // otherwise assume HTML and don't add <br />
       $page = ($row['page']);
     }
}
          // check if articles should be short
          if ($short){
              $ShortLength = parameters('ShortLength');
              // setup default short length to 500
              if (strlen(trim($ShortLength)) == 0){
                  $ShortLength = 500;
              }
              // echo $ShortLength;
              //$page = wordwrap($page, $ShortLength);
              $page = validate(substr($page,0,strpos($page,' ',$ShortLength)),'hd') . "<a href=\"?target=$target&amp;section=$section&amp;subsection=$subsection&amp;Article=" . urlencode(encryptfe($row['UUID'])) . "\"> ... more</a>";
//              echo validate($page,'hd');
             // echo validate($page,'hd');
      }
      
        echo validate($page,'hd');
        

//   }else {
//       echo "Sorry it looks like this page content may have been tampered with, it has been removed for your satey";
//   }
   echo "</p>";

    echo "</div>";

      if(stripos($_SESSION['security'], $ArticleEditor) !== false){
      echo "<div id=\"edit\">";
      echo "[<a href=\"?target=Page_Edit&amp;section=edit&amp;Edit=" . urlencode(encryptfe($row['UUID'])) . "\">Edit</a>]";
      if($row['active'] == 0){
      echo " [<a href=\"?target=Page_Edit&amp;section=updateSave&amp;Activate=" . urlencode(encryptfe($row['UUID'])) . "\">Activate</a>]";
      }
      echo "[<a href=\"?target=Page_Edit&amp;section=Delete&amp;DEL=" . urlencode(encryptfe($row['UUID'])) . "\">Delete</a>]";
      echo "</div>";
  }

  }elseif($rows == 1){
      echo "Sorry you do not have the permission to view this page";
  }
  else{
      $rows--;
  }  
  }
}else{
 // no databse record, check for files that fit.

if (isset($target)){
	if (isset($section)){
		if (isset($subsection)){
			if(file_exists($target . "/" . $section . "/" . $subsection  . ".php")){

	        		require_once "./" . $target . "/" . $section . "/" . $subsection . ".php";
			}else{
                              if(stripos($_SESSION['security'], $ArticleEditor) !== false){
                                                  
}elseif ($Public){  
}else{
        die(logerror('404'));
  }
		    	}
		}else{


			if(file_exists($target . "/" . $section . ".php")){

	        		require_once "./" . $target . "/" . $section . ".php";
			}else{

        		if(stripos($_SESSION['security'], $ArticleEditor) !== false){	          
                 
 }elseif ($Public){
}else{
        die(logerror('404'));
  }
	    		}
		}
}else{
 
    if(file_exists($target . ".php")){
        require_once "./" . $target . ".php";
    }else{

        if(stripos($_SESSION['security'], $ArticleEditor) !== false){
        echo "<p class=\"small\">";
        echo "<a href=\"?target=Page_Edit&amp;section=edit&amp;etarget=$target\">Add Article</a>";
        echo "</p>";
    }else{
            die(logerror('404'));
  }
    }
}
}else{
    // if no parameters go home
    require_once "home.php";
}
}


?>



