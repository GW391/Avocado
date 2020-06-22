<?php

function displayform() {
    echo "<div id=\"editbox\">";
	echo "<form method=\"post\" action=\"?target=login&section=reset\">";
	echo "<table>";
	echo "<tr>";
	if (isset($_POST['NUsername'])){
		echo "<td>";
	}else{
		echo "<td bgcolor=\"red\">";
	}
	echo "	Username:";
	echo "</td>";
	echo "<td>";

	if (isset($_POST['NUsername'])){
		echo "	<input type=\"text\" name=\"NUsername\" size=\"35\" value=\"" . $_POST['NUsername'] . "\" />";
	}else{
		echo "	<input type=\"text\" name=\"NUsername\" size=\"35\" />";
	}

	echo "</td>";
	echo "</tr>";
	echo "<tr>";
	if (isset($_POST['Npassword'])){
		echo "<td>";
	}else{
		echo "<td bgcolor=\"red\">";
	}
	echo "	Password:";
	echo "</td>";
	echo "<td>";

	if (isset($_POST['Npassword'])){
		echo "	<input type=\"password\" name=\"Npassword\" size=\"35\" value=\"" . $_POST['Npassword'] . "\"/>";
	}else{
		echo "	<input type=\"password\" name=\"Npassword\" size=\"35\" />";
	}

	echo "</td>";
	echo "</tr>";
	echo "<tr>";
	if (isset($_POST['CNpassword'])){
		echo "<td>";
	}else{
		echo "<td bgcolor=\"red\">";
	}
	echo "	Confirm Password:";
	echo "</td>";
	echo "<td>";
	if (isset($_POST['CNpassword'])){
		echo "	<input type=\"password\" name=\"CNpassword\" size=\"35\" value=\"" . $_POST['CNpassword'] . "\" />";
	}else{
		echo "	<input type=\"password\" name=\"CNpassword\" size=\"35\" />";
	}
	echo "</td>";
	echo "</tr>";

	echo "</table>";

	echo "<input type=\"submit\" name=\"Reset\" value=\"Reset\">";

	echo "</form>";
        echo "</div>";
}

if (isset($_POST['NUsername']) || isset($_POST['Npassword']))  {

	if (isset($_POST['Npassword'])){
		if (isset($_POST['CNpassword'])){
			if ($_POST['Npassword'] != $_POST['CNpassword']){
				$FAIL="Passwords do not match";
			}
		}else{
			$FAIL="Please enter password Conformation";
		}
	}

if (isset($_POST['NUsername'])){
	if (strlen(trim($_POST['NUsername'])) == 0){
		unset($_POST['NUsername']);
	}
}else{
	$FAIL="You must enter a username, please enter your existing or a new username";
}

	if (isset($FAIL)){

		echo "<center>";
		echo "<h2>Login - Account Reset</h2>";

		echo "Failed to update account " . $FAIL;

		echo "</center>";

		Displayform();
	}else{
            
if (isset($_POST['NUsername'])){
    $credentials = getUNPW($_POST['Username'], null);
    $UN = $credentials[0];
}
if (isset($_POST['Npassword'])){
    $credentials = getUNPW($_POST['Username'], $_POST['password']);
    $PW = $credentials[1];
}
		$Date = date("Y-m-d");
		$UUID = $_POST['uuid'];

if (isset($_POST['NUsername'])){
		$update = 'tblpdu';
		$set =  "PUME='$UNn'";
		$where = "UUID = '$UUID'";
		$limit = 1;
		$die ='Error: An unknown error has occured, please try again later';
                SQLU($update, $set, $where, $limit, $die);
}


if (isset($_POST['Npassword'])){
		$update = 'tblpdu';
		$set = "PRD='$PWn'";
		$where = "UUID = '$UUID'";
		$limit = 1;
		$die = 'Error: An unknown error has occured, please try again later';
                SQLU($update, $set, $where, $limit, $die);
}
		$update = 'tblpdu';
		$set = "PLCDate='$Date'";
		$where = "UUID = '$UUID'";
		$limit = 1;
                $die = 'Error: An unknown error has occured, please try again later';
                SQLU($update, $set, $where, $limit, $die);

                // now select user again to send reset email
                $select = "UUID, PEL";
                $from = "tblpdu";
                $Where = "UUID = '$UUID'";
                $die = "Sorry there has been a problem, please try again later.";
                $limit = 1;
                $group = null;
                $sort = null;

            $result = SQL($select, $From, $die, $Where, $limit, $group, $sort);
                
		$row = fetch_array($result);
		$email = decrypt($row['PEL']);

		$subject = "Account reset confirmed";
    		$message = "Thank you for resetting your Woodstock Baptist church username and/or password. \n\r Note: If you have not changed your username or password, please check your account now, it may have been compromised \n\r";
                $mailfrom = parameters('UserRegistrationFromAddress');
//TODO: ## parameterise email address
                mail($email, "$subject",
    		$message, "From: $mailfrom " );

		echo "Thank you for resetting your Woodstock Baptist church username and password, you should now be able to log in.";

	}

		sqlclose($con);

}elseif (isset($_GET['confirm']) && isset($_GET['uid'])){

	if (is_numeric($_GET['confirm']) && is_numeric($_GET['uid'])) {
		$UUID = $_GET['confirm']/$_GET['uid'];

?>

<center>
<h2>Login - Account Reset</h2>

</center>

<div id="editbox">
<form method="post" action="?target=login&amp;section=reset">
<input type="hidden" name="uuid" value="<?php echo $UUID ?>" readonly />
<table>


<tr>
<td valign="top">
	Username:
</td>
<td>
	<input type="text" name="NUsername" size="35" value="" />
        <p class="small">
           Please enter your existing or a new username
        </p>
</td>
</tr>
<tr>
<td valign="top">
	Password:
</td>
<td>
	<input type="password" name="Npassword" size="35" value="" />
        <p class="small">
           Please enter your existing or a new password
        </p>
</td>
</tr>
<tr>
<td valign="top">
	Confirm Password:
</td>
<td>
	<input type="password" name="CNpassword" size="35" value="" />
</td>
</tr>

</table>

<input type="submit" name="Reset" value="Reset" />

</form>
</div>
    
<?php

}else{
		echo "There has been an error, please try again later";

}
}else{
	echo "There has been an error, please try again later";
}


?>

You must enter both username and password to reset
