<?php 

$system = true;

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

$result = SQL($Select, $From, $die, $where, $Limit, $GROUP, $sort);

$from = "<" . parameters('NewsFromEmail') . ">";
        $subject = validate($_REQUEST['subject'], 'hd');
        $message = validate($_REQUEST['message'], 'hd');
        $fname = $_FILES["file"]["name"];
        $filename = "news/" . $fname;
        $curURL = curURL(parameters('SSL'), 1);
        move_uploaded_file($_FILES["file"]["tmp_name"],
        $filename);

//echo $filename;

if(isset($_REQUEST['send']) && (validate($_REQUEST['send'],'hd') == 'send')){
    echo "send flag is set, send the news letter";

while ($row = fetch_array($result)){

    $Name = validate(decrypt($row['RName']),'hd');
    $URL = $curURL . "?target=news&section=subscribe&Unsubscribe=" . urlencode("$id");
    $find = array(":NAME", ":unsubscribe");
    $replace = array($Name, $URL);
    $updatedmessage = str_ireplace($find, $replace, $message);


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
             if ($build <= 20240128){
                $email = validate(decrypt_20240128($row['Email']),'hd');
             }else{
                 $email = validate(decrypt($row['Email']),'hd');
             }
        $to = $Name . " <" . $email . ">";
        $ok = mail($to, $subject, $emessage, implode("\r\n", $headers));
	echo "<strong>" .  $Name . ": ";
	if ($ok) {
		echo '<img src="images/icons/greentick.png" alt="success" name="success" />';
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
                }
        }else{
		echo '<img src="images/icons/delete.png" alt="Failed" name="failed" />';
                
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

    
    }
    // close if send
}

if(!isset($_REQUEST['upload']) || (validate($_REQUEST['upload'],'hd') != 'upload')){
        echo "file is for send only, delete the file now its sent.";
        unlink($filename);
    }else{
        echo "file is uploaded";
    }}}else{
    echo "Sorry you don't have the permission to use this page";
}
?>
