<center><h2>Users</h2></center>

<?php
$system = true;
if (isset($_SESSION['puid'])){

$select = "UUID, PRNME, PSY";
$From = "tblpdu";
$die = "Sorry there is a problem on this page please try again later";

if(stripos($_SESSION['security'], 'admin') !== FALSE){
    // user is an admin, they can view all users
    $where = "Deleted != '1'";
}else{
       // user is not an admin, they can view themselves
    $UUID = validate(decrypt($_SESSION['puid']),'hd');
    $where = "UUID = '$UUID'";
}

$Users = SQL($select, $From, $die, $where, null, null, null);

echo num_rows($Users);

?>

<table width="100%" border="1">
    <tbody>
        <tr>
            <th>User</th>
            <th>Security</th>
<?php
                if(stripos($_SESSION['security'], 'admin')!== FALSE){
?>
            <td width="23">
                <form method="post" name="new" action="?target=Users&amp;section=Edit">
                      <input type="image" SRC="images/icons/new.png" value=" New " alt="New" name="New" title="New" />
		</form>
            </td>
<?php
            }
?>

        </tr>
        <?php
        while ($row = fetch_array($Users)){
            echo "<tr>\n\r";
            echo "<td>" . ucfirst(validate(decrypt($row['PRNME']),'hd')) . "</th>\n\r";
            echo "<td>" . validate($row['PSY'],'hd') . "</td>\n\r";
			// edit
			echo "<td width=\"23\">";
			echo "<form method=\"post\" name=\"" . encryptfe($row['UUID']) . "\" action=\"?target=Users&amp;section=Edit\">\n\r";
			echo "<input type=\"hidden\" name=\"CALID\" value=\"" . encryptfe($row['UUID']) . "\" readonly=\"readonly\" />\n\r";
			echo "<input type=\"image\" SRC=\"images/icons/edit.png\" value=\" Edit \" alt=\"Edit\" name=\"Edit\" title=\"Edit\" />\n\r";
			echo "</form>";
			echo "</td>";
			// delete
			echo "<td width=\"23\">";
			echo "<form method=\"post\" name=\"" . encryptfe($row['UUID']) . "\" action=\"?target=Users&amp;section=Delete\">\n\r";
			echo "<input type=\"hidden\" name=\"DEL\" value=\"" . encryptfe($row['UUID']) . "\" readonly=\"readonly\" />\n\r";
			echo "<input type=\"image\" SRC=\"images/icons/delete.png\" value=\" Delete \" alt=\"Delete\" name=\"Delete\" title=\"Delete\" />\n\r";
			echo "</form>";
			echo "</td>";
                        echo "</tr>\n\r";
        }
        ?>      
        </tbody>
</table>
<?php
}else{
    echo parameters('PermissionsMessage');
}
