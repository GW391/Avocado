<?php

if (isset($target)){
	if (isset($section)){
		if (isset($subsection)){
                    //check if file exists
			if(file_exists($target . "/" . $section . "/" . $subsection  . ".php")){
         		    require_once "./" . $target . "/" . $section . "/" . $subsection . ".php";
                            //if not try to see if it is a system file
                        }elseif (file_exists("System/" . $target . "/" . $section . "/" . $subsection  . ".php")){
                            require_once "./System/" . $target . "/" . $section . "/" . $subsection . ".php";
			}else{
                               if(stripos($_SESSION['security'], $ArticleEditor)){
                                    echo "<div id=\"edit\">";
                                    echo "&nbsp;&nbsp;&nbsp; <a href=\"?target=Page_Edit&amp;section=edit&amp;etarget=$target&amp;esection=$section&amp;esubsection=$subsection\">Add Article</a>";
                                    echo "</div>";
}elseif (isset($Public)){  
    // todo: set up public posting links
     //echo "public";
}else{
        die(logerror('404'));
  }
		    	}
		}else{


			if(file_exists($target . "/" . $section . ".php")){

	        		require_once "./" . $target . "/" . $section . ".php";
                        }elseif(file_exists("System/" . $target . "/" . $section . ".php")){

	        		require_once "./System/" . $target . "/" . $section . ".php";
			}else{
        			if(stripos($_SESSION['security'], $ArticleEditor)){
                                    echo "<div id=\"edit\">";
                                    echo "&nbsp;&nbsp;&nbsp; <a href=\"?target=Page_Edit&amp;section=edit&amp;etarget=$target&amp;esection=$section\">Add Article</a>";
                                    echo "</div>";
 }elseif (isset($Public)){
     // todo: set up public posting links
     //echo "public";
}else{
        die(logerror('404'));
  }
	    		}
		}
}else{
 
    if(file_exists($target . ".php")){
        require_once "./" . $target . ".php";
    }elseif(file_exists("System/" . $target . ".php")){
        require_once "./System/" . $target . ".php";
    }else{
        if(strpos($_SESSION['security'], $ArticleEditor)){
        echo "<div id=\"edit\">";
        echo "<a href=\"?target=Page_Edit&amp;section=edit&amp;etarget=$target\">Add Article</a>";
        echo "</div>";
    }elseif (isset($Public)){  
    // todo: set up public posting links
     //echo "public";
    }else{
            die(logerror('404'));
  }
    }
}
}else{
    // if no parameters go home
?>
<?php
    require_once "home.php";
}
