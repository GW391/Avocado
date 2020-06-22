<center><h1>
Development List
</h1></center>


<?php
$system = true;
	if (isset($_SESSION['security'])){
             if(stripos($_SESSION['security'], 'Member') !== false){
?>

<p>
This page is a list of things waiting to change, bugs to be fixed and bits to be added.
</p>
<p>
If you wish to help us in ensuring the site is working correctly and is as up to date as possible, with correct spelling and grammer. 

Or if there are any new features you would like to see. Please feel free to add these items to the list.

</p>

<?php

//require ("./template/hotsprings.php");



			echo "<form method=\"post\" name=\"Add\" action=\"?target=calendar&amp;section=development&amp;subsection=update\">";
			echo "<input type=\"submit\" value=\" Add Item \">";
			echo "</form>";



$date = date('Ymd');

$select = "UID, Type, Item, Priority, target, section, subsection";
$from = "tblpdev";
$where = "Deleted!=1";
$sort = "Type, priority, Item";
$die = "Sorry the development shedule is empty";
$limit = NULL;
$Group = NULL;

$result = SQL($select, $from, $die, $where, $limit, $Group, $sort); 
                
?>
<table border="1" width="99%">
<tr>
	<td><strong>Type</strong></td>
	<td><strong>Item/Issue</strong></td>
	<td><strong>Priority</strong></td>
<?php
if (isset($_SESSION['security'])){
            if(stripos($_SESSION['security'], 'editor') !== false){
?>
	<td colspan="3"><strong>Where</strong></td>
	<td colspan="3"><strong>Edit</strong></td>
<?php
	}
}
?>
</tr>

<?php
while ($row = fetch_array($result)){
echo "<tr>";
echo "<td valign=\"top\">";
	echo nl2br($row['Type']);
echo "</td>";

echo "<td valign=\"top\">";
	echo nl2br($row['Item']);
echo "</td>";
echo "<td valign=\"top\">";
	echo nl2br($row['Priority']);
echo "</td>";

if (isset($_SESSION['security'])){
            if(stripos($_SESSION['security'], 'editor') !== false){
	echo "<td valign=\"top\">";
		echo nl2br($row['target']);
	echo "</td>";
	echo "<td valign=\"top\">";
		echo nl2br($row['section']);
	echo "</td>";
	echo "<td valign=\"top\">";
		echo nl2br($row['subsection']);
	echo "</td>";
	}
}


	if (isset($_SESSION['security'])){
                    if(stripos($_SESSION['security'], 'editor') !== false){
			echo "<td>";
			echo "<form method=\"post\" name=\"" . $row['UID'] . "\" action=\"?target=calendar&amp;section=development&amp;subsection=update\">";
			echo "<input type=\"hidden\" name=\"CALID\" value=\"" . $row['UID'] . "\" readonly >";
			echo "<input type=\"image\" SRC=\"images/icons/edit.png\" value=\" Edit \" alt=\"Edit\" name=\"Edit\" title=\"Edit\" />";
			echo "</form>";
			echo "</td>";
			echo "<td>";
			echo "<form method=\"post\" name=\"" . $row['UID'] . "\" action=\"?target=calendar&amp;section=development&amp;subsection=update\">";
			echo "<input type=\"hidden\" name=\"DUP\" value=\"" . $row['UID'] . "\" readonly >";
			echo "<input type=\"hidden\" name=\"CALID\" value=\"" . $row['UID'] . "\" readonly >";
			echo "<input type=\"image\" SRC=\"images/icons/copy.png\" value=\" Copy \" alt=\"Copy\" name=\"Copy\" title=\"Copy\" />";
			echo "</form>";
			echo "</td>";
			echo "<td>";
			echo "<form method=\"post\" name=\"" . $row['UID'] . "\" action=\"?target=calendar&amp;section=development&amp;subsection=delete\">";
			echo "<input type=\"hidden\" name=\"DEL\" value=\"" . $row['UID'] . "\" readonly >";
			echo "<input type=\"image\" SRC=\"images/icons/delete.png\" value=\" Copy \" alt=\"Delete\" name=\"Delete\" title=\"Delete\" />";
			echo "</form>";
			echo "</td>";
		}
	}

echo "</tr>\n\r";

}

?>

</table>
<br />
<?php

			echo "<form method=\"post\" name=\"Add\" action=\"?target=calendar&amp;section=development&amp;subsection=update\">";
			echo "<input type=\"submit\" value=\" Add Item \">";
			echo "</form>";
		}else{
			echo "Sorry you do not have the permission to view this page";
		}
	}else{
		echo "Please log in to view this page";
	}
?>