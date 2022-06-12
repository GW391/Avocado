<center><h2>Edit Menu</h2></center>

<?php
if(preg_match("/".'editor'."/i", $_SESSION['security'])){
    $system = true;
?>
<div id="editbox">
<form name="updateform" method="post" action="?" />
<input type="hidden" name="target" value="<?php echo $target?>" />
<input type="hidden" name="section" value="<?php echo $section?>" />
<input type="hidden" name="subsection" value="updateSave" />


<table width="100%" border="1">
<thead>
</thead>
<tbody>


    <?php

print_r($_POST);



if (isset($_POST['Edit'])){

$UUID = validate(decryptfe($_POST['Edit']),'hd');

// get settings
$select = "UUID, target, section, subsection, extra, security, sortorder, DispName, ShortArticle, Articles, PublicPost , ContName, TLD, notloggedin, sitemap";
$From = "tblmenu";
$Where = "UUID  = '$UUID'";
$die = "Sorry there is a problem on this page please try again later";

$result = SQL($select, $From, $die, $Where, null, null, null);

while ($row = fetch_array($result)){

?>
    <tr>
        <th>Display Name</th>
    <td>
        <input type="hidden" value="<?php echo validate(encryptfe($row['UUID']),'hd') ?>" name="ID" readonly />
        <input type="text" value="<?php echo validate($row['DispName'],'hd') ?>" name="eDispName" size="25" /> </td>
    </tr>
    <tr>
        <th>Target</th>
        <td><input type="text" value="<?php echo validate($row['target'],'hd') ?>" name="etarget" size="25" /> </td>
    </tr>
    <tr>
        <th>Section</th>
        <td><input type="text" value="<?php echo validate($row['section'],'hd') ?>" name="esection" size="25" /> </td>
    </tr>
    <tr>
        <th>Subsection</th>
       <td><input type="text" value="<?php echo validate($row['subsection'],'hd') ?>" name="esubsection" size="25" /> </td>
    </tr>
        <tr>
        <th>Extra</th>
       <td><input type="text" value="<?php echo validate($row['extra'],'hd') ?>" name="eextra" size="25" /> </td>
    </tr>
    <tr>
<th>Security</th>
    <td>
        <select name="esecurity">
  <option value=""></option>
        <?php

        // get security parameters
	$Security = nl2br(parameters('Security'));
        $SecurityArray = explode('<br />', trim($Security));
        $num = count($SecurityArray);
        $i = 0;
while ($num > $i) {
    echo "<option value=\"" . trim($SecurityArray[$i]) . "\"";
        if(validate($row['security'],'hd') == trim($SecurityArray[$i])){
            echo "selected";
            }
echo ">" . trim($SecurityArray[$i]) . "</option>\r\n";
    $i++;
}
        ?>
</select>    </tr>
    
       <tr>
<th>Include in Sitemap</th>
    <td><input type="checkbox" <?php if(validate($row['sitemap'],'hd')==1){echo "checked";}?>  name="esitemap" size="25" /> </td>
    </tr>
    
    <tr>
        
<th>Sort Order</th>
    <td><input type="text" value="<?php echo validate($row['sortorder'],'hd') ?>" name="esortorder" size="25" /> </td>
    </tr>
    <tr>
<th>Top Level Directory</th>
    <td><input type="checkbox" <?php if(validate($row['TLD'],'hd')==1){echo "checked";}?>  name="eTLD" size="25" /> </td>
    </tr>
    <tr>
        <th>Articles</th>
    <td><input type="text" value="<?php echo validate($row['Articles'],'hd') ?>" name="earticles" size="25" /> </td>

    </tr>
    <tr>
<th>Short Articles</th>
    <td>
        <select name="eShortArticle">
  <option value=""></option>
  <option value="0"
          <?php if (validate($row['ShortArticle'],'n') == 0){
             echo "selected" ;
          }?>
          >No</option>
  <option value="1"
          <?php if (validate($row['ShortArticle'],'n') == 1){
             echo "selected" ;
          }?>
          >Yes</option>
        </select>
    </tr>
    
        <tr>
<th>Public Posting</th>
    <td>
        <select name="ePublic">
  <option value=""></option>
  <option value="0"
          <?php if (validate($row['PublicPost'],'n') == 0){
             echo "selected" ;
          }?>
          >No</option>
  <option value="1"
          <?php if (validate($row['PublicPost'],'n') == 1){
             echo "selected" ;
          }?>
          >Yes</option>
        </select>
        </td>
    </tr>
            <tr>
<th>Content Name</th>
<td><input type="text" value="<?php echo validate($row['ContName'],'hd') ?>" name="eContName" size="25" /> </td>

    </tr>
<th>Only show when not logged in: <br />Note if security is set, this will prevent the item being visible at all</th>
    <td><input type="checkbox" <?php if(validate($row['notloggedin'],'hd')==1){echo "checked";}?>  name="enotloggedin" size="25" /> </td>
    </tr>

            <?php
    }
    } elseif (isset($_POST['Delete'])){

        echo 'is delete ';
$UUID = validate(decryptfe($_POST['Delete']),'hd');

echo $UUID;

// get settings
$select = "UUID, target, section, subsection, extra, security, sortorder, DispName, ShortArticle, Articles, PublicPost , ContName, TLD, notloggedin";
$From = "tblmenu";
$Where = "UUID  = '$UUID'";
$die = "Sorry there is a problem on this page please try again later";

$result = SQL($select, $From, $die, $Where, null, null, null);

echo num_rows($result);

while ($row = fetch_array($result)){
    echo "<b>Delete  ";
    if (isset ($target) && strlen(trim($target)) > 0){
        echo validate($row['target'],'hd');
    }
    if (isset ($section) && strlen(trim($section)) > 0){
        echo " - " . validate($row['section'],'hd');
    }
    if (isset ($subsection)  && strlen(trim($subsection)) > 0){
        echo " - " . validate($row['subsection'],'hd');
    }
    echo ", Are you sure?</b>"
?>

    <input type="hidden" value="<?php echo validate(encryptfe($row['UUID']),'hd') ?>" name="ID" readonly />
    <input type="hidden" value="1" name="deleted" readonly />
<?php
}


    //echo "Sorry Delete is not enabled yet";


    }elseif (isset($_POST['New'])){
        ?>
            <tr>
        <th>Display Name</th>
      
        <td><input type="text" value="" name="eDispName" size="25" /> </td>
    </tr>
    <tr>
        <th>Target</th>
        <td><input type="text" value="<?php if(isset($_REQUEST['etarget'])){echo validate($_REQUEST['etarget'],'hd');}?>" name="etarget" size="25" /> </td>
    </tr>
    <tr>
        <th>Section</th>
        <td><input type="text" value="" name="esection" size="25" /> </td>
    </tr>
    <tr>
        <th>Subsection</th>
       <td><input type="text" value="" name="esubsection" size="25" /> </td>
    </tr>
        <tr>
        <th>Extra</th>
       <td><input type="text" value="" name="extra" size="25" /> </td>
    </tr>
    <tr>
<th>Security</th>
    <td>
    
        <select name="esecurity">
  <option value=""></option>
        <?php

        // get security parameters
	$Security = nl2br(parameters('Security'));
        $SecurityArray = explode('<br />', trim($Security));
        $num = count($SecurityArray);
        $i = 0;
while ($num > $i) {
    echo "<option value=\"" . trim($SecurityArray[$i]) . "\"";
echo ">" . trim($SecurityArray[$i]) . "</option>\r\n";
    $i++;
}
        ?>
</select>
    </td>
    </tr>
          <tr>
<th>Include in Sitemap</th>
    <td><input type="checkbox" checked  name="esitemap" /> </td>
    </tr>
    <tr>
<th>Sort Order</th>
    <td><input type="text" value="" name="esortorder" size="25" /> </td>
    </tr>
    <tr>
<th>Top Level Directory</th>
    <td><input type="checkbox" name="eTLD" size="25" /> </td>
    </tr>

    <tr>
        <th>Articles</th>
    <td><input type="number" value="0" name="earticles" size="25" /> </td>

    </tr>
        <tr>
<th>Short Articles</th>
    <td>
        <select name="eShortArticle">
  <option value=""></option>
  <option value="0" selected>No</option>
  <option value="1">Yes</option>
        </select>
    </tr>
      
        <tr>
<th>Public Posting</th>
    <td>
        <select name="ePublic">
  <option value=""></option>
  <option value="0" selected>No</option>
  <option value="1" >Yes</option>
        </select>
        </td>
    </tr>
            <tr>
<th>Content Name</th>
<td><input type="text" value="" name="econtname" size="25" /> </td>
            </tr>
</tr>
<th>Only show when not logged in: <br />Note if security is set, this will prevent the item being visible at all</th>
    <td><input type="checkbox" name="enotloggedin" size="25" /> </td>
    </tr>
    <?php
    }else{
    ?>
sorry no record selected to edit.
<?php
    }
?>


  <tr>
<td><input type="hidden" name="number" value="" /></td>
<td>
<?php
    if (isset($_POST['Delete'])){
        echo "<input type=\"submit\" name=\"Save\" value=\" Delete \" />";
    }else{

    ?>
    <input type="submit" name="Save" value=" Save " />
    <?php
    }
    ?>
</td>
</tr>
</tbody>

</table>

</form>
</div>
<?php
}else{
echo "Sorry you don't have the permission to edit parameters";
}
?>