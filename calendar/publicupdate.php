<?php
$system = true;
if (parameters('CalendarPublicPost')){
?>

<center> <H1><?php echo parameters('CalendarEditPageTitle');?></H1> </center>
<div id="editbox">
<form name="updateform" method="post">
<input type="hidden" name="target" value="calendar" />
<input type="hidden" name="section" value="updateSave" />
<input type="hidden" value="1" name="restrict" readonly />

<table>
    <?php
    if (isset($_POST['Date'])){
        $date = new DateTime(validate($_POST['Date'], 'd'));
        $date = $date->format('d-m-Y');
        echo '<input type="hidden" name="Date" value="' . $date . '" readonly />';
        echo "<tr>
<td>Date:</td>";
echo '<td><strong> '. $date . '</strong>';
echo "</td>
</tr>";
    }else{
    
echo "<tr>
<td>Date:</td>";
echo '<td><input type="date" name="Date" value="" />';
echo "</td>
</tr>";
    }
?>
    
     <?php
     if (isset($_POST['Time'])){
        $time = new DateTime(validate($_POST['Time'], 'hd'));
        $time = $time->format('H:i:s');
        echo '<input type="hidden" name="Time" value="' . $time . '" readonly />';
        echo "<tr>
<td>Time:</td>
<td><strong>";
        $time = new DateTime(validate($_POST['Time'], 'hd'));
        echo $time->format('H:i') . "</strong></td>
 </tr>";
    }else{
echo "<tr>
<td>Time:</td>
<td>
    
<select id=\"Time\">";

    $starttime = strtotime(parameters('StartTime'));
    $endtime = strtotime(parameters('EndTime'));
    //echo date('H:i', $starttime);
    //echo '<br />';
    //echo date('H:i', $endtime);
    while ($starttime < $endtime){
        echo '<option value="' . date('H:i:s', $starttime) . '">' . date('H:i', $starttime) . '</option>';
        $starttime = strtotime('+' . parameters('CalendarTimeSlots') . 'minutes', $starttime);
    }
echo "
</select>
</td>
</tr>";
    }
?>

<tr>
<td>Name:</td>
<td colspan="2"><input type="text" name='Event' value="" />
</tr>
<tr>
<td></td>
<td><input type="submit" name="Save" value=" Book " /></td>
</tr>
</table>
</form>
<?php
}
?>
</div>