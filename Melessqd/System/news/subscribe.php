<?php

function displayform() {
    echo "<div id=\"editbox\">";
	echo "<form method=\"post\" action=\"?target=news&section=subscribe\">";
	echo "<table>";

	echo "<tr>";
	if (isset($_POST['RName'])){
		echo "<td>";
	}else{
		echo "<td bgcolor=\"red\">";
	}
	echo "	Name:";
	echo "</td>";
	echo "<td>";
	if (isset($_POST['RName'])){
		echo "	<input type=\"text\" name=RName size=\"35\" value=\"" . validate($_POST['RName'],'hd') . "\" />";
	}else{
		echo "	<input type=\"text\" name=RName size=\"35\" />";
	}
	echo "</td>";
	echo "</tr>";
	echo "<tr>";
	if (isset($_POST['Email'])){
		echo "<td>";
	}else{
		echo "<td bgcolor=\"red\">";
	}
	echo "	Email:";
	echo "</td>";
	echo "<td>";
	if (isset($_POST['Email'])){
		echo "	<input type=\"text\" name=Email size=\"35\" value=\"" . validate($_POST['Email'],'hd') . "\" />";
	}else{
		echo "	<input type=\"text\" name=Email size=\"35\" />";
	}
	echo "</td>";
	echo "</tr>";

echo "<tr>";
	if (isset($_POST['data'])){
		echo "<td colspan=\"2\">";
	}else{
		echo "<td bgcolor=\"red\"  colspan=\"2\">";
	}
	echo "<div class=\"small\">";
	if (isset($_POST['data'])){
		echo "<input type=\"checkbox\" name=\"data\" checked />";
	}else{
		echo "<input type=\"checkbox\" name=\"data\" />";
	}
	echo "I agree that my <a href=\"?target=login&section=data\" target=\"_child\">data</a> can be used for the provision of this service";
	echo "</div>";
	echo "</td>";
	echo "</tr>";
	echo "</table>";

	echo "<input type=\"submit\" name=\"Submit\" value=\"Subscribe\">";
	echo "<input type=\"submit\" name=\"Submit\" value=\"Unsubscribe\">";

	echo "</form>";
        echo "</div>";
}

if (isset($shiftloaded)){
	if ($shiftloaded){
	}else{
                require ("template/config.php");
		require ("template/asc_shift.php");
	}
}else{
        require ("template/config.php");
	require ("template/asc_shift.php");
}

if(parameters('NewsReg')){

function spamcheck($field)
  {
//strpos() performs a case insensitive regular expression match
  if(stripos($field, 'to:') || stripos($field, 'cc:') || stripos($field, 'bcc:'))
    {
    return TRUE;
    }
  else
    {
    return FALSE;
    }
  }

if (isset($_POST['Submit']) && ($_POST['Submit'] == 'Subscribe')){
if (isset($_POST['RName'])){
	if (strlen(trim($_POST['RName'])) == 0){
		unset($_POST['RName']);
		$FAIL="missing field(s)";
	}
}else{
	$FAIL="missing field(s)";
}

if (isset($_POST['Email'])){
    if (strlen(trim($_POST['Email'])) == 0){
        unset($_POST['Email']);
	$FAIL="missing field(s)";
    }else{
        //check if the email address is invalid
        $mailcheck = spamcheck($_POST['Email']);
        if ($mailcheck==TRUE)
            {
	        $FAIL="Invalid email address";
            }
    }
}else{
    $FAIL="missing field(s)";
}

if (isset($_POST['Submit']) && ($_POST['Submit'] == 'Subscribe')){
if (isset($_POST['data'])){
// echo $_POST['data'];
	if (strlen(trim($_POST['data'])) == 0){
		unset($_POST['data']);
		$FAIL="missing field(s)";
	}
}else{
	$FAIL="missing field(s)";
}
}
//require ("template/hotsprings.php");



if (isset($FAIL)){
	echo "<center>";
	echo "<h2>News - Subscribe</h2>";
	echo "Failed to sign up " . $FAIL;
	echo "</center>";
	Displayform();
}else{
if ($_POST['Submit'] == 'Subscribe'){
  
    	$RNn = encrypt(validate($_POST['RName'],'enc'));
	$EMn = encrypt(validate(strtolower($_POST['Email']), 'enc'));
	$Date = date("Y-m-d");
        $GData = '1';
    
    $db = 'tblnewsletter';
    $cols = 'RName, Email, Data';
//PRDate, PLLDate, PLCDate, whoupdate,
    $values = "'$RNn','$EMn','$GData'";

//,'$Date','$Date','$Date',''
    $die = 'Error: Sorry an error has occured, please try again later';
    
  $id=SQLI($db, $cols, $values, $die);
  
//  echo $id;


$curURL = curURL(parameters('SSL'), 1);

$email = validate($_POST['Email'],'hd');    
$subject = parameters('NewsSubscribeConformationSubject');
$message = str_ireplace(":NAME",validate($_POST['RName'],'hd'), parameters('NewsSubscriptionDefaultMessage'));
$message .= "\n\r$curURL?target=news/confirm&confirm=$id \n\r";

    mail($email, "Subject: $subject", 
    $message, "From: " . parameters('NewsFromEmail'));
	echo "Thank you for subscribing, an email conformation will arrive shortly, <br /> before you receve our news letters please follow the instructions in the email";
}
}
} elseif (isset($_POST['Submit']) && $_POST['Submit'] == 'Unsubscribe'){

$EMn = encrypt(validate(strtolower($_POST['Email']), 'enc'));


$where = "Email = '$EMn' and Deleted = 0";
$update = "tblnewsletter";
$limit = "1";
$deleted = "1";
$set = "Deleted = '$deleted'";
//PLCDate = '$DateCreate', whoupdate = '$WhoUpdate',
$die = 'Sorry a problem has occured unsubscribing you';

SQLU($update, $set, $where, $limit, $die);

echo " Unsubscribed";

}elseif (isset($_REQUEST['Unsubscribe'])){

$ID = validate($_REQUEST['Unsubscribe'],'enc');


echo "<div id=\"editbox\">";
echo "<h1>Clicking the Confirm Unsubscribe button will unsubscribe you from the news letter</h1>";
	echo "<form method=\"post\" action=\"?target=news&section=subscribe\">";
        echo "<input type=\"hidden\" name=\"ConfirmUnsubscribe\" value=\"". $ID . "\">";
	echo "<table>";
        echo "<tr>";
        echo "<td>";
	echo "<input type=\"submit\" name=\"Submit\" value=\"Confirm Unsubscribe\">";
        echo "</td></tr>";
        echo "</table>";

}elseif (isset($_POST['ConfirmUnsubscribe'])){
    
$ID = validate(decrypt($_REQUEST['ConfirmUnsubscribe']),'hd');
$where = "idtblnewsletter = '$ID'";
$update = "tblnewsletter";
$limit = "1";
$deleted = "1";
$set = "Deleted = '$deleted'";
//PLCDate = '$DateCreate', whoupdate = '$WhoUpdate',
$die = 'Sorry a problem has occured unsubscribing you';

SQLU($update, $set, $where, $limit, $die);

echo $ID . " Unsubscribed";

}

else
{
?>


<center>
<h2>News - Subscribe</h2>

</center>

<div id="editbox">
<form method="post" action="?target=news&amp;section=subscribe">
<table>
<tr>
<td>
	Name:
</td>
<td>
	<input type="text" name=RName size="35" />
</td>
</tr>
<tr>
<td>
	Email:
</td>
<td>
	<input type="text" name=Email size="35" />
</td>
</tr>

<tr>
<td colspan="2">
<div class="small">
<input type="checkbox" name="data" />
&nbsp;
I agree that my <a href="?target=login&section=data" target="_child">data</a> can be used for the provision of this service";</div>
</td>
</tr>

</table>

<input type="submit" name="Submit" value="Subscribe" />
<input type="submit" name="Submit" value="Unsubscribe" />
</div>

</form>

<?php

}
}else{
  echo "User subscription is not allowed";
}
?>
