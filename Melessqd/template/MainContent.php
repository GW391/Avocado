<?php 
// display result message
// this is system messages, including welcome message on login, die message on failure etc.
if (isset($message)){
	echo validate($message, 'hd');
}
// display login message
// currently a hardcoded message can be displayed to all users at login, to change this message edit the 
// system/login/message.php file, you can use PHP in this file for dynamic content. 
require "System/login/message.php";

//display content from database

if ($ContentRows > 0){
while ($row = fetch_array($ContentResult))
  {

   $format=validate($row['format'],'hd');
   //check if database entry shows system page
   if (isset($row['System']) && strlen(trim($row['System']))!=0){
        $SystemPage= strtolower(validate($row['System'],'hd'));
        require "SystemContent.php";
   }else{
   

// check the security of the page, can we display
   if(stripos($_SESSION['security'], strval($row['security'])) !== false || $row['security'] == null || strlen($row['security']) == 0){

// is the page active or not
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
 
   //   display the header, if configured
   if (isset($row['header']) && strlen(trim($row['header'])) != 0 ){
     echo "<p>";
     // check if page format has been selected as text
   if (strtoupper($format) == 'TEXT'){
           // if data is text then add the header HTML from parameters and set new lines to <br /> tags
           $HeaderTag = parameters('HeaderTag');
           $HeadStart = substr($HeaderTag,0,strpos($HeaderTag,'Header'));
           $HeadEnd = substr($HeaderTag,strpos($HeaderTag,'Header')+6,strlen($HeaderTag));
           echo validate($HeadStart . nl2br(($row['header'])) . $HeadEnd, 'hd');
}else{
    // otherwise assume HTML and don't add <br /> or header HTML tags
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
          global $short; 
          if ($short){
              $ShortLength = parameters('ShortLength');
              // setup default short length to 500
              if (strlen(trim($ShortLength)) == 0){
                  $ShortLength = 500;
              }
// link not added if short page ends on space,  if numbers match add 10 characters.
  //             echo $ShortLength;
		while  ($ShortLength == strpos($page,' ',$ShortLength)){
		$ShortLength = $ShortLength+10;
}
          $page = substr($page,0,strpos($page,' ',$ShortLength)) . "<a href=\"";
            if (isset($target)) {
                $page = $page . "?target=$target";
            }
            if (isset($section)) {
                $page = $page . "&amp;section=$section";
            }
            if (isset($subsection)) {
            $page = $page . "&amp;subsection=$subsection";
            }
            $page = $page . "&amp;Article=" . urlencode(encryptfe($row['UUID'])) . "\"> ... more </a>";
            
      echo validate($page,'hd');  
    }else{
        global $page;
        echo validate($page,'hd');
}
//   }else {
//       echo "Sorry it looks like this page content may have been tampered with, it has been removed for your satey";
//   }
   echo "</p>";

    echo "</div>";
      if(stripos($_SESSION['security'], $ArticleEditor)){

      echo "<div id=\"edit\">";
      echo "&nbsp;&nbsp;&nbsp; <a href=\"?target=Page_Edit&amp;section=edit&amp;Edit=" . urlencode(encryptfe($row['UUID'])) . "\"> Edit </a>&nbsp;&nbsp;&nbsp;";
      if($row['active'] == 0){
      echo "&nbsp;&nbsp;&nbsp;<a href=\"?target=Page_Edit&amp;section=updateSave&amp;Activate=" . urlencode(encryptfe($row['UUID'])) . "\"> Activate </a>&nbsp;&nbsp;&nbsp;";
      }
      echo "&nbsp;&nbsp;&nbsp;<a href=\"?target=Page_Edit&amp;section=Delete&amp;DEL=" . urlencode(encryptfe($row['UUID'])) . "\"> Delete </a>&nbsp;&nbsp;&nbsp;";
      echo "&nbsp;&nbsp;&nbsp; <a href=\"?target=Page_Edit&amp;section=edit&amp;etarget=$target\">Add Article</a>";
      echo "</div>";
  }

  }elseif($ContentRows == 1){
      echo "Sorry you do not have the permission to view this page";
  }
  else{
      $ContentRows--;
  }  
  }}
}else{
 // no databse record, check for files that fit.
include "MainContentFile.php";
}
  /*     if(strpos($_SESSION['security'], $ArticleEditor)){
        echo "<div id=\"edit\">";
        
       echo "</div>";}
   * 
   */