<center><h2>Staff <i> 
<?php
if (isset($_POST['ID'])){
?>
        - edit
        <?php
}
?>
        </i></h2></center>

<?php

    if(preg_match("/".'edit staff'."/i", $_SESSION['security'])){

?>

<table border="0">
    <thead>

</thead>
<tbody>

            <?php

if (isset($_POST['ID'])){
$UUID = validate(decryptfe($_POST['ID']),'hd');
}

// Get Organisations
$select = "tblstaff.UUID, name, email, phone, location";
$From = "`tblstaff`";
$where = "tblstaff.UUID = $UUID";

if (isset($_REQUEST['deleted'])){
$where .= " AND tblstaff.deleted != 0";
}else{
$where .= " AND tblstaff.deleted != 1";
}
$die = "Sorry there is a problem on this page please try again later";

$result = SQL($select, $From, $die, $where, null, null);

$row = fetch_array($result);

// while ($row = fetch_array($result)){
?>
    <tr>
    <th>Name:</th><td><input type="text" name="name" value="<?php echo validate(decrypt($row['name'],hd)) ?>" size="50" /></td>
    </tr>
    <tr>
    <th>Email:</th><td><input type="text" name="email" value="<?php echo validate(decrypt($row['email'],hd)) ?>" size="50" /></td>
    </tr>
    <tr>
    <th>Phone:</th><td><input type="text" name="phone" value="<?php echo validate(decrypt($row['phone'],hd)) ?>" size="50" /></td>
    </tr>
    <tr>
    <th>Office:</th><td><input type="text" name="location" value="<?php echo validate(decrypt($row['location'],hd)) ?>" size="50" /></td>
    </tr>
    <tr><td colspan="2" align="right"><input type="submit" name="save" value=" Save " /></td></tr>
<?php
//}
?>


</tbody>

</table>

<?php

}else{
echo "Sorry you do not have the permission to view Staff";
}
?>