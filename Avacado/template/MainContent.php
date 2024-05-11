<?php 

//echo 'maincontent';
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
while ($Pagerow = fetch_array($ContentResult))
  {
  unset($page);

   $format=validate($Pagerow['format'],'hd');
   //check if database entry shows system page
   if (isset($Pagerow['System']) && strlen(trim($Pagerow['System']))!=0){
    if (isset($Pagerow['page']) && strlen(trim($Pagerow['page']))!=0){
     $Page = validate($Pagerow['page'],'hd');
}
        $SystemPage= validate($Pagerow['System'],'hd');
        require "SystemContent.php";
   }else{
   

// check the security of the page, can we display
   if(stripos($_SESSION['security'], strval($Pagerow['security'])) !== false || $Pagerow['security'] == null || strlen($Pagerow['security']) == 0){

// is the page active or not
    if($Pagerow['active'] == 0){
echo "<div id=\"inactive" . $side . "\">";
echo "<div id=\"Edit" . $side . "\">";
        echo "Article Preview";
        echo "</div>";
    }elseif ( strtotime($Pagerow['sdate']) > strtotime("now")){
        echo "<div id=\"inactive" . $side . "\">";
        echo "<div id=\"Edit" . $side . "\">";
        echo "Automaticaly live on " . date('d-m-Y', strtotime($Pagerow['sdate']));
        echo "</div>";
   }else{
         echo "<div id=\"article" . $side . "\">";
   }
 
   //   display the header, if configured
   if (isset($Pagerow['header']) && strlen(trim($Pagerow['header'])) != 0 ){
     echo "<p>";
     // check if page format has been selected as text
   if (strtoupper($format) == 'TEXT'){
           // if data is text then add the header HTML from parameters and set new lines to <br /> tags
           $HeaderTag = parameters('HeaderTag');
           $HeadStart = substr($HeaderTag,0,strpos($HeaderTag,'Header'));
           $HeadEnd = substr($HeaderTag,strpos($HeaderTag,'Header')+6,strlen($HeaderTag));
           echo validate($HeadStart . nl2br(($Pagerow['header'])) . $HeadEnd, 'hd');
}else{
    // otherwise assume HTML and don't add <br /> or header HTML tags
       echo validate(($Pagerow['header']), 'hd');
 }
   echo "</p>";
}
  echo "<p>";
   if (isset($Pagerow['page']) && strlen(trim($Pagerow['page'])) != 0 ){
       if (strtoupper($format) == 'TEXT'){
           // if data is text then set new lines to <br />
        $page =  nl2br($Pagerow['page']);
        }else{
    // otherwise assume HTML and don't add <br />
      $page = ($Pagerow['page']);
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
            $page = $page . "&amp;Article=" . urlencode(encryptfe($Pagerow['UUID'])) . "\"> ... more </a>";
            
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
  // }
      

  }elseif($ContentRows == 1){
      echo "Sorry you do not have the permission to view this page";
  }
  else{
      $ContentRows--;
  }  
  }
  
  if(stripos($_SESSION['security'], $ArticleEditor)){

      echo "<div id=\"edit\">";
      if (isset ($Pagerow['previoussort']) and ($Pagerow['previoussort'] != NULL)){
      $previoustsort = validate($Pagerow['previoussort'],'n')-1;
      echo "&nbsp;&nbsp;&nbsp;<a href=\"?target=Page_Edit&amp;section=updateSave&amp;Move=" . urlencode(encryptfe($Pagerow['UUID'])) . "&amp;sortorder=" . $previoustsort . "\"> Move Up </a>&nbsp;&nbsp;&nbsp;";
      }
      if(isset($Pagerow['UUID'])){
      echo "&nbsp;&nbsp;&nbsp; <a href=\"?target=Page_Edit&amp;section=edit&amp;Edit=" . urlencode(encryptfe($Pagerow['UUID'])) . "\"> Edit </a>&nbsp;&nbsp;&nbsp;";
      if(isset($Pagerow['active']) and $Pagerow['active'] == 0){
          echo "&nbsp;&nbsp;&nbsp;<a href=\"?target=Page_Edit&amp;section=updateSave&amp;Activate=" . urlencode(encryptfe($Pagerow['UUID'])) . "\"> Activate </a>&nbsp;&nbsp;&nbsp;";
      }
      echo "&nbsp;&nbsp;&nbsp;<a href=\"?target=Page_Edit&amp;section=Delete&amp;DEL=" . urlencode(encryptfe($Pagerow['UUID'])) . "\"> Delete </a>&nbsp;&nbsp;&nbsp;";
      }
      ?>
      <?php
      /*
                    <form method="post" name="na<?php echo validate(encryptfe($Pagerow['uuid']),'enc')?>" action="?target=Page_Edit&amp;section=edit">
            <input type="hidden" name="etarget" value="<?php echo $target?>" />
            <input type="hidden" name="esection" value="<?php echo $section?>" />
            <input type="hidden" name="esubsection" value="<?php echo $subsection?>" />
            <input type="submit" name="submit" value="Add Article" />
	<button class="custombutton" type="submit" name="Add Article" value="New">
            <img src="images/icons/detail.png" alt="Add Article" name="Add Article" title="Add Article" />
        </button>
        </form>
*/?>
        <?php      
      echo "&nbsp;&nbsp;&nbsp; <a href=\"?target=Page_Edit&amp;section=edit&amp;etarget=$target";
      if(isset($section)){
      echo "&amp;esection=$section";
      }
      if(isset($subsection)){
      echo "&amp;esubsection=$subsection";
      }
      echo "&amp;sortorder=" . validate($Pagerow['nextsort'],'n');
      echo "\">Add Article</a>";

      
    if (isset ($Pagerow['nextsort']) and ($Pagerow['nextsort'] != NULL)){
      $nextsort = validate($Pagerow['nextsort'],'n')+1;
      echo "&nbsp;&nbsp;&nbsp;<a href=\"?target=Page_Edit&amp;section=updateSave&amp;Move=" . urlencode(encryptfe($Pagerow['UUID'])) . "&amp;sortorder=" . $nextsort . "\"> Move Down </a>&nbsp;&nbsp;&nbsp;";
      }

      echo "</div>";
      
  }
  
  }
}else{
 // no databse record, check for files that fit.
include "MainContentFile.php";
}


  /*     if(strpos($_SESSION['security'], $ArticleEditor)){
        echo "<div id=\"edit\">";
        
       echo "</div>";}
   * 
   */
