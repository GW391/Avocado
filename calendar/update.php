<?php
$system = true;
if (isset($_SESSION['security'])){
if(stripos($_SESSION['security'], 'editor') !== false || stripos($_SESSION['security'], 'Calendar') !== false){
if (isset($_POST['CALID'])){

$UUID = validate($_POST['CALID'], "hd");

$select = "UID, Date, Event, venue, Time, ETime, datecreted, whocreated, target, section, Restricted";
$from = "Pcalder";
$where = "UID = $UUID";
$die = "Sorry there has been a problem please try again";
$Limit = null;

$result = SQL($select, $from, $die, $where, $Limit, null, null);

while ($row = fetch_array($result)){

?>
<div id="editbox">
<form name="updateform" method="post">
<input type="hidden" name="target" value="calendar">
<input type="hidden" name="section" value="updateSave">

<?php 

if (isset($_POST['DUP'])){

}else{

?>

<input type="hidden" name="UUID" value="<?php echo $UUID ?>" >
<?php
}
?>

<table>
<tr>
<td>Date:</td>
<td><input type="date" name="Date" value="<?php echo Date('d/m/Y', strtotime(validate($row['Date'],"hd"))); ?>" />
<input type="date" />
<br />
Enter date in format dd/mm/yyyy
</td>
</tr>

<tr>
<td>Start Time:</td>
<td><input type="text" name="Time" value="<?php echo validate($row['Time'],"hd"); ?>" />
<br />
Enter time in 24hr
</td>

<td>End Time:</td>
<td><input type="text" name="ETime" value="<?php echo validate($row['ETime'],"hd"); ?>" />
<br />
Enter time in 24hr
</td>
</tr>
<tr>
<td>Event:</td>
<td colspan="3"><textarea name='Event' rows='15' cols='50'><?php echo validate($row['Event'],"hd"); ?></textarea></td>
</tr>

<tr>
<td>Venue:</td>
<td><input type="text" name="venue" value="<?php echo validate($row['venue'],"hd"); ?>" /></td>
</tr>

<tr>
<td>Target:</td>
<td><input type="text" name="ltarget" value="<?php echo validate($row['target'],"hd"); ?>" /></td>
</tr>

<tr>
<td>section:</td>
<td><input type="text" name="lsection" value="<?php echo validate($row['section'],"hd"); ?>" /></td>
</tr>
<tr>
    <td>Flyer</td>
    <td><select name="lflyer">
            <option value="" selected> none </option>

        <?php
        if ($row['flyer']){
            echo "<option value=\"\"> none </option>\n\r";
            echo "<option value=\"" . validate($row['flyer'],hd) . "\" selected>".  validate($row['flyer'],"hd") . "</option>\n\r";
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
    <td><input type="checkbox" value="1" <?php if ($row['Restricted']) {echo 'checked';} ?> name="restrict" ></td>
</tr>


<tr>
<td></td>
<td><input type="submit" name="Save" value=" Save " /></td>
</tr>
</table>
</form>
</div>
<?php
}
}else{

?>
<div id="editbox">
<form name="updateform" method="post">
<input type="hidden" name="target" value="calendar">
<input type="hidden" name="section" value="updateSave">

<table>
<tr>
<td>Date:</td>
<td><input type="date" name="Date" value="" />
<br />
Enter date in format dd/mm/yyyy
</td>
</tr>

<tr>
<td>Time:</td>
<td><input type="text" name="Time" value="" />
<br />
Enter time in 24hr
</td>
<td>End Time:</td>
<td><input type="text" name="ETime" value="" />
<br />
Enter time in 24hr
</td>
</tr>

<tr>
<td>Event:</td>
<td colspan="2"><input type="text" name='Event' value="" />
<br />
Enter event summery</td>
</tr>

<tr>
<td>Event detail:</td>
<td colspan="3"><textarea name='EventDetail' rows='5' cols='45'></textarea>
<br />
Enter event details</td>
</td>
</tr>

<tr>
<td>Venue:</td>
<td><input type="text" name="venue" value="" /></td>
</tr>
<tr>
<td>Target:</td>
<td><input type="text" name="ltarget" value="" /></td>
</tr>
<tr>
<td>section:</td>
<td><input type="text" name="lsection" value="" /></td>
</tr>
<tr>
    <td>Flyer</td>
    <td><select name="lflyer">
            <option value="" selected> none </option>
        <?php
        foreach (glob("flyers/*.pdf") as $filename) {
    echo "<option value=\"" . basename($filename) . "\">" . basename($filename) ."</option>\n\r";
}
          ?>
        </select>
    </td>
</tr>
<tr>
    <td>Restrict</td>
    <td><input type="checkbox" value="1" name="restrict"></td>
</tr>


<tr>
<th>Recurrence:</th>
<td>No: <input type="text" name="rectimes" value="" size="4" /><br />
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
<td><input type="submit" name="Save" value=" Add " /></td>
</tr>
</table>
</form>
</div>
<?php
}

}
}

?>
