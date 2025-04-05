<center><h1>
Calendar
</h1></center>

<?php
$system = true;

/*
	if (isset($_SESSION['security']) || parameters('CalendarPublicPost')) {
                    //if(stripos($_SESSION['security'], 'editor') || stripos($_SESSION['security'], 'Calendar')){
if(stripos($_SESSION['security'], parameters('CalendarEditor')) || parameters('CalendarPublicPost')){
                if (parameters('CalendarPublicPost')){
                    echo "<form method=\"post\" name=\"Add\" action=\"?target=calendar&amp;section=publicupdate\">";
                }else{
			echo "<form method=\"post\" name=\"Add\" action=\"?target=calendar&amp;section=update\">";
                }
			echo "<input type=\"submit\" value=\" Add Event \" />";
			echo "</form>";
		}
	}

*/

$date = date('Ymd');
//if (isset($_GET['Month'])){
//  $date->modify('+ ' . validate($_GET['Month'], 'n') . ' month');
//}

$Where = "Date>=$date AND Deleted!=1";

if (isset($_SESSION['security'])){
        if(stripos($_SESSION['security'], 'Member')){

    }else{
        //$Where .= " AND Restricted!=1";
    }
}else{
    //$Where .= " AND Restricted!=1";
}

$Select = " UID, Date, Event, venue, Time, ETime, target, section, Restricted, flyers";
        $From = "Pcalder";
        $Limit = null;
        $die = "Sorry no events found ";
        $sort = "Date, Time";
        $GROUP = null;
        
$result = SQL($Select, $From, $die, $Where, $Limit, $GROUP, $sort);
//echo num_rows($result);

$tmpdate = new DateTime(date('Y-m-d'));
if (isset($_GET['Month'])){
  $tmpdate->modify('+ ' . validate($_GET['Month'], 'n') . ' month');
  $nextMonth = validate($_GET['Month'], 'n');
}
else{
    $nextMonth = 0;
}
$Month = $tmpdate->format("m");

$num1 = new DateTime(date('Y-m-d'));
//echo $num1->format('d') . "\n";

/*
$num2 = new DateTime(date('Y-m-d'));
$interval = new DateInterval('P6D');

$num2->add($interval);
echo $num2->format('d') . "\n";
*/
//echo 'start ' . parameters('StartTime');
//echo 'stop ' . parameters('EndTime');
 //   $starttime = strtotime(parameters('StartTime'));
  //  $endtime = strtotime(parameters('EndTime'));
    //echo date('H:i', $starttime);
    //echo '<br />';
    //echo date('H:i', $endtime);
   /* $slotcount=1;
    while (date('H:i', $starttime) <= date('H:i', $endtime)){
        echo 'slots ' . $slotcount . ' ST: ' . date('H:i', $starttime) . ' <br />';
        $starttime = strtotime('+' . parameters('CalendarTimeSlots') . 'minutes', $starttime);
        $slotcount++;
    }*/
//    $starttime = strtotime(parameters('StartTime'));
//    $endtime = strtotime(parameters('EndTime'));
//$interval = new DateTime(date('H:i:s'));
//$interval = $starttime->dif($endtime);

//echo $interval->format('%s second(s)');
//echo $interval->format('%i mins');
//echo $slotcount;
//$num = (intval($num1->format('d')) + 6)*$slotcount;
$num=7;
$Month = $tmpdate->format("M");

//echo 'NUM ' . $num . ' ';
// call functionm to draw calendar.

drawCalendar("large", $tmpdate, $num, $nextMonth);

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
        global $CalendarStyle;
        global $target;
  //      if ($nextMonth > 0){
 //           $PrevMonth = $nextMonth-1;
    
//        echo '<a style="float:left" href="?target='.$target.'&amp;CalendarStyle='.$CalendarStyle.'&amp;Month=' . $PrevMonth . '">Previous</a>';
//        }
	echo "<strong>" . $Month->format('F') . "</strong>";
   //     $nextMonth = $nextMonth+1;
   //     echo '<a style="float:right" href="?target='.$target.'&amp;CalendarStyle='.$CalendarStyle.'&amp;Month=' . $nextMonth . '">Next';
	echo "</div>";
	echo "</div>";
	echo "</td>";
	echo "</tr>";
	echo "<tr>";
        
        $day = $tmpdate = new DateTime(date('Y-m-d'));
        $loop=0;
        while ($loop < 7){
            if (parameters('ShowNonBookableDays') || (stripos(parameters('CalendarBookableDays'), $day->format('D')) !== false)){
	echo "<td>";
        echo "<strong>" .  $day->format('D - d') . "</strong>";
	//echo "<strong>" .  date('D - d') . "</strong>";
	echo "</td>";
            }
        $day->modify('+1 day');
        $loop++;
        }
        
        
	echo "<tr>";

	$dom=$Month->format('d-m-Y');
	//echo $dom;
	$dow = DATE_FORMAT(date_create($dom), 'w');
	//echo $dow;
	//$dow=date('w',$dom);
	//echo $dow;
	$i=0;
/*	while ($i<$dow){
		echo "<td HEIGHT=\"22\" WIDTH=\"79\" valign=\"top\" style=\"height: 100px;\">";
		echo "</td>";

		$i++;
	}*/
	$d=date('d');
        $slotstarttime = new DateTime(parameters('StartTime'));
        $day = $tmpdate = new DateTime(date('Y-m-d'));

    $starttime = strtotime(parameters('StartTime'));
    $endtime = strtotime(parameters('EndTime'));
    
    //echo date('H:i', $starttime);
    //echo '<br />';
    //echo date('H:i', $endtime);
  //  $slotcount=0;
 //   while ($starttime != $endtime){
        
	//while ($d<=$num){
while(date('H:i', $starttime) <= date('H:i', $endtime)){
  //  echo $slotstarttime->format('H:i:s');
    $queryTime = $slotstarttime->format('H:i:s');
    //$slotendtime = strtotime(parameters('EndTime'));
    //$slotsize = parameters('CalendarTimeSlots');
            //check if end of colum display
                if ($i==7){
                        // print end of colum
			echo "</tr>\n";
			echo "<tr>";
                        //Incramet timeslot to next colum
                        $interval = date_interval_create_from_date_string(parameters('CalendarTimeSlots') . 'minutes');
                        $slotstarttime->add($interval);
                        $day->modify('-7 day');
			$i=0;
                        $starttime = strtotime('+' . parameters('CalendarTimeSlots') . 'minutes', $starttime);
		}else{
                       // $filename = $Month->format('Ym') . str_pad($d, 2, "0", STR_PAD_LEFT); 
                        $daydate = $day->format('Ymd');
                        $date = date('Ymd');
                }
if (parameters('ShowNonBookableDays') || (stripos(parameters('CalendarBookableDays'), $day->format('D'))!== false)){
		echo "<td WIDTH=\"79\" valign=\"top\" >"; // HEIGHT=\"22\" style=\"height: 100px;\"

		
    //$slotstarttime = strtotime(parameters('StartTime'));
    //$interval = new DateInterval('P6D');
    //$num2->add($interval);
    //echo $num2->format('d') . "\n";

$Where = "Date = $daydate AND Date>=$date AND Deleted!=1 AND Time = '$queryTime'";

if (isset($_SESSION['security'])){
        if(stripos($_SESSION['security'], 'Attendee') != false){
    }else{
       // $Where .= " AND Restricted!=1";
    }
}else{
  //  $Where .= " AND Restricted!=1";
}
    $select = "Date, Event, Time, Restricted";
    $From = "Pcalder";
    $die = "Sorry Login Failed";
    $sort = "Date, Time";

    $result = SQL($select, $From, $die, $Where, null, null, $sort);
    $count=num_rows($result);

		if ($count >= 1) {
			//echo "<b>". $day->format('d') . "</b>";
			//echo $Month->format("m");
			//echo $d . "</b><br /> ";
                   // date('H:i', $starttime) 
                    echo substr($queryTime,0,5);
			$r = 1;
			//while ($row = $count){
                        
                        while ($row = fetch_array($result)){
                            
                            // echo $row['Restricted'];
                        if (isset($row['Restricted']) && stripos($_SESSION['security'], 'Attendee') === false) {
                            if ($r >= parameters('CalendarSlotMaxBookings')){
                                echo ' ' . parameters('CalendarRestrictedText');
                            }
                        }else{
				if (isset($row['Event'])){
					echo  "<br />" . validate($row['Event'],'hd');
                                        if (($row['Time']) <> "00:00:00"){
                                            echo ": " . (substr($row['Time'],0,5));
                                        }
					if ($r < $count){
					//echo "<br />";
					}
				}else {
					echo "No event details";
                                    echo $count;
                                    echo $r;
                        }}
				$r++;
                        }
			echo "</b>";

		}else{
/*			if ($d < date('d') ){
				echo '<font color="#999999">' . $d . "</font>";
			}else{*/
                   // echo $day->format('d');
		    echo substr($queryTime,0,5);
			//}
		}
                //echo $day->format('D');
                if ($count < parameters('CalendarSlotMaxBookings') && (stripos(parameters('CalendarBookableDays'), $day->format('D'))!== false)){
                	if (isset($_SESSION['security']) || parameters('CalendarPublicPost')) {
                    //if(stripos($_SESSION['security'], 'editor') || stripos($_SESSION['security'], 'Calendar')){
if(stripos($_SESSION['security'], parameters('CalendarEditor')) || parameters('CalendarPublicPost')){
    echo "<div id=\"editbox\">";
                if (parameters('CalendarPublicPost') && !stripos($_SESSION['security'], parameters('CalendarEditor'))){
                    echo "<form method=\"post\" name=\"Add\" action=\"?target=calendar&amp;section=publicupdate\">";
                }else{
			echo "<form method=\"post\" name=\"Add\" action=\"?target=calendar&amp;section=update\">";
                }
                        echo "<input type=\"hidden\" name=\"Date\" value=\"". $day->format('d-m-Y') . "\">";
                        echo "<input type=\"hidden\" name=\"Time\" value=\"$queryTime\">";
			echo "<input type=\"submit\" value=\" Book onto Slot \" />";
			echo "</form>";
                        echo "</div>";
		}
        }}
		echo "</td>";
}
		$d++;
		$i++;
                $day=$day->modify('+1 day');
                
               // $slotstarttime = new DateTime('h:m:s', ($queryTime));
                
                //$slotstarttime = new DateTime(strtotime('+' . parameters('CalendarTimeSlots') . 'minutes', strval($queryTime)));
                //$slotstarttime = strtotime('+' . parameters('CalendarTimeSlots') . 'minutes', intval($queryTime));
                //echo '(' . $slotstarttime . ')';
                //$starttime = strtotime('+' . parameters('CalendarTimeSlots') . 'minutes', $starttime);
	}

echo "</tr>";
echo "</table>";
}

?>
