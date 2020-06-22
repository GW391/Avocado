<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

?>       
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
