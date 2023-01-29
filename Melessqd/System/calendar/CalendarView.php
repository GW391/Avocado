
<?php
$system = true;
/*
	if (isset($_SESSION['security']) || parameters('CalendarPublicPost')) {
                    //if(stripos($_SESSION['security'], 'editor') || stripos($_SESSION['security'], 'Calendar')){
if(stripos($_SESSION['security'], parameters('CalendarEditor')) || parameters('CalendarPublicPost')){
    echo "<div id='editbox'>";
                if (stripos($_SESSION['security'], parameters('CalendarEditor'))){
                    echo "<form method=\"post\" name=\"Add\" action=\"?target=System&amp;section=calendar&amp;subsection=update\">";
                }else{
			echo "<form method=\"post\" name=\"Add\" action=\"?target=System&amp;section=calendar&amp;subsection=publicupdate\">";
                }
			echo "<input type=\"submit\" value=\" Add Event \" />";
			echo "</form>";
                        echo "</div>";
		}
	}
*/
$date = date('Ymd');

$Where = "Date>=$date AND Deleted!=1";

if (isset($_SESSION['security'])){
        if(stripos($_SESSION['security'], 'Member')){

    }else{
        $Where .= " AND Restricted!=1";
    }
}else{
    $Where .= " AND Restricted!=1";
}

$Select = " UID, Date, Event, venue, Time, ETime, target, section, Restricted, flyers";
        $From = "Pcalder";
        $Limit = null;
        $die = "Sorry no events found ";
        $sort = "Date, Time";
        $GROUP = null;
        
$result = SQL($Select, $From, $die, $Where, $Limit, $GROUP, $sort);

?>

<?php
$tmpdate = new DateTime(date('Y-m-d'));
if (isset($_GET['Month'])){
  $tmpdate->modify('+ ' . validate($_GET['Month'], 'n') . ' month');
  $nextMonth = validate($_GET['Month'], 'n');
}
else{
    $nextMonth = 0;
}
$Month = $tmpdate->format("m");

$num = cal_days_in_month(CAL_GREGORIAN, $Month, $tmpdate->format('Y')); // 30

$Month = $tmpdate->format("M");

// call functionm to draw calendar.
drawCalendar("large", $tmpdate, $num, $nextMonth);


?>

<?php
	if (isset($_SESSION['security']) || parameters('CalendarPublicPost')) {
                    //if(stripos($_SESSION['security'], 'editor') || stripos($_SESSION['security'], 'Calendar')){
if(stripos($_SESSION['security'], parameters('CalendarEditor')) || parameters('CalendarPublicPost')){
    echo "<div id='editbox'>";
                if (stripos($_SESSION['security'], parameters('CalendarEditor'))){
                    echo "<form method=\"post\" name=\"Add\" action=\"?target=System&amp;section=calendar&amp;subsection=update\">";
                }else{
			echo "<form method=\"post\" name=\"Add\" action=\"?target=System&amp;section=calendar&amp;subsection=publicupdate\">";
                }
			echo "<input type=\"submit\" value=\" Add Event \" />";
			echo "</form>";
                        echo "</div>";
		}
	}
?>

<?php
function drawCalendar($size, $Month, $num, $nextMonth){

    $dom=0;
	$dow=0;
	$month = $Month->format("m");
        
	echo "<table border=\"1\" width=\"100%\" height=\"75%\">";
	echo "<tr>";
	echo "<td colspan=\"7\">";
	echo "<div class=\"alerts\">";
	echo "<div class=\"top\">";
        // create links to previous and next month
        global $CalendarStyle;
        global $target;
        global $section;
        global $subsection;
        if ($nextMonth > 0){
            $PrevMonth = $nextMonth-1;
        echo '<a style="float:left" href="?target='.$target.'&amp;';
                if (isset($section)){
                    echo 'section='.$section.'&amp;';
                }
                if (isset($subsection)){
                    echo 'subsection='.$subsection.'&amp;';
                }
        echo 'CalendarStyle='.$CalendarStyle.'&amp;Month=' . $PrevMonth . '">Previous</a>';}
	echo "<strong>" . $Month->format('F') . "</strong>";
        $nextMonth = $nextMonth+1;
        echo '<a style="float:right" href="?target='.$target.'&amp;';
                if (isset($section)){
                    echo 'section='.$section.'&amp;';
                }
                if (isset($subsection)){
                    echo 'subsection='.$subsection.'&amp;';
                }
        echo 'CalendarStyle='.$CalendarStyle.'&amp;Month=' . $nextMonth . '">Next';
	echo "</div>";
	echo "</div>";
	echo "</td>";
	echo "</tr>";
        //build the calander
	echo "<tr>";
	echo "<td>";
	echo "<strong>Sun</strong>";
	echo "</td>";
	echo "<td>";
	echo "<strong>Mon</strong>";
	echo "</td>";
	echo "<td>";
	echo "<strong>Tus</strong>";
	echo "</td>";
	echo "<td>";
	echo "<strong>Wed</strong>";
	echo "</td>";
	echo "<td>";
	echo "<strong>Thu</strong>";
	echo "</td>";
	echo "<td>";
	echo "<strong>Fri</strong>";
	echo "</td>";
	echo "<td>";
	echo "<strong>Sat</strong>";
	echo "</td>";
	echo "</tr>";
	echo "<tr>";

	$dom=$Month->format('01' . '-m-Y');
	//echo $dom;
	$dow = DATE_FORMAT(date_create($dom), 'w');
	//echo $dow;
	//$dow=date('w',$dom);
	//echo $dow;
	$i=0;
	while ($i<$dow){
		echo "<td HEIGHT=\"22\" WIDTH=\"79\" valign=\"top\" style=\"height: 100px;\">";
		echo "</td>";
		$i++;
	}
	$d=1;
	while ($d<=$num){
		if ($i==7){
			echo "</tr>\n";
			echo "<tr HEIGHT=\"22\">";
			$i=0;
		}

		echo "<td HEIGHT=\"22\" WIDTH=\"79\" valign=\"top\" style=\"height: 100px;\">";

		$filename = $Month->format('Ym') . str_pad($d, 2, "0", STR_PAD_LEFT); 
		$daydate = date($filename);
$date = date('Ymd');

$Where = "Date = $daydate && Date>=$date AND Deleted!=1";

if (isset($_SESSION['security'])){
        if(stripos($_SESSION['security'], 'Attendee') !== false){
    }else{
        $Where .= " AND Restricted!=1";
    }
}else{
    $Where .= " AND Restricted!=1";
}
    $select = "Date, Event, Time";
    $From = "Pcalder";
    $die = "Sorry Login Failed";
    $sort = "Date, Time";

    $result = SQL($select, $From, $die, $Where, null, null, $sort);
    $count=num_rows($result);
		if ($count >= 1) {
			echo "<b>". str_pad($d, 2, "0", STR_PAD_LEFT) . "</b>";
			//echo $Month->format("m");
			//echo $d . "</b><br /> ";
			$r = 1;
			//while ($row = $count){
                        while ($row = fetch_array($result)){
				if (isset($row['Event'])){
					echo  "<br />" . validate($row['Event'],'hd');
                                        if (($row['Time']) <> "00:00:00"){
                                            echo ": " . (substr($row['Time'],0,5));
                                        }
					if ($r < $count){
					echo "<br />";
					//echo "<br />";
					}
				}else {
					echo "No event details";
                                    echo $count;
                                    echo $r;
				}
				$r++;
			}
			//echo "</b>";

		}else{
			if ($d < date('d') && ($Month->format('Ym') == date('Ym'))){
				echo '<font color="#999999">' . str_pad($d, 2, "0", STR_PAD_LEFT) . "</font>";
			}else{
				echo str_pad($d, 2, "0", STR_PAD_LEFT);
			}
		}
		echo "</td>";
		$d++;
		$i++;
	}
echo "</tr>";
	echo "</table>";

}

?>
