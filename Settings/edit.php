<center><h2>Edit Settings</h2></center>

<?php
    if(preg_match("/".'admin'."/i", $_SESSION['security'])){
$system = true;
    ?>

<div id="editbox">
<form name="updateform" method="post" />
<input type="hidden" name="target" value="Settings" />
<input type="hidden" name="section" value="updateSave" />

<table width="100%" border="1">
    <thead>
    <tr>
    <th>Parameter </th>
    <th>Value </th>
    </tr>
</thead>
<tbody>

    <?php

if (isset($_POST['Edit'])){

$UUID = validate(decryptfe($_POST['Edit']),'hd');

// get settings
$select = "UUID, name, value, help, num_rows, cols, Options";
$From = "tblsettings";
$Where = "UUID  = '$UUID'";
$die = "Sorry there is a problem on this page please try again later";

//echo $UUID; 

$result = SQL($select, $From, $die, $Where, null, null, null);


while ($row = fetch_array($result)){
echo "Rows " . $row['num_rows'];
?>
    <tr>
    <td>
        <input type="hidden" value="<?php echo validate(encryptfe($row['UUID']),'hd') ?>" name="ID" readonly />
        <strong><?php echo validate($row['name'],'hd') ?></strong></td>
    <td>
        <?php 
        switch ($row['num_rows']) {
        case 'B':
        ?>

 <select name="value">
  <option value="1" <?php if(validate($row['value'],'hd') == 1){echo "selected";} ?>>Yes</option>
  <option value="0" <?php if(validate($row['value'],'hd') == 0){echo "selected";} ?>>No</option>
 </select>
        <?php
        break;
    case 1:
        ?>
        <input type="text" size="<?php echo validate($row['cols'],'n') ?>" name="value" value="<?php echo validate($row['value'],'hd') ?>" />
<?php
        break;
    case 'D':
//((!preg_match("/_thm/i",$item))
        if (preg_match("/parameter/i", $row['Options'])){
            //echo "parameter";
            $parameter = substr($row['Options'], 10, strlen($row['Options']));
            //echo $parameter;
            $Options = nl2br(parameters($parameter));
            //echo $Options;
        }else{
            //echo "list";
            $Options = nl2br($row['Options']);
        }


        echo "<select name=\"value\">";


        // get security parameters

        $OptionsArray = explode('<br />', trim($Options));
        $num = count($OptionsArray);
        $i = 0;
        echo "<option value=\"\"></option>\r\n";
while ($num != $i) {
    if (strlen(trim($OptionsArray[$i])) != 0){
    echo "<option value=\"" . trim($OptionsArray[$i]) . "\"";
    if(preg_match("/".trim($OptionsArray[$i])."/i", validate($row['value'],'hd'))){
            echo "selected";
            }
echo ">" . trim($OptionsArray[$i]) . "</option>\r\n";
    
}
$i++;
}

echo "</select>";
            ?>

                <?php
        break;
    case 'M':
//((!preg_match("/_thm/i",$item))
        if (preg_match("/parameter/i", $row['Options'])){
            //echo "parameter";
            $parameter = substr($row['Options'], 10, strlen($row['Options']));
            //echo $parameter;
            $Options = nl2br(parameters($parameter));
            //echo $Options;
        }else{
            //echo "list";
            $Options = nl2br($row['Options']);
        }


        echo "<select name=\"value[]\" multiple>";


        // get security parameters

        $OptionsArray = explode('<br />', trim($Options));
        $num = count($OptionsArray);
        $i = 0;
        echo "<option value=\"\"></option>\r\n";
while ($num != $i) {
    if (strlen(trim($OptionsArray[$i])) != 0){
    echo "<option value=\"" . trim($OptionsArray[$i]) . "\"";
    if(preg_match("/".trim($OptionsArray[$i])."/i", validate($row['value'],'hd'))){
            echo "selected";
            }
echo ">" . trim($OptionsArray[$i]) . "</option>\r\n";
    
}
$i++;
}

echo "</select>";
            ?>

                
                <?php

        break;
            case 'F':
//((!preg_match("/_thm/i",$item))
        if (preg_match("/parameter/i", $row['Options'])){
            //echo "parameter";
            $parameter = substr($row['Options'], 10, strlen($row['Options']));
            //echo $parameter;
            $Options = nl2br(parameters($parameter));
            //echo $Options;
        }else{
            //echo "list";
            $Options = nl2br($row['Options']);
        }


        echo "<select name=\"value\">";


        // get security parameters

        $OptionsArray = explode('<br />', trim($Options));
        $num = count($OptionsArray);
        $i = 0;
        $optgroup = 0;
        echo "<option value=\"\"></option>\r\n";
while ($num != $i) {
    //echo strlen(trim($OptionsArray[$i]));
    if (strlen(trim($OptionsArray[$i])) != 0){
    if (substr(trim($OptionsArray[$i]),0,3) == '---'){
        if ($optgroup == 1){
          echo '</optgroup>\r\n';  
        }
        echo "<optgroup label=\"" . trim($OptionsArray[$i]) . "\">";
        $optgroup = 1;
    }else{
            
    echo "<option style=\"font-family: " . trim($OptionsArray[$i]) . "\" value=\"" . trim($OptionsArray[$i]) . "\"";
    if(preg_match("/".trim($OptionsArray[$i])."/i", trim(validate($row['value'],'hd')))){
            echo " selected ";
            }
echo ">" . trim($OptionsArray[$i]) . "</option>\r\n";
    }
    
    }
    $i++;
    }
echo "</optgroup>";
echo "</select>";
            ?>
<?php
        break;
        case 'N':
            ?>
           <input type="number" size="<?php echo validate($row['cols'],'n') ?>" name="value" value="<?php echo validate($row['value'],'hd') ?>" />
        <?php
        break;
        default:
        ?>

       <textarea rows="<?php echo validate($row['num_rows'],'n') ?>" cols="<?php echo validate($row['cols'],'n') ?>" name="value">
<?php echo validate($row['value'],'hd') ?>
        </textarea>
        <?php
        break;
}
        ?>


        </td>

        <td>
            <?php echo validate($row['help'],'hd') ?>
        </td>
    </tr>
<?php
    }
    }else {

    ?>
sorry no record selected to edit.
<?php
    }
?>

    
  <tr>
<td><input type="hidden" name="number" value="" /></td>
<td></td>
<td><input type="submit" name="Save" value=" Save " /></td>
</tr>
</tbody>

</table>

</form>

<?php
}else{
echo "Sorry you don't have the permission to edit parameters";
}
?>
    </div>