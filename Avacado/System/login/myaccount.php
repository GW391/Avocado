<?php
if ($_SESSION['user']){

$UUID = validate($_SESSION['puid'], "n");

                        $Select = "UUID, PRNME, PEL, PLLDate, PVD";
                        $From = "tblpdu";
                        $Limit = 1;
                        $die = "Sorry I am unable to display your details" ;
                        $sort = null;
                        $Where = "UUID = '$UUID'";
                        $GROUP = null;
        
                        $result = SQL($Select, $From, $die, $Where, $Limit, $GROUP, $sort);


$row = fetch_array($result);

$email = validate(decrypt($row['PEL']));
$Name = validate(decrypt($row['PRNME']));
$LLDate = $row['PLLDate'];

?>

<table>
<tr>
<td><strong>Name</strong></td>
<td><?php echo $Name; ?></td>
</tr>
<tr>
<td><strong>Email</strong></td>
<td><?php echo $email; ?></td>
</tr>
<tr>
<td><strong>Last Login</strong></td>
<td>
<?php

$datetime = new DateTime($LLDate);
echo $datetime->format('d/m/Y H:i:s');
?>
</td>
</tr>
</table>

<?php
}else{
echo 'Sorry you are not logged in, please log in to see this page';
}
?>
<?php 

    // Old host did not allow ssl on main URL, they used a global certificate.  I suspect this is no longer a problem anywhere
    // but left parameter and if statment.
if($_SERVER['HTTPS']!="on"){
if(parameters('SSL')){
    echo '<p class="small">Concerened about security?  <a href="';

    if (parameters('SSLURL')){
        echo parameters('SSLURL');
        echo $_SERVER["REQUEST_URI"];
    }else{
        echo curPageURL(parameters('SSL'), 1);
    }

    echo '">Switch to our secure site</a></p>';
}
}

?>
