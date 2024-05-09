<center><h2>Settings</h2></center>

<?php
$system = true;
if(preg_match("/".'editor'."/i", $_SESSION['security'])){
$Select = "Grouping";
$From = "tblsettings";
$GROUP = "Grouping";
$die = "Sorry there is a problem on this page please, try again later";
$where = null;
$Limit = null;
$sort = null;
$result = SQL($Select, $From, $die, $where, $Limit, $GROUP, $sort);

echo "<p>Limit: ";
if (isset($_GET['limit'])){
    echo "<a href=\"?target=Settings\"> All </a>: ";
}
        while ($row = fetch_array($result)){
            echo "<a href=\"?target=Settings&limit=". validate($row['Grouping'],'hd') . "\">" . validate($row['Grouping'],'hd') . "</a>: ";
        }
echo "</p>";

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
    $where = "Grouping='$limit'";
    //echo $where;
}else{
   $where = null;
}

$result = SQL($select, $From, $die, $where, null, null, null);

?>

<table width="100%" border="1">
    <tbody>   
        <?php
        foreach ($result as $row){
            echo "<tr>\n\r";
            echo "<th>" . validate($row['Name'],'hd') . "</th>\n\r"; // Display setting name
           if (strtoupper(validate($row['num_rows'],'hd')) == "P"){
            // value is a password, hide it
               echo "<td>**********</td>\n\r"; // Display stars for hidden password
               //TODO: make this more visually appealing
           }else{
            echo "<td>" . validate($row['Value'],'hd') . "</td>\n\r"; // Display setting value
           }
         //   echo "<td>" . $row['uuid'] . "</td>\n\r";
         //   echo "<td>" . encryptfe($row['uuid']) . "</td>\n\r";
            ?>
            <td>
            <?php
            // check if the parameter is read only, if not display edit buttons
            if (strtoupper(validate($row['num_rows'],'hd')) != "R"){
                ?>
                <form method="post" name="e<?php echo validate(encryptfe($row['uuid']),'hu')?>" action="?target=Settings&amp;section=edit">
                <?php if(isset($limit)){
                    //check if we have a group selected, if so pass to edit page to preserve ?>
                <input type="hidden" name="Grouping" value="<?php echo $limit?>">
                <?php }?>

            <button class="custombutton" type="submit" name="Edit" value="<?php echo validate(encryptfe($row['uuid']),'hu')?>">
            <img src="images/icons/edit.png" alt="Edit" name="Edit" title="Edit" />
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
    // no rights to view, so lack of permissions message.
    echo parameters('PermissionsMessage');
?>
