<?php


require ("template/hotsprings.php");
	
if ($shiftloaded){

}else{
	require ("template/asc_shift.php");
}

$confirm = $_POST['confirm'];

        $select = "UUID, PEL, PRNME";
        $from = "tblpdu";
        $Where = "UUID = '$confirm'";
        $die = "Unfortunity there has been an error, please try again later.";
        $limit = null;
        $group = null;
        $sort = null;

        $result = SQL($select, $From, $die, $Where, $limit, $group, $sort);

$count=num_rows($result);

if($count==1){
	$row=fetch_array($result);
    $email = validate(validate(decrypt($row['PEL']),'e'),'hd');
    $namea = str_word_count(decrypt($row['PRNME']), 1);
    $uid = $row['UUID'];

    // TODO: ## Paramaterise email details
    $curURL = curURL(parameters('SSL', 1));
    $subject = parameters('Organisation') . " Registration Confirmation" ;
    $message = "Dear  " . validate($namea[0],'hd') . "
Thank you for request a new copy of the email address confirmation email. \n\r

Please click the link below to activate your account \n\r

" . $curURL . "/?target=login/confirm&confirm=$uid \n\r

\n\r

Note:  Once validated you can log in, however a site administrator needs to complete part of your registration to determine your level of access, there are 3 levels of access to the site these are: \n\r
Members, Attendees and Guests. The additional portions of the site will not be visible until this is completed, which will be done in due course.

";

    $mailfrom = parameters('UserRegistrationFromAddress');

    // send regestration complete email
    mail($email, "Subject: $subject",
    $message, "From: $mailfrom " );
}

else {

echo "sorry there has been an error, please try again later";

}

sqlclose($con);
?>

Thank you for requesting a new copy of the email address validation email, <br />
the email should be with you shortly, please click the link in the email to validate your account.
