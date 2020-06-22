<?php
if (isset($_SESSION['security'])){
if(stripos($_SESSION['security'], 'Member') !== false){
if (isset($_POST['CALID'])){

$UUID = $_POST['CALID'];

//require ("./template/hotsprings.php");

        $Select = "UID, Type, Item, Priority, datecreted, whocreated, target, section, subsection";
        $From = "tblpdev";
        $where = "WHERE UID = $UUID";

//$where = null;
        $Limit = null;
        $die = "Sorry there is a problem on the page, please try again later.";
        $sort = NULL;
	$group = NULL;

        $result = SQL($Select, $From, $die, $where, $Limit, $group, $sort);

while ($row = fetch_array($result)){

?>

<form name="updateform" method="post">
<input type="hidden" name="target" value="calendar">
<input type="hidden" name="section" value="development">
<input type="hidden" name="subsection" value="updateSave">

<?php 

if (isset($_POST['DUP'])){

}else{

?>

<input type="hidden" name="UUID" value="<?php echo $UUID; ?>" >
<?php
}
?>

<table>
<tr>
<td>Type:</td>
<td>
<select name="Type" value="<?php echo $row['Type']; ?>">
  <option>Bug</option>
  <option>Feature</option>
  <option>Security</option>
</select>
<br />
Select Type of issue
</td>
</tr>

<tr>
<td>Event:</td>
<td><textarea name='Item' rows='15' cols='40'><?php echo $row['Item']; ?></textarea></td>
</tr>

<tr>
<td>Priority:</td>
<td>
<select name="Priority" value="<?php echo $row['Priority']; ?>">
  <option>1</option>
  <option>2</option>
  <option>3</option>
  <option>4</option>
  <option>5</option>
</select>
</td>
</tr>

<tr>
<td>Target:</td>
<td><input type="text" name="ltarget" value="<?php echo $row['target']; ?>" /><br />
Enter the top level menu option
</td>
</tr>
<tr>
<td>section:</td>
<td><input type="text" name="lsection" value="<?php echo $row['section']; ?>" /><br />
Enter the second menu option
</td>
</tr>
<tr>
<td>sub-section:</td>
<td><input type="text" name="lsubsection" value="<?php echo $row['subsection']; ?>" /><br />
Enter the third level menu option
</td>
</tr>
<tr>
<td></td>
<td><input type="submit" name="Save" value=" Save " /></td>
</tr>
</table>
</form>
<?php
}
}else{

?>

<form name="updateform" method="post">
<input type="hidden" name="target" value="calendar">
<input type="hidden" name="section" value="development">
<input type="hidden" name="subsection" value="updateSave">

<table>
<tr>
<td>Type:</td>
<td>
<select name="Type">
  <option>Bug</option>
  <option>Feature</option>
  <option>Security</option>
</select>
<br />
Select Type of issue
</td>
</tr>

<tr>
<td>Event:</td>
<td><textarea name="Item" rows="15" cols="40"></textarea></td>
</tr>

<tr>
<td>Priority:</td>
<td>
<select name="Priority">
  <option>1</option>
  <option>2</option>
  <option>3</option>
  <option>4</option>
  <option>5</option>
</select>
</tr>
<tr>
<td>Target:</td>
<td><input type="text" name="ltarget" value="" /></td>
</tr>
<tr>
<td>section:</td>
<td><input type="text" name="lsection" value="" /></td>
</tr>
<tr>
<td>sub-section:</td>
<td><input type="text" name="lsubsection" value="" /></td>
</tr>

<tr>
<td></td>
<td><input type="submit" name="Save" value=" Add " /></td>
</tr>
</table>
</form>

<?php
}


}
}

?>