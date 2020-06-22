<?php

if (isset($target)){
        // check for display name
        $Select = "target, dispname";
        $From = "tblmenu";
        $where = "section IS null and target = '$target'";
        $Limit = null;
        $die = "Sorry there is a problem on the page, please try again later.";
        $sort = null;

        $result = SQL($Select, $From, $die, $where, $Limit, $sort, null);
        $row=fetch_array($result);
        if (isset($row['dispname'])){
            $target_d = validate($row['dispname'], 'hd');
        }else{
            $target_d = validate($target, 'hd');
        }


    if (isset($section)){

        // check for display name
        $Select = "target, section, dispname";
        $From = "tblmenu";
        $where = "target = '$target' and section = '$section' and subsection IS null";
        $Limit = null;
        $die = "Sorry there is a problem on the page, please try again later.";
        $sort = null;

        $result = SQL($Select, $From, $die, $where, $Limit, $sort, null);
        $row=fetch_array($result);
        if (isset($row['dispname'])){
            $section_d = validate($row['dispname'], 'hd');
        }else{
            $section_d = validate($section, 'hd');
        }

        echo "<a href=\"?target=$target\" title=\"$target\">" . ucfirst($target_d) . "</a> : ";
        if (isset($subsection)){
        // check for display name
        $Select = "target, section, dispname";
        $From = "tblmenu";
        $where = "target = '$target' and section = '$section' and subsection = '$subsection'";
        $Limit = null;
        $die = "Sorry there is a problem on the page, please try again later.";
        $sort = null;

        $result = SQL($Select, $From, $die, $where, $Limit, $sort);
        $row=fetch_array($result);
        if (isset($row['dispname'])){
            $subsection_d = validate($row['dispname'], 'hd');
        }else{
            $subsection_d = validate($subsection, 'hd');
        }

            echo "<a href=\"?target=$target&amp;section=$section\" title=\"$section\">$section_d</a> : ";
            echo ucfirst($subsection_d);
        }else{
                echo ucfirst($section_d);
        }
    }else{
        echo ucfirst($target_d);
    }
}

?>



<div id="right">
<?php

if (isset($_SESSION['user'])){
	echo validate($_SESSION['user'],'hd');
    
    if (isset($target)){
        // check for display name
$link = "?target=$target";
        }
            if (isset($section)){
        // check for display name
$link .= "&amp;section=$section";
        }
             if (isset($subsection)){
        // check for display name
$link .= "&amp;subsection=$subsection";
        }
                     if (isset($article)){
        // check for display name
$link .= "&amp;article=$article";
        }
 
        echo " / <a href=\"" .  $link . "&amp;logout=true\">logout</a>";
}
?>
</div>
