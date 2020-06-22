<?php
$system = true;
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

//if "email" is filled out, send email
if (isset($_REQUEST['email']))
  {
  //check if the email address is invalid
  $mailcheck = spamcheck($_REQUEST['email']);
  if ($mailcheck==TRUE)
    {
    echo "Invalid input";
    }
  else
    { 
    //send email
    $to = parameters('ContactEmail');
//echo $to;
    $email = validate($_REQUEST['email'],'hd') ; 
    $subject = validate($_REQUEST['subject'],'hd') ;
    $message = validate($_REQUEST['message'],'hd') ;
    mail("$to", "Subject: $subject",
    $message, "From: $email" );
    echo "Thank you for using our mail form";
    }
  }
else
//if "email" is not filled out, display the form
  {
  echo "
      <div id=\"editbox\">
          <form method='post' action='?target=about&amp;section=contact'>
<table>
<tr>
<td>Email:
</td>
<td>
<input name='email' type='text' size='30' />
</td>
</tr>
<tr>
<td>Subject:
</td>
<td>
";
if (isset($_REQUEST['subject'])){
echo "<input name='subject' type='text' size='30' value=\"" . validate($_REQUEST['subject'],'hd') . "\" />";

}else{

echo "<input name='subject' type='text' size='30' />";
}

echo "
</td>
</tr>
<tr>
<td valign=top>
Message:
</td>
<td>
<textarea name='message' rows='15' cols='40'></textarea>
</td>
</tr>
<tr>
<td>
</td>
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
?>