<?php

if(file_exists("System/" . $SystemPage . ".php")){
    require "System/" . $SystemPage . ".php";
}


/*
        if(strpos($_SESSION['security'], $ArticleEditor)){
            
      echo "<div id=\"edit\">";
      //echo "&nbsp;&nbsp;&nbsp; <a href=\"?target=Page_Edit&amp;section=edit&amp;Edit=" . urlencode(encryptfe($row['UUID'])) . "\"> Edit </a>&nbsp;&nbsp;&nbsp;";
      //if($row['active'] == 0){
      //echo "&nbsp;&nbsp;&nbsp;<a href=\"?target=Page_Edit&amp;section=updateSave&amp;Activate=" . urlencode(encryptfe($row['UUID'])) . "\"> Activate </a>&nbsp;&nbsp;&nbsp;";
      //}
      //echo "&nbsp;&nbsp;&nbsp;<a href=\"?target=Page_Edit&amp;section=Delete&amp;DEL=" . urlencode(encryptfe($row['UUID'])) . "\"> Delete </a>&nbsp;&nbsp;&nbsp;";
      echo "&nbsp;&nbsp;&nbsp;<a href=\"?target=Page_Edit&amp;section=edit&amp;etarget=$target\">Add Article</a>";
      echo "</div>";
        }
 */