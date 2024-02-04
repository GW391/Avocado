<?php

// Set to system page
$system = true;

// check security
if(security_check(parameters('SendNewsSecurity'))){

// set up form for upload and send news letter.
echo "<div id=\"editbox\">";
 echo "<form method='post' action='?target=news&amp;section=SendMail' enctype='multipart/form-data'>
     
<table>
<tr>
<td>News Letter attchment (Max. file size " . floor(parameters('maxfileuploadsize')/1024/1024) . " MB):
</td>
<td>
<input type='hidden' name='MAX_FILE_SIZE' value=' " . parameters('maxfileuploadsize') . "' />
<input type='file' name='file' id='file' size='30' />
</td>
</tr>
<tr>
<td>Actions</td>
<td>
Upload: <input type='checkbox' name='upload' value='upload' checked /><br />
Send: <input type='checkbox' name='send' value='send' checked /><br />
Test: <input type='checkbox' name='test' value='test' /><br />
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

echo "<input name='subject' type='text' size='30' value=\"" . parameters('NewsDefaultSubject') . "\" />";
}

echo "
</td>
</tr>
<tr>
<td valign=top>
Message:
</td>
<td>
<textarea name='message' rows='5' cols='40'>
" . parameters('NewsDefaultMessage') . "
</textarea>
</td>
<td> Please enter the details of the message, you can use :name to enter the subscribers names, and use :unsubscribe to enter there personal unsubscribe link.</td>
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
  </form>";
echo "</div>";
  }
else 
{
echo "You do not have permission to view this page";
}
?>
