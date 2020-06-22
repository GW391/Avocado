<?php

function displayform() {
    echo "<div id=\"editbox\">";
	echo "<form method=\"post\" action=\"?target=login&section=register\">";
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
		echo "	<input type=\"password\" name=Npassword size=\"35\" value=\"" . $_POST['Npassword'] . "\"/>";
	}else{
		echo "	<input type=\"password\" name=Npassword size=\"35\" />";
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
		echo "	<input type=\"password\" name=CNpassword size=\"35\" value=\"" . $_POST['CNpassword'] . "\" />";
	}else{
		echo "	<input type=\"password\" name=CNpassword size=\"35\" />";
	}
	echo "</td>";
	echo "</tr>";
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
		echo "	<input type=\"text\" name=RName size=\"35\" value=\"" . $_POST['RName'] . "\" />";
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
		echo "	<input type=\"text\" name=Email size=\"35\" value=\"" . $_POST['Email'] . "\" />";
	}else{
		echo "	<input type=\"text\" name=Email size=\"35\" />";
	}
	echo "</td>";
	echo "</tr>";

	echo "<tr>";
	if (isset($_POST['terms'])){
		echo "<td colspan=\"2\">";
	}else{
		echo "<td bgcolor=\"red\"  colspan=\"2\">";
	}
	echo "<div class=\"small\">";
	if (isset($_POST['terms'])){
		echo "<input type=\"checkbox\" name=\"terms\" checked />";
	}else{
		echo "<input type=\"checkbox\" name=\"terms\" />";
	}
	echo "I have read and agree to be bound by our <a href=\"?target=login&section=terms\" target=\"_child\">terms</a>";
	echo "</div>";
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

	echo "<input type=\"submit\" name=\"Register\" value=\"Register\">";

	echo "</form>";
        echo "</div>";
}

if (isset($shiftloaded)){
	if ($shiftloaded){
	}else{
		require ("template/asc_shift.php");
	}
}else{
	require ("template/asc_shift.php");
}

function spamcheck($field)
  {
//stripos() performs a case insensitive regular expression match

if(stripos($field, 'to:') !== false || stripos($field, 'cc:') || stripos($field, 'bcc:') !== false)
          {
    return TRUE;
    }
  else
    {
    return FALSE;
    }
  }

  // Allow user Registration ??
if(parameters('UserReg')){

if (isset($_POST['NUsername'])) {

if (isset($_POST['Npassword'])){
	if (isset($_POST['CNpassword'])){
		if ($_POST['Npassword'] != $_POST['CNpassword']){
			$FAIL="Passwords do not match";
		}
	}else{
		$FAIL="missing field(s)";
	}
}else{
	$FAIL="missing field(s)";
}

if (isset($_POST['NUsername'])){
	if (strlen(trim($_POST['NUsername'])) == 0){
		unset($_POST['NUsername']);
	$FAIL="missing field(s)";
	}
}else{
	$FAIL="missing field(s)";
}

if (isset($_POST['Npassword'])){
	if (strlen(trim($_POST['Npassword'])) == 0){
		unset($_POST['Npassword']);
	$FAIL="missing field(s)";
	}
} else{
	$FAIL="missing field(s)";
}

if (isset($_POST['CNpassword'])){
	if (strlen(trim($_POST['CNpassword'])) == 0){
		unset($_POST['CNpassword']);
		$FAIL="missing field(s)";
	}
}else{
	$FAIL="missing field(s)";
}

if (isset($_POST['RName'])){
	if (strlen(trim($_POST['RName'])) == 0){
		unset($_POST['RName']);
		$FAIL="missing field(s)";
	}
}else{
	$FAIL="missing field(s)";
}

// check the emial address has been filled in. 
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


}}else{
	$FAIL="missing field(s)";
}

if (isset($_POST['terms'])){
// echo $_POST['terms'];
	if (strlen(trim($_POST['terms'])) == 0){
		unset($_POST['terms']);
		$FAIL="missing field(s)";
	}
}else{
	$FAIL="missing field(s)";
}

if (isset($_POST['data'])){
// echo $_POST['data'];
	if (strlen(trim($_POST['data'])) == 0){
		unset($_POST['data']);
		$FAIL="missing field(s)";
	}
}else{
	$FAIL="missing field(s)";
}

if (!isset($FAIL)){
// hash for old method don't want to duplicate either username type
$UNnOld = hash('sha256',$_POST['NUsername']);

// hash for new method
$UNn = hash('sha256',strtolower($_POST['NUsername']));

    for ($I =  0; $I < 1000; $I++){
	$UNn = hash('sha256',$UNn);
    }

        $select = "PUME";
        $From = "tblpdu";
        $Where = "PUME='$UNn' or PUME='$UNnOld'";
        $die = "An unknown error has occurred";
        $limit = 1;
        $group = null;
        $sort = null;

        $result = SQL($select, $From, $die, $Where, $limit, $group, $sort);

$count=num_rows($result);

if($count>=1){
	$FAIL="username already in use please choose another";
}
}
if (isset($FAIL)){
	echo "<center>";
	echo "<h2>Login - Register</h2>";
	echo "Failed to create account " . $FAIL;
	echo "</center>";
	Displayform();
}
else
{
   $credentials = getUNPW($_POST['NUsername'], $_POST['Npassword']);

        $UNn = $credentials[0];
        $PWn = $credentials[1];
    	$RNn = encrypt(validate($_POST['RName'],'enc'));
	$EMn = encrypt(validate(strtolower($_POST['Email']), 'enc'));
	$Date = date("Y-m-d");

    
    $db = 'tblpdu';
    $cols = 'PUME, PRD, PRNME, PEL, PRDate, PSY, PLLDate, PLCDate, whoupdate';
    $values = "'$UNn','$PWn','$RNn','$EMn','$Date','','$Date','$Date',''";
    $die = 'Error: Sorry an error has occured, please try again later' . mysqli_error();
    
  $id=SQLI($db, $cols, $values, $die);
  
  echo $id;

$curURL = curURL(parameters('SSL', 1));

//TODO: ## Parametarise email message

    $email = validate(validate($_POST['Email'],'e'),'hd');
    
    

    $subject = "Registration Confirmation" ;
    
    //todo: fully paramterise message.
    $message = "Dear  " . validate($_POST['RName'],'hd') . "
Thank you for choosing to register with" . parameters('Organisation') . " \n\r

Please click the link below to activate your account \n\r

$curURL?target=login/confirm&confirm=$id \n\r

\n\r

Note:  A site administrator needs to complete part of your registration to determine your level of access, there are 3 levels of access to the site these are: \n\r
Members, Attendees and Guests. The additional portions of the site will not be visible until this is completed, which will be done in due course.

";

$admmessage = " A new member has joined the website:  \n\r

Name: " . validate($_POST['RName'], 'hd') . "  \n\r
email: " . validate($_POST['Email'], 'hd') . "  \n\r

Please select there membership level:  \n\r

Editor:- $curURL/?target=login/typelev&confirm=$id&Type=Editor \n\r
Member:- $curURL/?target=login/typelev&confirm=$id&Type=Member \n\r
Attendee:- $curURL/?target=login/typelev&confirm=$id&Type=Attendee \n\r
View:- $curURL/?target=login/typelev&confirm=$id&Type=View \n\r

Please ignore this message if this user should not have one of the above privilages \n\r

";

// TODO: ## 01 Paramaertise email addresses

$mailfrom = parameters('UserRegistrationFromAddress');
    mail($email, "Subject: $subject",
    $message, "From: $mailfrom " );
mail("$mailfrom", "Subject: $subject",
    $admmessage, "From: $email" );

	echo "Thank you for registering, an email conformation will arrive shortly, before you can log in follow the instructions in the email";
}

}
else
{
?>
<center>
<h2>Login - Register</h2>

</center>

<div id="editbox">
<form method="post" action="?target=login&amp;section=register">
<table>
<tr>
<td>
	Username:
</td>
<td>
	<input type="text" name="NUsername" size="35" value="" />
</td>
</tr>
<tr>
<td>
	Password:
</td>
<td>
	<input type="password" name=Npassword size="35" />
</td>
</tr>
<tr>
<td>
	Confirm Password:
</td>
<td>
	<input type="password" name=CNpassword size="35" />
</td>
</tr>
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
<input type="checkbox" name="terms" />
&nbsp;
I have read and agree to be bound by our <a href="?target=login&section=terms" target="_child">terms</a>
</div>
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

<input type="submit" name="Register" value="Register" />
</form>
</div>

<?php
}
}else{
    echo "User Registraion is not allowed";
}
?>

