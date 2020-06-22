<center><h2>My Account</h2></center>

<?php

$system = true;
$select = "UUID, PRNME AS Name, plldate, pel AS email";
$From = "tblpdu";
$die = "Sorry there is a problem on this page please try again later";
if (isset($_SESSION['puid'])){
    $UUID = validate(decryptfe($_SESSION['puid']),'hd');
    $where = "UUID = '$UUID'";

$result = SQL($select, $From, $die, $where, null, null, null);

// echo num_rows($result);

?>

<table width="100%" border="0">
    <tbody>
        <?php
        while ($row = fetch_array($result)){
            echo "<tr>\n\r";
            echo "<th>Name</th>";
            echo "<td>" . ucfirst(validate(decrypt($row['Name']),'hd')) . "</th>\n\r";
            echo "</tr>\n\r";
            echo "<tr>\n\r";
            echo "<th>Last Login</th>";
            echo "<td>" . date('D jS M Y', strtotime(validate($row['plldate'],'d'))) . "</td>\n\r";
            echo "</tr>\n\r";
            echo "<tr>\n\r";
            echo "<th>Email</th>";
            echo "<td>" . validate(decrypt($row['email']),'hd') . "</td>\n\r";

		echo "<td width=\"23\">";
		echo "<form method=\"post\" name=\"" . encryptfe($row['UUID']) . "\" action=\"?target=$target&amp;section=AccountEdit\">\n\r";
		echo "<input type=\"hidden\" name=\"CALID\" value=\"" . encryptfe($row['UUID']) . "\" readonly=\"readonly\" />\n\r";
		echo "<input type=\"image\" SRC=\"images/icons/edit.png\" value=\" Edit \" alt=\"Edit\" name=\"Edit\" title=\"Edit\" />\n\r";
		echo "</form>";
		echo "</td>";
		// delete
		echo "<td width=\"23\">";
		echo "<form method=\"post\" name=\"" . encryptfe($row['UUID']) . "\" action=\"?target=$target&amp;section=AccountDelete\">\n\r";
		echo "<input type=\"hidden\" name=\"DEL\" value=\"" . encryptfe($row['UUID']) . "\" readonly=\"readonly\" />\n\r";
		echo "<input type=\"image\" SRC=\"images/icons/delete.png\" value=\" Delete \" alt=\"Delete\" name=\"Delete\" title=\"Delete\" />\n\r";
		echo "</form>";
		echo "</td>";
            echo "</tr>\n\r";
            ?> 
                    </tbody>

</table>
        
             

<?php 
// get user subscriptions 
$Selectnews = "idtblnewsletter, Email, RName, Deleted, PVD, idtblnewsletter, fails";
$Fromnews = "tblnewsletter";
$GROUPnews = null;
$dienews = "Sorry there is a problem on this page please, try again later" . sqlerror();
$wherenews = "Email = '" . validate(($row['email']),'hd') ."' && Deleted = '0'";
$Limitnews = null;
$sortnews = null;
$resultnews = SQL($Selectnews, $Fromnews, $dienews, $wherenews, $Limitnews, $GROUPnews, $sortnews);

if (num_rows($resultnews) > 0){
    $curURL = curURL(parameters('SSL'), 1);
    
    $URL = $curURL . "?target=news&section=subscribe&Unsubscribe=" . urlencode("$id");
    ?>
<h2>Manage newsletter subscriptions</h2>
<br />
You currently have <?php echo num_rows($resultnews); ?> active subscriptions
    <table width="100%" border="0">
    <tbody>
        <?php
        while ($rownews = fetch_array($resultnews)){
            $id = validate(encrypt($rownews['idtblnewsletter']),'enc');
            echo "<tr>";
            echo "<td>";
            echo validate(decrypt($rownews['RName']),'hd');
            echo "</td>";
            echo "<td>";
            echo validate(decrypt($rownews['Email']),'hd');
            echo "</td>";
            echo "<td width=\"23\"></td>";
            echo "<td width=\"23\">";
            echo "<a href=\"?target=news&section=subscribe&Unsubscribe=" . urlencode($id) . "\"><img SRC=\"images/icons/delete.png\" />";
            echo "</td>";
            echo "</tr>";
            
}
?>
    </tbody>
        </table>
<?php
        }
}

        }else{
            echo "Sorry you are not logged in, please log in and try again";
        }
        ?>