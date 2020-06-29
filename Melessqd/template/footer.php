    <?php
    global $system;
        if(!isset($system)){
                // page not a system page - allow article to be added
            
    if(preg_match("/".$ArticleEditor."/i", $_SESSION['security'])){
            // user is editor - open edit links
      echo "<tr>";
      echo "<td colspan=\"2\" align=\"center\">";
      echo "<a href=\"?target=Page_Edit&amp;section=edit&amp;etarget=$target";
          if (isset($section)) {echo "&amp;esection=$section";}
          if (isset($subsection)) {echo "&amp;esubsection=$subsection";}
          echo "\">Add Article</a>";
      echo "</td>";
      echo "</tr>";
     
  }elseif(isset($Public) && $Public == 1){
        // Public posting allowed - put link on page
        echo "<p class=\"small\">";
        echo "<a href=\"?target=Post&amp;section=post&amp;etarget=$target";
        echo "&amp;type=$ContType\">Post $ContType</a>";
        echo "</p>";
    }
  }
    ?>
<?php

if (isset($target)){
	if (isset($section)){
		if(file_exists("./Side/" . $section . ".foot.php")){
        		require_once "./Side/" . $section . ".foot.php";
		}
	}else{
		if(file_exists("./Side/" . $target . ".foot.php")){
			require_once "./Side/" . $target . ".foot.php";
		}
	}
}else{
	if(file_exists("./Side/home.foot.php")){
		require_once "./Side/home.foot.php";
	}
}

?>

<div id="right">
    <?php
    $copyright = parameters('Copyright');
if (strlen(trim($copyright)) != 0){
echo "<meta name=\"copyright\" content=\"" . $copyright . "\" />
";
}else{
    echo "&copy; ";
    global $incdate;
    if($incdate != date('Y')){
        echo $incdate . " - ";
    }
    global $Organisation;
            echo date('Y') . " " . $Organisation . "
";

}
    ?>
</div>
