<br />
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

if (function_exists('spamcheck')){
}else{
function spamcheck($field)
  {
 
//stripos() performs a case insensitive regular expression match
        if (stripos($field, 'to:') !== false || stripos($field, 'cc:') !== false) 
    {
    return TRUE;
    }
  else
    {
    return FALSE;
    }
  }
  }
  
  if (function_exists('displaycontactform')){
}else{
  function displaycontactform()
  {
      global $target;
      global $section;
      global $subsection;
      echo "
      <div id=\"editbox\">
          <form method='post' action='?target=$target";
              if (isset($section)){
                  echo "&ampsection=$section";
              }
              if (isset($subsection)){
                  echo "&ampsubsection=$subsection";
              }
              echo "'>
                  <input name='referrer' type='hidden' value='";
              if(isset($_SERVER['HTTP_REFERER'])){
                  echo validate($_SERVER['HTTP_REFERER'],'hd');
              }else{
                  echo "null";
              }
              echo "' readonly />
                  <input name='time' type='hidden' value='" . time() . "' readonly />
                  <input name='times' type='hidden' value='";
                  if (isset($_REQUEST['times'])){
                      echo validate($_REQUEST['times'],'hd')+1;
                  }else{
                      echo 0;
                  }
                  echo "' readonly />
<table>
<tr>
<td><label for='email'>Email:</label>
</td>
<td>
<input name='email' type='text' size='30' placeholder='email address' value='";
    if (isset($_REQUEST['email'])){
      echo validate($_REQUEST['email'],'hd');
    } 
    echo "' required />
</td>
</tr>
<tr>
<td><label for='subject'>Subject:</label>
</td>
<td>
";

echo "<input name='subject' type='text' size='30' placeholder='Subject' value='";
    if (isset($_REQUEST['subject'])){
      echo validate($_REQUEST['subject'],'hd');
    }
echo "' required />";

echo "
</td>
</tr>
<tr>
<td valign=top>
<label for='message'>Message:</label>
</td>
<td>
<textarea name='message' rows='15' cols='40' placeholder='Message' required>";

if (isset($_REQUEST['message'])){
      echo validate($_REQUEST['message'],'hd');
    }

echo "</textarea>
</td>
</tr>

<tr>
<td colspan=\"2\"> ";
if (isset($_POST['data'])){
		echo "<input type=\"checkbox\" name=\"data\" required checked />";
	}else{
		echo "<input type=\"checkbox\" name=\"data\" required />";
	}
	echo "<label for='data'>I agree that my data can be used for the provision of this service</label>";
echo "</td>
    </tr>

<tr>
<td>
</td>
<td>";

Displaycaptcha();

echo "</td>
<td align=right>
<p>
  <input type='submit' />
</p>
</td>
</tr>
</table>
  </form>
  </div>";
  }
  }
  

//if "email" is filled out, send email
if (isset($_REQUEST['email']))
  {



  //check if the email address is invalid
  $mailcheck = spamcheck($_REQUEST['email']);
  // check captcha 
  $captcha = CheckCaptcha();
  
  $message = validate($_REQUEST['message'],'hd');
  $subject = validate($_REQUEST['subject'],'hd');
  $orignialmessage = $message;
  $Junk_Check = new junkCheck($message . " " . $subject);
  $wordcount = str_word_count($orignialmessage,0);
  
  // add from to message
  $message = "From: " . validate($_REQUEST['email'],'hd') . "
  " . $message;

  // add Spam check info to message
   $message .= "
            Data: " . validate($_REQUEST['data'],'hd') . "  
            Captcha: " . validate($_REQUEST['Captcha'],'hd') . " : $captcha
            Referrer: " . validate($_REQUEST['referrer'],'hd') . "
            Referrer: " . validate($_SERVER['HTTP_REFERER'],'hd') . " 
            TimeStamp: " . validate($_REQUEST['time'],'hd');
            $ProcessTime = time() - validate($_REQUEST['time'],'hd');
            if ($ProcessTime <= 1){
                $ProcessTime = 1;
            }
   
   $message .= " 
           ProcessTime: " . $ProcessTime . " 
           WordCount: " . $wordcount . "
           Times Loaded: " . validate($_REQUEST['times'],'hd');
   
   $spamvalue = 0;
   if (strlen(validate($_REQUEST['referrer'],'hd'))==0){
       $spamvalue++;
   }
   if (validate($_REQUEST['referrer'],'hd') == validate($_SERVER['HTTP_REFERER'],'hd')){
       $spamvalue++;
   }
   if (str_word_count($orignialmessage . " " . $subject,0)/$ProcessTime >= 4){
       $spamvalue += round((str_word_count($orignialmessage . " " . $subject,0)/$ProcessTime));
   }
   if (validate($_REQUEST['times'],'hd') != 1){
       $spamvalue += validate($_REQUEST['times'],0);
   }
   // #todo: paramerterise the spamscore words.
   str_replace(["    ","   ","  ","https","!","earning"], ["    ","   ","  ","https","!","earning"], strtolower($orignialmessage . " " . $subject), $count1);
   $spamvalue += $count1;
   
   $message .= "
           SpamValue: " . $spamvalue;
        
    if ($mailcheck==TRUE || $captcha=='Fail'  || $spamvalue >= 50 || $spamvalue >= $wordcount)
    {
    echo parameters('JunkCheckFailMessage');
      echo "mailcheck: " . $mailcheck;
    echo "captcha: " . $captcha;
   // echo $Junk_Check;
    // todo: update to log, pause and lock out junk users
    
    if (validate($_REQUEST['times'],0) >= 5){
        // do not re-display 
    }else{
        echo $spamvalue;
    sleep(1+(2*$spamvalue)); // pause before re-displaying
    displaycontactform();
    }}
  else
    { 
    //send email

   //TODO check if parameters exist, if not revert to default paramters
   $from = parameters('ContactFromEmail');                //Get from address from parameters
   $Username = parameters('ContactFromUsername');         //Get SMTP username from paramters
   $Password = parameters('ContactFromPassword');         //SMTP password

   $subject = validate($_REQUEST['subject'], 'hd');    // Get Subject
      //  $message = validate($_REQUEST['message'], 'hd');    // Get News Message

    $mail = new PHPMailer(true);

    //import SMTP Server settings
    require 'template/emailServerSettings.php';
    /*
    //    $mail->SMTPDebug = SMTP::DEBUG_SERVER;            //Enable verbose debug output
    $mail->isSMTP();                                        //Send using SMTP
    $mail->Host       = parameters('SMTPHost');             //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                               //Enable SMTP authentication
    $mail->Username   = $Username;                          //SMTP username
    $mail->Password   = $Password;                          //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;        //Enable implicit TLS encryption
    //$mail->SMTPSecure = "ssl";
    $mail->Port       = parameters('SMTPPort'); //465;       //TCP port to connect to; use 587 if you have set 'SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
*/
    //Recipients

    $mail->addAddress(parameters('ContactEmail')); // add to address from parameters

    // add message to email
    $mail->Body    = $message;
    $mail->Subject = $subject;

    // try sending message

    try {
      $mail->send();
      echo "Thank you for using our mail form";
    } catch (Exception $e) {

    echo "Message could not be sent."; //. $mail->ErrorInfo;
    displaycontactform();

    // $email = validate($_REQUEST['email'],'hd');
    // $subject = validate($_REQUEST['subject'],'hd');
    // mail("$to", "Subject: $subject",     $message, "From: $email" );
    // echo "Thank you for using our mail form";
    }
  }
  }
else
//if "email" is not filled out, display the form
  {
    
    displaycontactform();
  }
?>
