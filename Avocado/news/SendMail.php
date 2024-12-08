<?php 

$system = true;

//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//import PHPMailer files
//echo getcwd();
require 'template/PHPMailer/src/Exception.php';
require 'template/PHPMailer/src/PHPMailer.php';
require 'template/PHPMailer/src/SMTP.php';

// echo $_REQUEST['test'];
// echo $_REQUEST['send'];
// echo $_REQUEST['upload'];

// set security
if(security_check(parameters('SendNewsSecurity'))){
    if(upload_check()){

$Select = "idtblnewsletter, Email, RName, Deleted, PVD, idtblnewsletter, fails";
$From = "tblnewsletter";
$GROUP = null;
$die = "Sorry there is a problem on this page please, try again later";
$where = "Deleted = 0 AND PVD = 1";
$Limit = null;
$sort = null;

if(isset($_REQUEST['test']) && (validate($_REQUEST['test'],'hd') == 'test')){
    echo "test flag set only send to test users";
    $Select .= ", Test";
    $where .= " AND Test = 1";
}

//$result = SQL($Select, $From, $die, $where, $Limit, $GROUP, $sort);

        $from = "<" . parameters('NewsFromEmail') . ">";
        $subject = validate($_REQUEST['name'], 'hd');
        $message = validate($_REQUEST['message'], 'hd');
        $fname = $_FILES["file"]["name"];
        $filename = "news/" . $fname;
        $curURL = curURL(parameters('SSL'), 1);
        move_uploaded_file($_FILES["file"]["tmp_name"],
        $filename);

//echo $filename;

if(isset($_REQUEST['send']) && (validate($_REQUEST['send'],'hd') == 'send')){
    echo "send flag is set, send the news letter";

// check if the news letter is set to send to only Test Users if true restrict users list to only the test user.
if(isset($_REQUEST['test']) && (validate($_REQUEST['test'],'hd') == 'test')){
    echo "Test flag set only send to test users" . "<br />";  // inform users to send to only test users
    $Select .= ", Test";            //include test flag in SQL select
    $where .= " AND Test = 1";      // select only Test recipients
}

$result = SQL($Select, $From, $die, $where, $Limit, $GROUP, $sort); // Get selected users for seding data.

        //TODO check if parameters exist, if not revert to default paramters
        $from = parameters('NewsFromEmail');                //Get from address from parameters
        $Username = parameters('NewsFromUsername');         //Get SMTP username from paramters
        $Password = parameters('NewsFromPassword');         //SMTP password

//        $subject = validate($_REQUEST['name'], 'hd');    // Get Subject
//        $message = validate($_REQUEST['message'], 'hd');    // Get News Message

        // TODO Check if file is uploaded
        $fname = $_FILES["file"]["name"];       //Get uploaded file name
        $filename = "news/" . $fname;           //Set file to store in News
        $curURL = curURL(parameters('SSL'), 1);

        // TODO if upload is HTML or TEXT file add to Content DB as Article rather than attachments DB.
        // check if file is for upload or not, if upload add file to Attachments Database, otherwise just save file for sending.
        if(!isset($_REQUEST['upload']) || (validate($_REQUEST['upload'],'hd') != 'upload')){
            move_uploaded_file($_FILES["file"]["tmp_name"], $filename);  // Move file to news folder
        }else{
            require './System/Settings/savefile.php';
        }


//echo $filename;

        // check if News is for Send
if(isset($_REQUEST['send']) && (validate($_REQUEST['send'],'hd') == 'send')){
    echo "Send flag is set, send the news letter" . "<br />";  //inform user that the newsletter is for sending

    // setup PHPMailer
    $mail = new PHPMailer(true);

    //Server settings
    require 'template/emailServerSettings.php';
/*
    //    $mail->SMTPDebug = SMTP::DEBUG_SERVER;            //Enable verbose debug output
    $mail->isSMTP();                                        //Send using SMTP
    $mail->Host       = parameters('SMTPHost');             //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                               //Enable SMTP authentication
    $mail->Username   = $Username;                          //SMTP username
    $mail->Password   = $Password;                          //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;        //Enable implicit TLS encryption
    $mail->Port       = parameters('SMTPPort'); //465;       //TCP port to connect to; use 587 if you have set 'SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
*/
    //Recipients
    $mail->setFrom($from);      //set from address
    $mail->addReplyTo($from);   //set reply to address, same as from TODO: Get reply to from paramters instead of using from address

    //Attachments
    $mail->addAttachment($filename);         //Add attachments

    //Content
    if (null != (parameters('TinyMCEKey')) && strlen(trim(parameters('TinyMCEKey'))) != 0){
        $mail->isHTML(true);                    //Set email format to HTML
    }else
        $mail->isHTML(false);                    //Set email format to not HTML
    }
    $mail->Subject = $subject;

while ($row = fetch_array($result)){

    $Name = validate(decrypt($row['RName']),'hd');
    $id = validate($row['idtblnewsletter'],'hd');
    $URL = $curURL . "?target=news&amp;section=subscribe&amp;Unsubscribe=" . urlencode("$id");


    // TODO create class for this and parameterise find and replace arrays.
    $find = array(":NAME", ":unsubscribe", ":Organisation", ":IncYear");
    $replace = array($Name, $URL, parameters('Organisation'), parameters('IncYear'));
    $updatedmessage = str_ireplace($find, $replace, $message);

    /*  OLD mail() method
    $headers[] = "From: $from";
        // boundary 
        $semi_rand = md5(time()); 
        $mime_boundary = "==Multipart_Boundary_x{$semi_rand}x"; 

        // headers for attachment 
        $headers[]  = "MIME-Version: 1.0";
        $headers[] = "Content-Type: multipart/mixed;";
        $headers[] = " boundary=\"{$mime_boundary}";

        // multipart boundary 
        $emessage = "This is a multi-part message in MIME format.\n\n" . "--{$mime_boundary}\n" . "Content-Type: text/plain; charset=\"iso-8859-1\"\n" . "Content-Transfer-Encoding: 7bit\n\n" . $updatedmessage . "\n\n"; 
        $emessage .= "--{$mime_boundary}\n";

        // preparing attachments            
            $file = fopen($filename,"rb");
            $data = fread($file,filesize($filename));
            fclose($file);
            $base64data = chunk_split(base64_encode($data));
            $emessage .= "Content-Type: {\"application/octet-stream\"};\n" . " name=\"".$fname."\"\n" . 
            "Content-Disposition: attachment;\n" . " filename=\"$fname\"\n" . 
            "Content-Transfer-Encoding: base64\n\n" . $base64data . "\n\n";
            $emessage .= "--{$mime_boundary}--\n";
    
           // echo "EMessage: " . $emessage;
 //            if ($build <= 20240128){
 //               $email = validate(decrypt_20240128($row['Email']),'hd');
 //            }else{
                 $email = validate(decrypt($row['Email']),'hd');
 //            }
        $to = $Name . " <" . $email . ">";
        $ok = mail($to, $subject, $emessage, implode("\r\n", $headers));
	echo "<strong>" .  $Name . ": ";
	if ($ok) {
		echo '<img src="images/icons/greentick.png" alt="success" name="success" />';
*/
try {

    $email = validate(decrypt($row['Email']),'hd');
    $mail->addAddress($email, $Name);     //Add a recipient

    // Body is currently text only so no need for AltBody.  TODO: Support HTML body and AltBody,
    // probably should use msgHTML instead.
    $mail->Body    = $updatedmessage;
 //   $mail->AltBody = $updatedmessage;

    $mail->send();
//    echo 'Message has been sent';
    		echo $Name . " " . '<img src="images/icons/greentick.png" alt="success" name="success" />' . "<br />";

                $fails = validate($row['fails'], 'hd');
                $id = validate($row['idtblnewsletter'],'hd');
                if ($row['fails'] > 0){
                    $where = "idtblnewsletter = $id";
                    $update = "tblnewsletter";
                    $limit = "1";
                    $fails = '0';
                    $set = "fails = '$fails'";
                    $die = 'Sorry a problem has occured unsubscribing you';

                    SQLU($update, $set, $where, $limit, $die);
        }else{
            echo '<img src="images/icons/delete.png" alt="Failed" name="failed" />';
        }


} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    echo $Name . " " . '<img src="images/icons/delete.png" alt="Failed" name="failed" />';

                // check if enough fails to auto delete subscriber.
                $fails = validate($row['fails'], 'hd');
                $id = validate($row['idtblnewsletter'],'hd');
                $allowedFails = parameters('newsletterfails');
                if ( $allowedFails > 0){
                if ($row['fails'] >= $allowedFails){
                    $where = "idtblnewsletter = $id";
                    $update = "tblnewsletter";
                    $limit = "1";
                    $deleted = "1";
                    $set = "Deleted = '$deleted'";
                    $die = 'Sorry a problem has occured unsubscribing you';

                    SQLU($update, $set, $where, $limit, $die);
                }else{
                    $where = "idtblnewsletter = $id";
                    $update = "tblnewsletter";
                    $limit = "1";
                    $fails = $fails +1;
                    $set = "fails = '$fails'";
                    $die = 'Sorry a problem has occured unsubscribing you';

                    SQLU($update, $set, $where, $limit, $die);
                }
                }
	}
	echo " </strong><br />";

    

    // close while loop
 //   }
    // close if send
//}

        //Reset the connection to abort sending this message
        //The loop will continue trying to send to the rest of the list
        $mail->getSMTPInstance()->reset();
//}
    flush();
    //Clear all addresses and attachments for the next iteration
    $mail->clearAddresses();
    // close the loop
}
    // close if send
}


if(!isset($_REQUEST['upload']) || (validate($_REQUEST['upload'],'hd') != 'upload')){
        echo "file is for send only, delete the file now its sent.";
        unlink($filename);
    }else{
        require './System/Settings/savefile.php';
        echo "file is uploaded";
    }}
    // secuiryt check, close
    }else{
    echo "Sorry you don't have the permission to use this page";
}
?>
