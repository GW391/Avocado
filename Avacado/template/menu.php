<div class="box">
	<a class="button" href="#menu1">
        <div class="menuicon_container">
	    <div class="menuicon_menu-Line"></div>
	    <div class="menuicon_menu-Line"></div>
	    <div class="menuicon_menu-Line"></div>
        </div>
        </a>
</div>

<div id="menu1" class="Menucontainer">
<div id="menu">
    <a class="close" href="#">
        <div class="menucloseicon_container">
	    <div class="menucloseicon_menu-Line1"></div>
	    <div class="menucloseicon_menu-Line2"></div>
        </div>
        
    </a>
    <?php
        //get parameters
        $Select = "target, section, subsection, extra, security, sortorder, deleted, articles, TLD, dispname";
        $From = "tblmenu";
        $where = "section IS null and deleted != '1'";
//$where = null;
        $Limit = null;
        $die = "Sorry there is a problem on the page, please try again later.";
        $sort = "sortorder";
	$group = NULL;

        $result = SQL($Select, $From, $die, $where, $Limit, $group, $sort);

        while ($row=fetch_array($result)){
            if(isset($_SESSION['security']) && preg_match("/".trim(validate($row['security'],'hd'))."/i", $_SESSION['security'])){
            ?>
    
        <ul  class="collapsibleList">
            
    <li><?php if (isset($target) && (validate(($row['target']),'hd') == $target )){
                echo '<div id="selected">';
            }
            ?>
        <a href="?target=<?php echo trim(validate(($row['target']),'hd')) ?>"><?php
              if (trim(validate($row['dispname'],"hd") != NULL)){
                echo trim(validate($row['dispname'],"hd"));
              }else{
                echo trim(validate($row['target'],"hd"));
              }
?></a>
        <?php if (isset($target) && (validate(($row['target']),"hd") == $target)){
                echo '</div>';
            }
            ?>
        <?php
        //get parameters
        $Select = "target, section, subsection, extra, security, sortorder, deleted, articles, TLD, dispname, notloggedin";
        $From = "tblmenu";
        $where = "target = \"" . trim(validate($row['target'],'hd'))  . "\" and subsection IS null and section IS NOT null and deleted != '1'";

        $Limit = null;
        $die = "Sorry there is a problem on the page, please try again later.";
        $sort = "sortorder";
	$group = NULL;

        $secresult = SQL($Select, $From, $die, $where, $Limit, $group, $sort);
        if (num_rows($secresult) >= 1){
?>
        
        <label for="<?php echo trim(validate($row['target'],'hd')) ?>">&lt;</label> <input type="checkbox" id="<?php echo trim(validate($row['target'],'hd')) ?>" />
        <ul class="collapsibleList">
  <?php
    global $con;
            while ($secrow=fetch_array($secresult)){
                // check menu item security
                if (isset($secrow['security'])){

                if(preg_match("/".trim(validate($secrow['security'],'hd'))."/i", $_SESSION['security'])){
                
                    //remove menu items not allowed if logged in.
                //echo $secrow['notloggedin'];
                //echo $_SESSION['security'];
                if (validate($secrow['notloggedin'],'h') == 1 && ($_SESSION['security']) != "none"){
                }else{
                    ?>

            <li><a href="?target=<?php
            if ($secrow['TLD']){
                echo trim(validate($secrow['section'],'hd'));
            }else{
                echo trim(validate($secrow['target'],'hd')) . "&amp;section=" . trim(validate($secrow['section'],'hd'));
            }
                if (isset($secrow['extra'])){
                echo '&amp;' . trim(validate($secrow['extra'],'hd'));
              }
            
              ?>"><?php
            //show dispname if set;
              if (isset($secrow['dispname'])){
                echo trim(validate($secrow['dispname'],'hd'));
              }else{
                echo trim(validate($secrow['section'],'hd'));
              }
              ?></a>
                <?php
                // pull in subsection menu
                subsection(trim(validate($secrow['target'],'hd')), trim(validate($secrow['section'],'hd')));
                ?></li>
<?php
                }}
            }else{
                // non-secure menus
                // remove menues not allowed when logged in.
                // echo $secrow['notloggedin'];
                // echo $_SESSION['security'];
                if (validate($secrow['notloggedin'],'hd') == 1 && ($_SESSION['security']) != "none"){
                }else{
                ?>

                        <li><a href="?target=<?php
            if ($secrow['TLD']){
                echo trim(validate($secrow['section'],'hd'));
            }else{
                echo trim(validate($secrow['target'],'hd')) . "&amp;section=" . trim(validate($secrow['section'],'hd'));
              }
              if (isset($secrow['extra'])){
                echo '&amp;' . trim(validate($secrow['extra'],'hd'));
              }
              ?>"><?php
              //check for and show dispname
              if (isset($secrow['dispname'])){
                echo trim(validate($secrow['dispname'],'hd'));    
              }else{
                echo trim(validate($secrow['section'],'hd'));
              }
              ?></a>

                <?php
                // pull in subsection menu
                subsection(trim(validate($secrow['target'],'hd')),  trim(validate($secrow['section'],'hd')));
                ?></li>
<?php
            }}
            }
        ?></ul>


    <?php
    free_results($secresult);
        }
    ?>
    </li>
                </ul>
<?php
        }

        }
    ?>
</div>
</div>

<?php

// subsection function
function subsection($target, $section){
 
        // echo $target . "," . $section;
        // get parameters
        $Select = "target, section, subsection, extra, security, sortorder, deleted, articles, TLD, dispname, notloggedin";
        $From = "tblmenu";
        $where = "target = '" . $target  . "' and subsection IS NOT null and section = '" . $section . "'  and deleted != '1'" ;
        $Limit = null;
        $die = "Sorry there is a problem on the page, please try again later.";
        $sort = "sortorder";
        $ssecresult = SQL($Select, $From, $die, $where, $Limit, null, $sort);
        if (num_rows($ssecresult) >= 1){
    ?>
<label for="<?php echo trim(validate($section,'hd')) ?>">&lt;<!--<img src="images/icons/left_arrow.png" width="32px" />--></label><input type="checkbox" id="<?php echo trim(validate($section,'hd')) ?>" />
           <ul>
  <?php
            while ($ssecrow=fetch_array($ssecresult)){
                // check menu item security
                if (isset($ssecrow['security'])){
                    if(preg_match("/".trim(validate($ssecrow['security'],'hd'))."/i", $_SESSION['security'])){
                     // remove menues not allowed when logged in.
                if (validate($ssecrow['notloggedin'],'hd') == 1 && ($_SESSION['security']) != "none"){
                }else{
                        ?>

            <li><a href="?target=<?php
            if ($ssecrow['TLD']){
                echo trim(validate($ssecrow['section'],'hd'));
            }else{
                echo trim(validate($ssecrow['target'],'hd')) . "&amp;section=" . trim(validate($ssecrow['section'],'hd'))  . "&amp;subsection=" . trim(validate($ssecrow['subsection'],'hd'));
              }
              if (isset($ssecrow['extra'])){
                echo '&amp;' . trim(validate($ssecrow['extra'],'hd'));
              }
              ?>"><?php
            //show dispname if set;
              if (isset($ssecrow['dispname'])){
                echo trim(validate($ssecrow['dispname'],'hd'));
              }else{
                echo trim(validate($ssecrow['subsection'],'hd'));
              } ?></a></li>

<?php
                    }}
            }else{
            
                //check if diplay only while not logged in
                if (validate($ssecrow['notloggedin'],'hd') == 1 && ($_SESSION['security']) != "none"){
                }else{
                
                ?>
            
                        <li><a href="?target=<?php
            if ($ssecrow['TLD']){
                echo trim(validate($ssecrow['section'],'hd'));
            }else{
                echo trim(validate($ssecrow['target'],'hd')) . "&amp;section=" . trim(validate($ssecrow['section'],'hd')) . "&amp;subsection=" . trim(validate($ssecrow['subsection'],'hd'));
              }
              ?>"><?php
              if (isset($ssecrow['dispname'])){
                echo trim(validate($ssecrow['dispname'],'hd'));
              }else{
                echo trim(validate($ssecrow['subsection'],'hd'));
              }
              if (isset($ssecrow['extra'])){
                echo '&amp;' . trim(validate($ssecrow['extra'],'hd'));
              }
              ?></a></li>

<?php
            }
            }

            }
        // add new subsection menu item
        echo "<li>++</li>";
        ?>

        </ul>

<?php
        }
            free_results($ssecresult);
}
?>
