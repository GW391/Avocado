<?php

function displayform() {
    echo "<div id=\"editbox\">";
	echo "<form method=\"post\" action=\"?target=login&section=reset\" spellcheck=\"false\" >";
	echo "<input type=\"hidden\" name=\"uuid\" value=\"" . validate($_POST['uuid'],'hd') . "\" readonly spellcheck=\"false\"/>";
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
		echo "	<input type=\"text\" name=\"NUsername\" size=\"35\" value=\"" . validate($_POST['NUsername'],'hd') . "\" spellcheck=\"false\" />";
	}else{
		echo "	<input type=\"text\" name=\"NUsername\" size=\"35\" spellcheck=\"false\" />";
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
		echo "	<input type=\"password\" name=\"Npassword\" size=\"35\" value=\"" . validate($_POST['Npassword'],'hd') . "\"  spellcheck=\"false\" />";
	}else{
		echo "	<input type=\"password\" name=\"Npassword\" size=\"35\" spellcheck=\"false\" />";
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
		echo "	<input type=\"password\" name=\"CNpassword\" size=\"35\" value=\"" . validate($_POST['CNpassword'],'hd') . "\" spellcheck=\"false\" />";
	}else{
		echo "	<input type=\"password\" name=\"CNpassword\" size=\"35\" spellcheck=\"false\" />";
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
			if (validate($_POST['Npassword'],'hd') != validate($_POST['CNpassword'],'hd')){
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
    $credentials = getUNPW(validate($_POST['NUsername'],'h'), null,1000512);
    $UNn = $credentials[0];
}
if (isset($_POST['Npassword'])){
    $credentials = getUNPW(validate($_POST['NUsername'],'h'), validate($_POST['Npassword'],'h'),1000512);
    $PWn = $credentials[1];
}
		$Date = date("Y-m-d");
		$UUID = validate(decryptfe($_POST['uuid']),'n');

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

            $result = SQL($select, $from, $die, $Where, $limit, $group, $sort);
                
		$row = fetch_array($result);
		$email = decrypt($row['PEL']);

                //TODO: ## fully parameterise message
                
		$subject = "Account reset confirmed";
    		$message = "Thank you for resetting your " . parameters('Organisation') . " username and/or password. \n\r Note: If you have not changed your username or password, please check your account now, it may have been compromised \n\r";
                $mailfrom = parameters('UserRegistrationFromAddress');

                mail($email, "$subject",
    		$message, "From: $mailfrom " );

		echo "Thank you for resetting your " . parameters('Organisation') . " username and password, you should now be able to log in.";

	}

//		sqlclose($con);
// use confirm and uid to confirm come from new change password request
}elseif (isset($_REQUEST['confirm']) && isset($_REQUEST['uid'])){
	$confirm = decryptfe(validate($_REQUEST['confirm'],'h'));
	$uid = decryptfe(validate($_REQUEST['uid'],'h'));
	echo "Confirm = " . $confirm;
	echo "UID = " . $uid;
	if (is_numeric($confirm) && is_numeric($uid)) {
		$UUID = encryptfe($confirm/$uid);
		echo "UUID = " . $UUID;

?>

<center>
<h2>Login - Account Reset</h2>

</center>

<div id="editbox">
<form method="post" action="?target=login&amp;section=reset" spellcheck="false">
<input type="hidden" name="uuid" value="<?php echo $UUID ?>" readonly spellcheck="false"/>
<table>


<tr>
<td valign="top">
	Username:
</td>
<td>
	<input type="text" name="NUsername" size="35" value="" spellcheck="false" />
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
	<input type="password" name="Npassword" size="35" value="" spellcheck="false" />
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
	<input type="password" name="CNpassword" size="35" value="" spellcheck="false" />
</td>
</tr>

</table>

<input type="submit" name="Reset" value="Reset" />

</form>
</div>
    
<?php

}else{
		echo "There has been an error, please try again later -1 ";

}
}else{
	echo "There has been an error, please try again later - 2";
}


?>

You must enter both username and password to reset
