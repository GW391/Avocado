<?php

if (isset($_POST['email']) && strlen($_POST['email'] != 0)) {

	$confirm = encrypt(strtolower($_REQUEST['email']));
        $select = "UUID, PEL, PSY, PVD";
        $From = "tblpdu";
        $Where = "PEL = '$confirm'";
        $die = "Thank you for requesting to reset your username or password, an email detailing how to reset your details will be with you shortly.";
        $limit = null;
        $group = null;
        $sort = null;

        $result = SQL($select, $From, $die, $Where, $limit, $group, $sort);
        
        // TODO: ## Parameterize email message
	echo "Thank you for requesting to reset your username or password,\n\r an email detailing how to reset your details will be with you shortly.";
	$row = fetch_array($result);
	$email = decrypt($row['PEL']);
	$id = $row['UUID'];
	$maths = rand();
	$id = $id * $maths;
	$message = parameters('PasswordResetEmailMessage');
        $curURL = curURL(parameters('SSL'), 1);
        $URL = $curURL . "?target=login&section=reset&confirm=$id&uid=$maths";
        $find = array(":link");
        $replace = array($URL);
        $updatedmessage = str_ireplace($find, $replace, $message);
	$subject = parameters('PasswordResetEmailSubject');
        $mailfrom = parameters('UserRegistrationFromAddress');

 mail($email, "Subject: $subject", $updatedmessage, "From: $mailfrom");

}else{

?>

<div id="editbox">
<form method="post" action="?target=login&section=retrieve">
Enter your email address to request password reset instructions.
<table>
<tr>
<td>email</td><td><input type="text" name="email" size="25" /></td>
</tr>
<tr>
<td><input type="submit" value="submit"></td>
</tr>
</table>
</form>
</div>
<?php
}
?>

