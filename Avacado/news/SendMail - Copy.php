<?php

// Set to system page
$system = true;

// set security
if(stripos($_SESSION['security'], parameters('SendNewsSecurity'))){
echo 'security passed';
// clear any open SQL
//mysql_free_result($result);

//Getfile to save

if (!isset($_FILES["file"]["error"])){
echo "Error: Sorry there has been a problem uploading your file. This is usualy caused by a timeout, try again or try splitting the file into smaller chunks<br />";
echo $_FILES["file"]["error"];

$fail=true;
}else{
  if ($_FILES["file"]["error"] > 0)
    {
    $i=$_FILES["file"]["error"];
switch ($i) {
   case 0:
         echo "The file uploaded with success.";
         $fail = true;
         break;
   case 1:
         echo "Error: The uploaded file exceeds the maximum file size - Please try reducing the file size";
         $fail = true;
         break;
   case 2:
         echo "Error: The uploaded file exceeds the maximum file size - Please try reducing the file size";
         $fail = true;
         break;
   case 3:
         echo "Error: The uploaded file was only partially uploaded - Please try again";
         $fail = true;
         break;
   case 4:
         echo "Error: No file was uploaded - Please try again";
         $fail = true;
         break;
   case 5:
         echo "Error: Sorry there has been a problem uploading your file - Please try again";
         $fail = true;
         break;
   case 6:
         echo "Error: Sorry there has been a problem uploading your file - Please try again";
         $fail = true;
         break;
   case 7:
         echo "Error: Sorry there has been a problem uploading your file - Please try again";
         $fail = true;
         break;
}





require ("template/hotsprings.php");

       // to, from, subject, message body, attachment filename, etc.

        $from = parameters('NewsFromEmail');
        $subject = validate($_REQUEST['Subject'], 'hd');
        $message = validate($_REQUEST['Message'], 'hd');
        $fname = $_FILES["file"]["name"];
	$filename = "news/" . fname;

move_uploaded_file($_FILES["file"]["tmp_name"],
      $filename);

        $headers = "From: $from"; 
        // boundary 
        $semi_rand = md5(time()); 
        $mime_boundary = "==Multipart_Boundary_x{$semi_rand}x"; 

        // headers for attachment 
        $headers .= "\nMIME-Version: 1.0\n" . "Content-Type: multipart/mixed;\n" . " boundary=\"{$mime_boundary}\""; 

        // multipart boundary 
        $message = "This is a multi-part message in MIME format.\n\n" . "--{$mime_boundary}\n" . "Content-Type: text/plain; charset=\"iso-8859-1\"\n" . "Content-Transfer-Encoding: 7bit\n\n" . $message . "\n\n"; 
        $message .= "--{$mime_boundary}\n";

        // preparing attachments            
            $file = fopen($filename,"rb");
            $data = fread($file,filesize($filename));
            fclose($file);
            $data = chunk_split(base64_encode($data));
            $message .= "Content-Type: {\"application/octet-stream\"};\n" . " name=\"".$fname."\"\n" . 
            "Content-Disposition: attachment;\n" . " filename=\"$fname\"\n" . 
            "Content-Transfer-Encoding: base64\n\n" . $data . "\n\n";
            $message .= "--{$mime_boundary}--\n";


        // send
        //print $message;

$Select = "Email";
$From = "tblnewsletter";
$GROUP = null;
$die = "Sorry there is a problem on this page please, try again later";
$where = null;
$Limit = null;
$sort = null;
$result = SQL($Select, $From, $die, $where, $Limit, $GROUP, $sort);

while ($row = mysql_fetch_array($result)){
        $to = validate(decrypt($row['Email']),'hd');
        $ok = mail($to, $subject, $message, $headers, "-f " . $from);
	echo $to . ": ";
	if ($ok) {
		echo "Sent";
        }else{
		echo "Failed";		
	}
	echo "<br />";
}
}}}
mysql_free_result($result);
?>
