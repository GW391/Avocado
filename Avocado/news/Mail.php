<?php
// check if TinyMCEKey existis if so import TinyMCE for use.
if (null != (parameters('TinyMCEKey')) && strlen(trim(parameters('TinyMCEKey'))) != 0){
require_once 'template/TinyMCECloud.php';
}

?>

<?php

// Set to system page
$system = true;

// check security
// check if current user can send news
if(security_check(parameters('SendNewsSecurity'))){
  // check if current user can edit parameters
  if(security_check(parameters('SettingsSecurity'))){
    // if current user can edit parameters, display parameters link.
echo '<div id="edit">';
echo '<a href="?target=Settings&amp;limit=News">News Settings</a>';
echo '</div>';
  }
// set up form for upload and send news letter.
echo "<div id=\"editbox\">";
 echo "<form method='post' action='?target=news&amp;section=SendMail' enctype='multipart/form-data'>
     
<table border='1'>
<tr>
<td width='20%'><label for='file'>News Letter attchment (Max. file size " . floor(parameters('maxfileuploadsize')/1024/1024) . " MB):</label>
</td>
<td width='50%'>
<input type='hidden' name='MAX_FILE_SIZE' value=' " . parameters('maxfileuploadsize') . "' />
<input type='hidden' name='type' value='news' />
<input type='file' name='file' id='file' size='30' />
</td>
</tr>
<tr>
<td>Actions</td>
<td>
<label for='Upload'>Upload: </label><input type='checkbox' name='upload' value='upload' checked /><br />
<label for='Send'>Send: </label><input type='checkbox' name='send' value='send' checked /><br />
<label for='Test'>Test: </label><input type='checkbox' name='test' value='test' /><br />
</td>
</tr>
<tr>
  <td><label for='Upload'>Date</label></td>
  <td><input type='date' name='Date' value='";
    if(isset($row['Date'])){
      echo validate($row['Date'],'hd');
    }else{
      echo Date('Y-m-d');
    }
    echo "'>
    <div class='small'>Enter the date for the news letter</div>
    </td>
  </tr>
<tr>
<td><label for='subject'>Subject:</label>
</td>
<td>
";
if (isset($_REQUEST['name'])){
echo "<input name='name' type='text' size='30' value=\"" . validate($_REQUEST['name'],'hd') . "\" />";

}else{

echo "<input name='name' type='text' size='30' value=\"" . parameters('NewsDefaultSubject') . "\" />";
}

echo "
<div class='small'>Enter the subject for the email</div>
</td>
</tr>
<tr>
<td valign=top>
<label for='Message'>Message:</label>
</td>
<td>
<textarea name='message' rows='20' cols='50'>
" . parameters('NewsDefaultMessage') . "
</textarea>
<div class='small' id='small'> Please enter the details of the message, you can use
  <ul>
    <li>:name to enter the subscribers names.</li>
    <li>:unsubscribe to enter there personal unsubscribe link.</li>
    <li>:Organisation to enter your Organisation name.</li>
    <li>:IncYear to enter your Incorporated / Copyright year.</li>
  </ul>
</div>
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
  </form>";
echo "</div>";
  }
else 
{
echo "You do not have permission to view this page";
}
?>
