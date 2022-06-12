<?php
$system = true;
if(security_check(parameters('CalendarEditor'))){
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


<div id="editbox">
<form name="updateform" method="post" action="">
<input type="hidden" name="target" value="System">
<input type="hidden" name="section" value="calendar">
<input type="hidden" name="subsection" value="updateSave">
<?php

// check if we have a calendar ID, if so we are needing to get the data from the database to update the record.
if (isset($_POST['CALID'])){

$UUID = validate($_POST['CALID'], "hd");

$select = "UID, Date, Event, venue, Time, ETime, datecreted, whocreated, target, section, Restricted";
$from = "Pcalder";
$where = "UID = $UUID";
$die = "Sorry there has been a problem please try again";
$Limit = 1;

$result = SQL($select, $from, $die, $where, $Limit, null, null);

$row = fetch_array($result);

?>
<?php 

if (isset($_POST['DUP'])){
    // if duplicating do not copy ID
}else{
    // we are updating so we need ID
    ?>
    <input type="hidden" name="UUID" value="<?php echo $UUID; ?>" >
    <?php
}
}
?>

<table>
<tr>
<td>Date:</td>
<td><input type="date" name="Date" value="<?php if (isset($row['Date'])) {echo validate($row['Date'],"hd");} ?>" />
<br />
Enter date in format dd/mm/yyyy
</td>
</tr>

<tr>
<td>Start Time:</td>
<td><input type="time" name="Time" value="<?php if (isset($row['Time'])) {echo validate($row['Time'],"hd");} ?>" />
<br />
Enter time in 24hr
</td>

<td>End Time:</td>
<td><input type="time" name="ETime" value="<?php if (isset($row['ETime'])) {echo validate($row['ETime'],"hd");} ?>" />
<br />
Enter time in 24hr
</td>
</tr>
<tr>
<td>Event:</td>
<td colspan="3"><textarea name='Event' rows='15' cols='50'><?php if (isset($row['Event'])) {echo validate($row['Event'],"hd");} ?></textarea></td>
</tr>

<tr>
<td>Venue:</td>
<td><input type="text" name="venue" value="<?php if (isset($row['venue'])) {echo validate($row['venue'],"hd"); }?>" /></td>
</tr>

<tr>
<td>Target:</td>
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

<?php //    <input type="text" name="ltarget" value="<?php if (isset($row['target'])) {echo validate($row['target'],'hd');} ?><?php //" /></td>?>
</tr>

<tr>
<td>section:</td>
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

<?php //<input type="text" name="lsection" value="<?php if (isset($row['section'])) {echo validate($row['section'],'hd');} ?><?php //" /></td> ?>
</tr>
<tr>
<td>subsection:</td>
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

<?php //<input type="text" name="lsubsection" value="<?php if (isset($row['subsection'])) {echo validate($row['subsection'],'hd');} ?><?php //" />?>
</td>
</tr>
<tr>
    <td>Flyer</td>
    <td><select name="lflyer">
            <option value="" selected> none </option>

        <?php
        if (isset($row['flyer'])){
            echo "<option value=\"\"> none </option>\n\r";
            echo "<option value=\"" . validate($row['flyer'],'hd') . "\" selected>".  validate($row['flyer'],'hd') . "</option>\n\r";
        }

        foreach (glob("flyers/*.pdf") as $filename) {
    echo "<option value=\"" . basename($filename) . "\">" . basename($filename) ."</option>\n\r";
}
          ?>
        </select>
    </td>
</tr>
<tr>
    <td>Restrict</td>
    <td><input type="checkbox" value="1" <?php if (isset($row['Restricted']) && strlen($row['Restricted'] !=0) ) {echo 'checked';} ?> name="restrict" ></td>
</tr>

<tr>
<th>Recurrence:</th>
<td>No: <input type="number" name="rectimes" value="" size="4" /><br />
    Enter total number of events required.<br />
Frequency: <input type="text" name="frequency" value="" size="4"/> 
<select name="frequencytype">
    <option value="Days">Days</option>
    <option value="Weeks">Weeks</option>
    <option value="Sunday">Sunday</option>
    <option value="Monday">Monday</option>
    <option value="Tuesday">Tuesday</option>
    <option value="Wednesday">Wednesday</option>
    <option value="Thursday">Thursday</option>
    <option value="Friday">Friday</option>
    <option value="Saturday">Saturday</option>
    
</select> <br />

Enter the frequency of the event, e.g. 7 days, 4 weeks. <br />
1 Sunday will produce an event on the first Sunday of every month. <br />
Last Sunday will produce an event on the Last Sunday of every month.
</td>
</tr>

<tr>
<td></td>
<td><input type="submit" name="Save" value=" Save " /></td>
</tr>
</table>
</form>
</div>
<?php
}else{
    echo "soory you do not have the permission to add calendar entries";
}
?>
