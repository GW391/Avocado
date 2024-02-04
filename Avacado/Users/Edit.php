<?php
$system = true;
?>

<center><h2>
        <?php if (isset($_POST['CALID'])){
            echo "Edit";
            $create = False;
        }else{
                if(preg_match("/".'admin'."/i", $_SESSION['security'])){
                echo "Create";
                $create = True;
            }else{
                die('Sorry you do not have the permission to create users');
            }

        }
        ?>
        User</h2></center>

<form name="edit" action="?target=Users&amp;section=Save" method="post" spellcheck="false">

<?php

if (isset($_POST['CALID'])){
$UUID = validate(decryptfe($_POST['CALID']),'hd');
echo "<input type=\"hidden\" name=\"CALID\" value=\"" . encryptfe($UUID) . "\" size=\"20\" spellcheck=\"false\" />";

$select = "UUID, PRNME, PSY";
$From = "tblpdu";
$Where = "UUID = '$UUID'";
$limit = '1';
$die = "Sorry there is a problem on this page please, try again later. ";

$result = SQL($select, $From, $die, $Where, $limit, null, null);
$row = fetch_array($result);
$Name = ucfirst(validate(decrypt($row['PRNME']),'hd'));
//$Security = validate(decrypt($row['PSY']),'hd');

}else{
    $Name = '';
}
?>


<table width="100%" border="1">
    <thead>
    <tr>
    <th width="30%">Name</th>
    <td>
            <?php if(preg_match("/".'admin'."/i", $_SESSION['security'])){
                
        ?>
        <input type="text" name="name" value="<?php echo $Name; ?>" size="25" spellcheck="false" /></td>
        <?php
    }else{
        echo $Name;
    }    ?>

    </tr>
    <?php
    if ($create){

    ?>
    <tr>
    <th width="30%">Username</th>
    <td>
        <input type="text" name="username" value="" size="25" spellcheck="false" /></td>
    </tr>
    <tr>
    <th width="30%">Password</th>
    <td>
        <input type="password" name="password" value="" size="25" spellcheck="false" /></td>
    </tr>
    <tr>
    <th width="30%">Email Address</th>
    <td>
        <input type="email" name="email" value="" size="25" spellcheck="false" /></td>
    </tr>


    <?php
    }
    ?>

    <?php if(preg_match("/".'admin'."/i", $_SESSION['security'])){

    ?>

        <tr>
<th>Security</th>
    <td>

        <select name="Security[]" size="5" multiple>
<?php

        // get security parameters
	$Security = nl2br(parameters('Security'));
        $SecurityArray = explode('<br />', trim($Security));
        $num = count($SecurityArray);
        $i = 0;
while ($num > $i) {
    echo "<option value=\"" . trim($SecurityArray[$i]) . "\"";
    if(isset($row['PSY'])){
            if(preg_match("/".trim($SecurityArray[$i])."/i", validate($row['PSY'],'hd'))){
            echo "selected";
            }
    }
echo ">" . trim($SecurityArray[$i]) . "</option>\r\n";
    $i++;
}
        ?>
</select>
    </td>
    </tr>
<?php
    }
    ?>
<tr>
    <td></td>
    <td><input type="submit" name="Save" value=" Save " </td>
     </tr>


</tbody>

</table>

</form>
