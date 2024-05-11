<?php

if (/*isset($_POST['email']) && strlen($_POST['email'] != 0) && */isset($_POST['Username']) && strlen($_POST['Username']) !=0 ) {

	$confirm = getUNPW(validate($_POST['Username'],'h'), null,1000512);
    //$
        $select = "UUID, PEL, PSY, PVD, PUME";
        $From = "tblpdu";
        $Where = "PUME = '$confirm[0]'";
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
        $URL = $curURL . "?target=login&section=reset&confirm=" . urlencode(encryptfe($id)) . "&uid=" . urlencode(encryptfe($maths));
        $find = array(":link");
        $replace = array($URL);
        $updatedmessage = str_ireplace($find, $replace, $message);
	$subject = parameters('PasswordResetEmailSubject');
        $mailfrom = parameters('UserRegistrationFromAddress');

 mail($email, "Subject: $subject", $updatedmessage, "From: $mailfrom");
session_unset();
}else{

?>

<div id="editbox">
<form method="post" action="?target=login&amp;section=retrieve" spellcheck="false">
Enter your email address to request password reset instructions.
<table>
<tr>
<td>Username</td><td><input type="text" name="Username" size="25" spellcheck="false" /></td>
<tr>
<td>email</td><td><input type="text" name="email" size="25" spellcheck="false" /></td>
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

