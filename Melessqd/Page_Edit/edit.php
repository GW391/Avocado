<?php 
require_once 'template/TinyMCECloud.php';

?>

        <?php
        
// get menu dropdown data (Target, Section, subsection)

function getTargetMenu(){
//Get Target
$Select = "if (tld = 1, 
    CASE WHEN subsection IS NOT NULL THEN subsection
       WHEN section IS NOT NULL THEN section
		 else target
    END, target) AS Rtarget, tld, target, section, subsection, system, 
	 CASE WHEN DispName IS NOT NULL THEN DispName
	 WHEN subsection IS NOT NULL THEN subsection
         WHEN section IS NOT NULL THEN section 
	 ELSE target
	 end AS DispName, target, deleted";
$From = "tblmenu";
$GROUP = "Rtarget, CASE WHEN tld IS NOT NULL THEN tld ELSE 0 end";
$die = "Sorry there is a problem on this page please, try again later";
$where = "system !=1 AND (section IS NULL || tld = 1) and deleted != 1 AND extra IS null";
$Limit = null;
$sort = "Rtarget, sortorder";
$Targetresult = SQL($Select, $From, $die, $where, $Limit, $GROUP, $sort);
return $Targetresult;
}
?>

        <?php
        //Get Section    
            function getSectionMenu($PTarget){
    
    $Select = "section,
        CASE WHEN DispName IS NOT NULL THEN DispName
	 WHEN subsection IS NOT NULL THEN subsection
         WHEN section IS NOT NULL THEN section 
	 ELSE target
	 end AS DispName";
$From = "tblmenu";
$GROUP = "section";
$die = "Sorry there is a problem on this page please, try again later";
$where = "deleted != 1 && target = '$PTarget' && tld != 1 && section != ''";
$Limit = null;
$sort = "section, sortorder";
$secresult = SQL($Select, $From, $die, $where, $Limit, $GROUP, $sort);
return $secresult;
}
?>

            <?php
            function getSubsectionMenu($PTarget, $PSection){
// get subsection list
        if (isset($PSection)){
   // $esection = validate($_REQUEST['esection'],'hd');
    $Select = "subsection,
        CASE WHEN DispName IS NOT NULL THEN DispName
	 WHEN subsection IS NOT NULL THEN subsection
         WHEN section IS NOT NULL THEN section 
	 ELSE target
	 end AS DispName";
$From = "tblmenu";
$GROUP = "section";
$die = "Sorry there is a problem on this page please, try again later";
$where = "deleted != 1 && target = '$PTarget' && tld != 1 && section = '$PSection' && subsection != ' '";
$Limit = null;
$sort = "subsection, sortorder";
$subsecresult = SQL($Select, $From, $die, $where, $Limit, $GROUP, $sort);
}
return $subsecresult;
}
?>

    <script language = "javascript" type = "text/javascript">
         <!--

// - script split.
            //Browser Support Code
            function ajaxTarget(){
               var ajaxRequest;  // The variable that makes Ajax possible!
               
               try {
                  // Opera 8.0+, Firefox, Safari
                  ajaxRequest = new XMLHttpRequest();
               }catch (e) {
                  // Internet Explorer Browsers
                  try {
                     ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
                  }catch (e) {
                     try{
                        ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
                     }catch (e){
                        // Something went wrong
                        alert("Your browser broke!");
                        return false;
                     }
                  }
               }
               
               // Create a function that will receive data 
               // sent from the server and will update
               // div section in the same page.
					
               ajaxRequest.onreadystatechange = function(){
                  if(ajaxRequest.readyState == 4){
                     var ajaxDisplay = document.getElementById('SectionDiv');
                     ajaxDisplay.innerHTML = ajaxRequest.responseText;
                  }
               }
               
               // Now get the value from user and pass it to
               // server script.
					
               var target = document.getElementById('target').value;
               var queryString = "?target=" + target;
               ajaxRequest.open("GET", "ajax-Target.php" + queryString, true);
               ajaxRequest.send(null); 
               
                var s = document.getElementById('esection');
                s.value = "";
               SectionFunction();               
            }
            
            
            // -- script split
            
                        //Browser Support Code
            function SectionFunction(){
               var ajaxRequest;  // The variable that makes Ajax possible!
               
               try {
                  // Opera 8.0+, Firefox, Safari
                  ajaxRequest = new XMLHttpRequest();
               }catch (e) {
                  // Internet Explorer Browsers
                  try {
                     ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
                  }catch (e) {
                     try{
                        ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
                     }catch (e){
                        // Something went wrong
                        alert("Your browser broke!");
                        return false;
                     }
                  }
               }
               
               // Create a function that will receive data 
               // sent from the server and will update
               // div section in the same page.
					
               ajaxRequest.onreadystatechange = function(){
                  if(ajaxRequest.readyState == 4){
                     var ajaxDisplay = document.getElementById('SubSectionDiv');
                     ajaxDisplay.innerHTML = ajaxRequest.responseText;
                  }
               }
               
               // Now get the value from user and pass it to
               // server script.
					
               var section = document.getElementById('esection').value;
               var queryString = "?section=" + section;
               ajaxRequest.open("GET", "ajax-Section.php" + queryString, true);
               ajaxRequest.send(null); 
            }
         //-->
      </script>



<center><h2>Edit Article</h2></center>

<?php
if(preg_match("/".$ArticleEditor."/i", $_SESSION['security'])){

$system = true;
    ?>
<div id="editbox">
<form name="updateform" method="post" />
<input type="hidden" name="target" value="Page_Edit" />
<input type="hidden" name="section" value="updateSave" />

<table width="95%" border="1">
    <thead>

</thead>
<tbody>


    <?php

if (isset($_REQUEST['Edit'])){

$UUID = validate(decryptfe($_REQUEST['Edit']),'hd');

// get stock
$select = "UUID, target, section, subsection, security, sdate, fdate, header, page, format, active, System, sortorder";
$From = "tblcontent";
$Where = "UUID  = '$UUID'";
$die = "Sorry there is a problem on this page please try again later";

$result = SQL($select, $From, $die, $Where, null, null, null);

while ($row = fetch_array($result)){
?>
<input type="hidden" value="<?php echo validate(encryptfe($row['UUID']),'hd') ?>" name="ID" readonly />
    <tr>
        <th>Target </th>
    <td>
    
            <select id = 'target' name="etarget" onchange = 'ajaxTarget()'> 
<option value = ""></option>

<?php 
$TargeResult = getTargetMenu();
$etfound=0;
while ($Trow = fetch_array($TargeResult)){?>
            <option value = "<?php echo validate($Trow['Rtarget'],'hd') ?>"
                    <?php if (validate($row['target'],'hd') == validate($Trow['Rtarget'],'hd')){
                        echo "selected";
                        $etfound++;
                    } ?>
                    ><?php echo validate($Trow['DispName'],'hd') ?></option>
<?php } 

if ($etfound == 0) { ?>
    <option value = "<?php echo validate($row['target'],'hd') ?>" selected ><?php echo validate($Trow['target'],'hd') ?></option>
    <?php }
?>

         </select>
    
       <?php // <strong><?php echo validate($row['target'],'hd') ?><?php // </strong>?>
    </td>
    <th>Security</th>

    <td>

        <select name="security">
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
</select>
    </td>
    </tr>
    
    <tr>
        <th>Section </th>
    <td>
    
        <div id = 'SectionDiv'>
    

    
<!--Section:-->
<select id = 'esection' name="esection" onchange = 'SectionFunction()'>
<option value = ""></option>

<?php 
$etarget = validate($row['target'],'hd');
    $secresult = getSectionMenu($etarget);
$esfound=0;
while ($Secrow = fetch_array($secresult)){?>
            <option value = "<?php echo validate($Secrow['section'],'hd') ?>"
            <?php 
                if (validate($row['section'],'hd') != NULL){
                    if (validate($row['section'],'hd') == validate($Secrow['section'],'hd')){
                        echo "selected";
                        $esfound++;
                    }} ?>
                    ><?php echo validate($Secrow['section'],'hd') ?></option>
<?php } 

if ($esfound == 0 && validate($row['section'],'hd') != NULL) { ?>
    <option value = "<?php echo validate($row['section'],'hd') ?>" selected ><?php echo validate($row['section'],'hd') ?></option>
    <?php }
?>
</select>
    </div>
    
       <?php // <strong><?php echo validate($row['section'],'hd') ?><?php //</strong>?>
    </td>
        <th>Format </th>
    <td>
        <select name="format">
  <option value=""></option>
  <option value="Text" <?php if(validate($row['format'],'hd') == "Text"){echo "selected";} ?>>Text</option>
  <option value="HTML" <?php if(validate($row['format'],'hd') == "HTML"){echo "selected";} ?>>HTML</option>
  </select>
         </td>
    </tr>
        <tr>
    <th>Sub-Section </th>
    <td>
    
        <div id = 'SubSectionDiv'> 
    <select id = 'esubsection' name="esubsection">
    <option value = ""></option>
    <?php 
    $esection = validate($row['section'],'hd');
    $subsecresult = getSubsectionMenu($etarget, $esection);
    if (isset($subsecresult)){
$essfound=0;
while ($SubSecrow = fetch_array($subsecresult)){?>
            <option value = "<?php echo validate($SubSecrow['subsection'],'hd') ?>"
            <?php 
                if (isset($_REQUEST['esubsection'])){
                    if (validate($row['subsection'],'hd') == validate($SubSecrow['subsection'],'hd')){
                        echo "selected";
                        $essfound++;
                    }} ?>
                    ><?php echo validate($SubSecrow['subsection'],'hd') ?></option>
<?php } 

if ($essfound == 0) { ?>
    <option value = "<?php echo validate($row['subsection'],'hd') ?>" selected ><?php echo validate($row['subsection'],'hd') ?></option>
    <?php }
    }
?>

</select>
</div>
        <?php //<strong><?php echo validate($row['subsection'],'hd') ?><?php //</strong>?>
    </td>
    <th>Active </th>
    <td>
        <select name="active">
  <option value=""></option>
  <option value="0" <?php if(validate($row['active'],'hd') == "0"){echo "selected";} ?>>No</option>
  <option value="1" <?php if(validate($row['active'],'hd') == "1"){echo "selected";} ?>>Yes</option>
  </select>
         </td>
    </tr>
    <tr>
        <th>Visible between</th>
    <td>
        <input type="date" name="sdate" value="<?php echo validate($row['sdate'],'hd') ?>" size="10" />
-
        <input type="date" name="fdate" value="<?php echo validate($row['fdate'],'hd') ?>" size="10" />
    </td>
        <th>System Page</th>

    <td>

        <select name="System">
  <option value=""></option>
        <?php

        // get security parameters
	$SystemPages = nl2br(parameters('SystemPages'));
        $SystemArray = explode('<br />', trim($SystemPages));
        $Systemnum = count($SystemArray);
        $Systemi = 0;
while ($Systemnum > $Systemi) {
    echo "<option value=\"" . trim($SystemArray[$Systemi]) . "\"";
        if(validate($row['System'],'hd') == trim($SystemArray[$Systemi])){
            echo "selected";
            }
echo ">" . trim($SystemArray[$Systemi]) . "</option>\r\n";
    $Systemi++;
}
        ?>
</select>
    </td>
</tr>

<?php 
// header is deprecated turn off for pages with no header
if (isset($row['header']) or parameters('ArticleHeader') == '1'){
	if (strlen(trim($row['header']))!= 0 or parameters('ArticleHeader') == '1'){ ?>
 <tr>
             <th>Header </th>
    <td colspan="3">
       <textarea rows="5" cols="85" name="header"><?php echo validate($row['header'],'hd') ?></textarea>
         </td>
         </tr>
<?php }else {
?>
<input type="hidden" name="header" value="" />
<?php }?>
      <?php }else {
?>
<input type="hidden" name="header" value="" />
<?php }?>
        <tr>
    <th>Article </th>
    <td  colspan="3">
        <textarea rows="30" cols="85" name="page"><?php echo validate($row['page'],'hd') ?></textarea>
         </td>
    </tr>
<?php
    }
    }else{

    ?>

        <tr>
    <th>Target </th>
    <td>
        
        <select id = 'target' name="etarget" onchange = 'ajaxTarget()'> 
<option value = ""></option>

<?php 
$TargeResult = getTargetMenu();
$etfound=0;
while ($row = fetch_array($TargeResult)){?>
            <option value = "<?php echo validate($row['Rtarget'],'hd') ?>"
                    <?php if (validate($_REQUEST['etarget'],'hd') == validate($row['Rtarget'],'hd')){
                        echo "selected";
                        $etfound++;
                    } ?>
                    ><?php echo validate($row['DispName'],'hd') ?></option>
<?php } 

if ($etfound == 0) { ?>
    <option value = "<?php echo validate($_REQUEST['etarget'],'hd') ?>" selected ><?php echo validate($_REQUEST['etarget'],'hd') ?></option>
    <?php }
?>

         </select>
 <?php //       <input name="etarget" value="<?php echo validate($_REQUEST['etarget'],'hd') ?><?php //" /> ?>
    </td>
    <th>Security</th>

    <td>

        <select name="security">
  <option value=""></option>
        <?php

        // get security parameters
	$Security = nl2br(parameters('Security'));
        $SecurityArray = explode('<br />', trim($Security));
        $num = count($SecurityArray);
        $i = 0;
while ($num > $i) {
    echo "<option value=\"" . trim($SecurityArray[$i]) . "\"";
 if (isset($row['security'])){
    if(preg_match("/".$row['security']."/i", trim($SecurityArray[$i])))

    {
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
    <tr>
    <th>Section </th>
    
    <td>
    <div id = 'SectionDiv'>
    
<!--Section:-->
<select id = 'esection' name="esection" onchange = 'SectionFunction()'>
<option value = ""></option>

<?php 
$etarget = validate($_REQUEST['etarget'],'hd');
    $secresult = getSectionMenu($etarget);
$esfound=0;
while ($row = fetch_array($secresult)){?>
            <option value = "<?php echo validate($row['section'],'hd') ?>"
            <?php 
                if (isset($_REQUEST['esection'])){
                    if (validate($_REQUEST['esection'],'hd') == validate($row['section'],'hd')){
                        echo "selected";
                        $esfound++;
                    }} ?>
                    ><?php echo validate($row['section'],'hd') ?></option>
<?php } 

if ($esfound == 0 && isset($_REQUEST['esection'])) { ?>
    <option value = "<?php echo validate($_REQUEST['esection'],'hd') ?>" selected ><?php echo validate($_REQUEST['esection'],'hd') ?></option>
    <?php }
?>
</select>
    </div>
<?php //        <input name="esection" value="<?php if (isset($_REQUEST['esection'])){echo validate($_REQUEST['esection'],'hd');} ?><?php //" /></td>?>
        <th>Format </th>
    <td>
        <select name="format">
  <option value=""> </option>
  <option value="Text">Text</option>
  <option value="HTML" selected>HTML</option>
  </select>
         </td>
    </tr>
        <tr>
    <th>Sub-Section </th>
    <td>
    
    <div id = 'SubSectionDiv'> 
    <select id = 'esubsection' name="esubsection">
    <option value = ""></option>
    <?php 
    $esection = validate($_REQUEST['esection'],'hd');
    $subsecresult = getSubsectionMenu($etarget, $esection);
    if (isset($subsecresult)){
$essfound=0;
while ($row = fetch_array($subsecresult)){?>
            <option value = "<?php echo validate($row['subsection'],'hd') ?>"
            <?php 
                if (isset($_REQUEST['esubsection'])){
                    if (validate($_REQUEST['esubsection'],'hd') == validate($row['subsection'],'hd')){
                        echo "selected";
                        $essfound++;
                    }} ?>
                    ><?php echo validate($row['subsection'],'hd') ?></option>
<?php } 

if ($essfound == 0) { ?>
    <option value = "<?php  if (isset($_REQUEST['esubsection'])){ echo validate($_REQUEST['esubsection'],'hd');} ?>" selected ><?php if (isset($_REQUEST['esubsection'])){ echo validate($_REQUEST['esubsection'],'hd');} ?></option>
    <?php }
    }
?>

</select>
</div>
<?php //        <input name="esubsection" value="<?php if (isset($_REQUEST['esubsection'])){echo validate($_REQUEST['esubsection'],'hd');} ?><?php //" /></td>?>
    <th>Sort Order</th>
    <td>
    <input type="hidden" name="sortorder" value="<?php if (isset($_REQUEST['sortorder'])){echo validate($_REQUEST['sortorder'],'hd');} ?>" size="3" />
    </td>
        
    </tr>
    <tr>
    <th>Visible between</th>

    <td>
        <input type="date" name="sdate" value="<?php if (isset($row['sdate'])){echo validate($row['sdate'],'hd');} ?>" size="10" />
-
<input type="date" name="fdate" value="<?php if (isset($row['sdate'])){echo validate($row['fdate'],'hd');} ?>" size="10" />
    </td>
    <th>System Page</th>

    <td>

        <select name="System">
  <option value=""></option>
        <?php

        // get security parameters
	$SystemPages = nl2br(parameters('SystemPages'));
        $SystemArray = explode('<br />', trim($SystemPages));
        $Systemnum = count($SystemArray);
        $Systemi = 0;
while ($Systemnum > $Systemi) {
    echo "<option value=\"" . trim($SystemArray[$Systemi]) . "\"";
    if (isset($row['System'])){
        if(validate($row['System'],'hd') == trim($SystemArray[$Systemi])){
            echo "selected";
    }}
echo ">" . trim($SystemArray[$Systemi]) . "</option>\r\n";
    $Systemi++;
}
        ?>
</select>
    </td>

</tr>

<?php 
//display article header based on parameter
if (parameters('ArticleHeader') == '1'){ ?>
        <tr>
    <th>Header </th>
    <td  colspan="3">
        <textarea rows="5" cols="100" name="header"><?php if (isset($row['header'])){echo validate($row['header'],'hd');} ?></textarea>
         </td>
         </tr>
<?php }else {
?>
<input type="hidden" name="header" value="" />
<?php }?>
        <tr>
    <th>Article </th>
    <td  colspan="3">
        <textarea rows="30" cols="100" name="page"><?php if (isset($row['page'])){echo validate($row['page'],'hd');} ?></textarea>
         </td>
    </tr>

<?php
    }
?>

    
  <tr>
<td><input type="hidden" name="number" value="" /></td>
<td align="righ"><input type="submit" name="Save" value=" Save " /></td>
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
