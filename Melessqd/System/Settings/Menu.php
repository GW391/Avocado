<center><h2>Settings - Menu</h2></center>

<?php
$system = true;
        if(stripos($_SESSION['security'], 'editor') !== false){
            if (isset($result)){
                free_results($result);
            }
// creat limit links

$Select = "target";
$From = "tblmenu";
$GROUP = "target";
$die = "Sorry there is a problem on this page please, try again later";
$where = "deleted != 1";
$Limit = null;
$sort = "target, sortorder";
$result = SQL($Select, $From, $die, $where, $Limit, $GROUP, $sort);

echo "<p>Limit: ";
if (isset($_GET['limit'])){
    echo "<a href=\"?target=System&section=Settings&subsection=Menu\"> All </a>: ";
}
        while ($row = fetch_array($result)){
            echo "<a href=\"?target=System&section=Settings&subsection=Menu&limit=". validate($row['target'],'hd') . "\">" . validate($row['target'],'hd') . "</a>: ";
        }
echo "</p>";
free_results($result);

//Where am I
//Links require me to know where admin have placed me in the menu
//Default is Home - Settings - Menu
//Set to default until programming to locate correctly can be written

$target = "System";
$section = "Settings";
$subsection = "Menu";

//free_results($result);

// limit links done

$Select = "uuid, target, section, subsection, dispname, system, articles, security";
$From = "tblmenu";
$die = "Sorry there is a problem on this page please, try again later";

// if limit selected limit results
if (isset($_REQUEST['limit'])){
    //echo "1";
    $limit = validate($_REQUEST['limit'], 'hd');
    $where = "target='$limit' and deleted != 1";
    //echo $where;
}else{
   $where = "deleted != 1";
}


$Limit = null;
$sort = "target, sortorder";

//free_results($result);
 $result = SQL($Select, $From, $die, $where, $Limit, null, $sort);

?>

<table width="100%" border="1">
    <thead>
        <tr>
            <th>Target</th>
            <th>Section</th>
            <th>Subsection</th>
            <th>Display Name</th>
	    <th>Articles</th>
	    <th>Security</th>
            <th>
                    <form method="post" name="eNew" action="?target=<?php echo $target?>&amp;section=<?php echo $section?>&amp;subsection=edit">
                        <?php if (isset($limit)){
                            echo '<input type="hidden" name="etarget" value="'.$limit.'">';
                        }
                        ?>
		    <button class="custombutton" type="submit" name="New" value="New">
                    <img src="images/icons/new.png" alt="New" name="New" title="New" />
                </button>

	</form>
            </th>
        </tr>
    </thead>
    <tbody>
        <?php
        while ($row = fetch_array($result)){
            echo "<tr>\n\r";
            echo "<td>" . validate($row['target'],'hd') . "</td>\n\r";
            echo "<td>" . validate($row['section'],'hd') . "</td>\n\r";
            echo "<td>" . validate($row['subsection'],'hd') . "</td>\n\r";
            echo "<td>" . validate($row['dispname'],'hd') . "</td>\n\r";
            echo "<td>" . validate($row['articles'],'hd') . "</td>\n\r";
            echo "<td>" . validate($row['security'],'hd') . "</td>\n\r";

        if (validate($row['system'],'hd') == 1){
            ?>
                <td width="60px">
                    <?php // echo validate(($row['uuid'])); ?>
        <form method="post" name="e<?php echo validate(encryptfe($row['uuid']),'enc')?>" action="?target=<?php echo $target?>&amp;section=<?php echo $section?>&amp;subsection=edit">
		<button class="custombutton" type="submit" name="Edit" value="<?php echo validate(encryptfe($row['uuid']),'hu')?>">
                    <img src="images/icons/edit.png" alt="Edit" name="Edit" title="Edit" />
                </button>
	<img SRC="images/icons/delete_g.png" alt="Can't Delete System Menu" name="Can't Delete System Menu" title="Can't Delete System Menu" />
	</form>
         
    </td>
    <?php
        }else{

        ?>
    <td width="120px">
        <form method="post" name="e<?php echo validate(encryptfe($row['uuid']),'enc')?>" action="?target=<?php echo $target?>&amp;section=<?php echo $section?>&amp;subsection=edit">
	<button class="custombutton" type="submit" name="Edit" value="<?php echo validate(encryptfe($row['uuid']),'hu')?>">
            <img src="images/icons/edit.png" alt="Edit" name="Edit" title="Edit" />
        </button>
<!--            <input type="image" SRC="images/icons/edit.png" value="<?php echo validate(encryptfe($row['uuid']),'hu')?>" alt="Edit" name="Edit" title="Edit" />-->

<button class="custombutton" type="submit" name="Delete" value="<?php echo validate(encryptfe($row['uuid']),'hu')?>">
      <img src="images/icons/delete.png" alt="Delete" name="Delete" title="Delete" />
    </button>
            <!--<input type="image" SRC="images/icons/delete.png" value="<?php echo validate(encryptfe($row['uuid']),'hu')?>" alt="Delete" name="Delete" title="Delete" />-->
	</form>
        <form method="post" name="na<?php echo validate(encryptfe($row['uuid']),'enc')?>" action="?target=Page_Edit&amp;section=edit">
            <input type="hidden" name="etarget" value="<?php echo validate($row['target'],'hd')?>" />
            <input type="hidden" name="esection" value="<?php echo validate($row['section'],'hd')?>" />
            <input type="hidden" name="esubsection" value="<?php echo validate($row['subsection'],'hd')?>" />
	<button class="custombutton" type="submit" name="Add Article" value="New">
            <img src="images/icons/detail.png" alt="Add Article" name="Add Article" title="Add Article" />
        </button>
        </form>
            <form method="post" name="view<?php echo validate(encryptfe($row['uuid']),'enc')?>" action="?">
            <?php if (isset($row['target']) && strlen($row['target']) != 0  && ($row['target']) != null) {?>
                <input type="hidden" name="target" value="<?php echo validate($row['target'],'hd')?>" />
            <?php } ?>
                <?php if (isset($row['section']) && strlen($row['section']) != 0  && strlen($row['section']) != null) {?>
            <input type="hidden" name="section" value="<?php echo validate($row['section'],'hd')?>" />
            <?php } ?>
            <?php if (isset($row['subsection'])&& strlen($row['subsection']) != 0  && strlen($row['subsection']) != null) {?>
            <input type="hidden" name="subsection" value="<?php echo validate($row['subsection'],'hd')?>" />
            <?php } ?>
	<button class="custombutton" type="submit">
            <img src="images/icons/view.png" alt="View Page" name="View Page" title="View Page" />
        </button>
            </form>
    </td>
    


<?php
        }
            echo "</tr>\n\r";
        }
        }else{
echo "Sorry you don't have the permission to edit parameters";
        }
        ?>      
        </tbody>

</table>
