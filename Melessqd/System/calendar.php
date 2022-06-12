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
<center>
<?php
        // get security parameters
	$PublicCalendarViews = nl2br(parameters('PublicCalendarViews'));
        $PublicCalendarViewsArray = explode('<br />', trim($PublicCalendarViews));
        $num = count($PublicCalendarViewsArray);
        $i = 0;
while ($num > $i) {
    echo "<a href=\"?target=$target";
    if (isset($section)){
    echo "&amp;section=$section";
    }
    if (isset($subsection)){
    echo "&amp;subsection=$subsection";
    }
    echo "&amp;CalendarStyle=" . str_replace(" ","",trim($PublicCalendarViewsArray[$i])) . "\">" . trim($PublicCalendarViewsArray[$i]) . "</a> \r\n";
    $i++;
}
        ?>
        </center>

<!--
<center> List">List View</a> <a href="?target=<?php echo $target ?>&amp;CalendarStyle=CompactList">Compact List View</a> <a href="?target=calendar&amp;CalendarStyle=Calendar">Calendar View</a> <a href="?target=<?php echo $target ?>&amp;CalendarStyle=Week">Week View</a></center>?>
-->
</div>

