<center><h1>
Calendar
</h1></center>

<?php
$system = true;

	if (isset($_SESSION['security']) || parameters('CalendarPublicPost')) {
                    //if(stripos($_SESSION['security'], 'editor') || stripos($_SESSION['security'], 'Calendar')){
if(stripos($_SESSION['security'], parameters('CalendarEditor')) || parameters('CalendarPublicPost')){
    echo "<div id='edit'>";
                if (parameters('CalendarPublicPost')){
                    echo "<a href = \"?target=calendar&amp;section=publicupdate\"> Add Event </a>";
                }else{
			echo "<a href = \"?target=calendar&amp;section=update\"> Add Event </a>";
            echo "<a href = \"?target=Settings&amp;limit=calendar\"> Calendar Settings </a>";
                }
echo '</div>';
		}
	}
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
if (isset($target)){
    echo "<a href=\"?target=$target";
    }
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
<center> List">List View</a> <a href="?target=<?php //echo $target ?>&amp;CalendarStyle=CompactList">Compact List View</a> <a href="?target=calendar&amp;CalendarStyle=Calendar">Calendar View</a> <a href="?target=<?php //echo $target ?>&amp;CalendarStyle=Week">Week View</a></center>?>
-->
</div>

