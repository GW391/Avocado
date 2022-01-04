<?php
$system = true;
// get the calendar Style.

if (!isset($CalendarStyle)){
if (isset($_GET['CalendarStyle'])){
    $CalendarStyle = validate($_REQUEST['CalendarStyle'], 'h');
}else{
    $CalendarStyle = parameters('CalendarStyle');
}
}

require 'System/calendar/' . $CalendarStyle . 'View.php';
?>

<?php //todo: read this from parameter list ?>
<div id="edit">
<center> <a href="?target=<?php echo $target ?>&amp;CalendarStyle=List">List View</a> <a href="?target=<?php echo $target ?>&amp;CalendarStyle=CompactList">Compact List View</a> <a href="?target=calendar&amp;CalendarStyle=Calendar">Calendar View</a> <?php // <a href="?target=calendar&amp;CalendarStyle=Week">Week View</a></center>?>
</div>

