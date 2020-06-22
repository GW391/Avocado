<center><h1>
Calendar
</h1></center>

<?php
$system = true;

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


$date = date('Ymd');
//if (isset($_GET['Month'])){
//  $date->modify('+ ' . validate($_GET['Month'], 'n') . ' month');
//}

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

<table border="1" width="100%">
<tr>
	<td><strong>Date</strong></td>
	<td><strong>Time</strong></td>
	<td><strong>Event</strong></td>
	<td><strong>Venue</strong></td>
</tr>

<?php
while ($row = fetch_array($result)){
echo "<tr>";
echo "<td valign=\"top\">";
echo '<a name="';
echo date('dm', strtotime($row['Date']));
echo '"></a>';

	echo date('l', strtotime($row['Date'])); 
	echo " ";
	echo date('d M', strtotime($row['Date']));
// echo "</a>";
echo "</td>";

echo "<td valign=\"top\">";
if (($row['Time']) <> "00:00:00"){
	echo date('H:i', strtotime($row['Time']));
        if (($row['ETime']) <> "00:00:00" && $row['ETime'] != NULL){
            echo ' - ' . date('H:i', strtotime($row['ETime']));
        }
}else{
	echo '<a href="?target=contact&amp;section=contact">Contact us</a>';
}

echo "</td>";
echo "<td valign=\"top\">";

echo  validate($row['Event'], 'hd');
if (isset($row['target'])){

	if (strlen($row['target'])!=0){
		echo '<div align="right">';
		echo '<a href="?target=' . validate($row['target'], 'hd');
		if (isset($row['section'])){
                    if (strlen(trim($row['section'])) != 0){
			echo '&amp;section=' . validate($row['section'], 'hd');
                    }
		}
	echo '">more...</a>';
	echo '</div>';
	}
}

if (isset($row['flyers'])){

	if (strlen($row['flyers'])!=0){
	echo '<div align="right">';
	echo '<a href="flyers/' . validate($row['flyers'], 'hd');
		
	echo '">' . validate($row['flyers'], 'hd') . '</a>';
	echo '</div>';
        }
}


if (isset($row['Restricted'])){
    if ($row['Restricted']){
    echo '<div align="right">';
    echo parameters('CalendarRestrictedText'); //'church booking, by invite only';
    echo '</div>';
}
}

echo "</td>";
echo "<td valign=\"top\">";
if (isset($_SESSION['security'])){
            if(stripos($_SESSION['security'], 'Attendee')){

           if (strlen($row['venue'])!=0){
		echo validate($row['venue'], 'hd');
            }else{
               echo '<a href="?target=contact&amp;section=contact">Contact us</a>';
            }
	}else{
		//if ($row['venue'] == 'Church' || $row['venue'] == 'church'){
            if(stripos(parameters('PublicVenues'), $row['venue'])){
			echo validate($row['venue'], 'hd');
		}else{
		echo '<a href="?target=contact&amp;section=contact">Contact us</a>';
			if (isset($_SESSION['user'])){
			
			}else{
                            if (parameters('AllowLogins')){
				echo ' or <a href="?target=login">Login</a>';
                            }
			}
		}
	}

}else{
		//if ($row['venue'] == 'Church' || $row['venue'] == 'church'){
                    if(stripos(parameters('PublicVenues'), $row['venue'])){
			echo validate($row['venue'], 'hd');
		}else{
		echo '<a href="?target=contact&amp;section=contact">Contact us</a>';
			if (isset($_SESSION['user'])){
			
			}else{
                            if (parameters('AllowLogins')){
				echo ' or <a href="?target=login">Login</a>';
                            }
			}

		}
}
echo "</td>";

	if (isset($_SESSION['security'])){
                    //if(stripos($_SESSION['security'], parameters('Calendar')) !== false || stripos($_SESSION['security'], 'Calendar') !== false){
if(stripos($_SESSION['security'], parameters('CalendarEditor'))){
			echo "<td>";
			echo "<form method=\"post\" name=\"" . $row['UID'] . "\" action=\"?target=calendar&amp;section=update\">";
			echo "<input type=\"hidden\" name=\"CALID\" value=\"" . $row['UID'] . "\" readonly=\"readonly\" />";
			echo "<input type=\"image\" SRC=\"images/icons/edit.png\" value=\" Edit \" alt=\"Edit\" name=\"Edit\" title=\"Edit\" />";
			echo "</form>";
			echo "</td>";
			echo "<td>";
			echo "<form method=\"post\" name=\"" . $row['UID'] . "\" action=\"?target=calendar&amp;section=update\">";
			echo "<input type=\"hidden\" name=\"DUP\" value=\"" . $row['UID'] . "\" readonly >";
			echo "<input type=\"hidden\" name=\"CALID\" value=\"" . $row['UID'] . "\" readonly=\"readonly\" />";
			echo "<input type=\"image\" SRC=\"images/icons/copy.png\" value=\" Copy \" alt=\"Copy\" name=\"Copy\" title=\"Copy\" />";
			echo "</form>";
			echo "</td>";
			echo "<td>";
			echo "<form method=\"post\" name=\"" . $row['UID'] . "\" action=\"?target=calendar&amp;section=delete\">";
			echo "<input type=\"hidden\" name=\"DEL\" value=\"" . $row['UID'] . "\" readonly=\"readonly\" />";
			echo "<input type=\"image\" SRC=\"images/icons/delete.png\" value=\" Copy \" alt=\"Delete\" name=\"Delete\" title=\"Delete\" />";
			echo "</form>";
			echo "</td>";
		}
	}

echo "</tr>\n\r";

}?>
</table>
