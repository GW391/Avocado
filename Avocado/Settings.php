<center><h2>Settings</h2></center>

<?php
$system = true;
if(security_check(parameters('SettingsSecurity'))){
$Select = "Grouping";
$From = "tblsettings";
$GROUP = "SUBSTRING_INDEX(Grouping, \" \", 1)";
$die = "Sorry there is a problem on this page please, try again later";
$where = null;
$Limit = null;
$sort = null;
$result = SQL($Select, $From, $die, $where, $Limit, $GROUP, $sort);

echo '<div id="edit">';
echo "Limit: ";
if (isset($_GET['limit'])){
    echo "<a href=\"?target=Settings\"> All </a> ";
}
        while ($row = fetch_array($result)){
            echo "<a href=\"?target=Settings&limit=". validate($row['Grouping'],'hd') . "\">" . validate($row['Grouping'],'hd') . "</a> ";
        }
//echo "</p>";
echo '</div>';

free_results($result);

$select = "Name, Value, uuid, num_rows";
$From = "tblsettings";
$die = "Sorry there is a problem on this page please, try again later";


if (isset($_REQUEST['limit']) || isset($Grouping)){
    //echo "1";
  if (isset($_REQUEST['limit'])){
    $limit = validate($_REQUEST['limit'], 'hd');
  }else
    if (isset($Grouping)){
    $limit = $Grouping;
  }
    $where = "Grouping like N'%$limit%'";
    //echo $where;
}else{
   $where = null;
}

$result = SQL($select, $From, $die, $where, null, null, null);

?>

<table width="100%" border="1">
    <tbody>   
        <?php
        while ($row = fetch_array($result)){
            echo "<tr>\n\r";
            echo "<th>" . validate($row['Name'],'hd') . "</th>\n\r";
            // check if data is a passowrd, is so Obfiscate.
            if (strtoupper(validate($row['num_rows'],'hd')) == "P") {
               echo "<td>********</td>\n\r";
            }else{
                echo "<td>" . validate($row['Value'],'hd') . "</td>\n\r";
            }
         //   echo "<td>" . $row['uuid'] . "</td>\n\r";
         //   echo "<td>" . encryptfe($row['uuid']) . "</td>\n\r";
            ?>
            <td>
            <?php
            // check if the parameter is read only, if not display edit buttons
            if (strtoupper(validate($row['num_rows'],'hd')) != "R"){
                ?>
                <form method="post" name="e<?php echo validate(encryptfe($row['uuid']),'hd')?>" action="?target=Settings&amp;section=edit">
                <?php if(isset($limit)){
                    ?>
                <input type="hidden" name="Grouping" value="<?php echo $limit?>">
                <?php }?>

            <button class="custombutton" type="submit" name="Edit" value="<?php echo validate(encryptfe($row['uuid']),'hd')?>">
            <?php new Icon("edit") ?>
            <!--<img src="images/icons/edit.png" alt="Edit" name="Edit" title="Edit" />-->
        </button>
	</form>
	<?php
            }
            ?>

</td>
<?php
            echo "</tr>\n\r";
        }
        ?>      
        </tbody>

</table>
<?php
}else
echo parameters('PermissionsMessage');
?>
