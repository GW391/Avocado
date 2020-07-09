<?php
$system = true;
if(security_check(parameters('CalendarEditor'))){
    ?>
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
<td><input type="text" name="Time" value="<?php if (isset($row['Time'])) {echo validate($row['Time'],"hd");} ?>" />
<br />
Enter time in 24hr
</td>

<td>End Time:</td>
<td><input type="text" name="ETime" value="<?php if (isset($row['ETime'])) {echo validate($row['ETime'],"hd");} ?>" />
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
<td><input type="text" name="ltarget" value="<?php if (isset($row['target'])) {echo validate($row['target'],'hd');} ?>" /></td>
</tr>

<tr>
<td>section:</td>
<td><input type="text" name="lsection" value="<?php if (isset($row['section'])) {echo validate($row['section'],'hd');} ?>" /></td>
</tr>
<tr>
<td>subsection:</td>
<td><input type="text" name="lsubsection" value="<?php if (isset($row['subsection'])) {echo validate($row['subsection'],'hd');} ?>" /></td>
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
