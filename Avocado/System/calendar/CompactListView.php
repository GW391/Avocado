<!--<center><h1>
Calendar
</h1></center>-->
<style>
.table2 {
background: #F7F9FB;
}
</style>
<?php
$system = true;




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

$Select = " UID, Date, Event, venue, Time, ETime, target, section, subsection, Restricted, flyers, thumbnail";
        $From = "Pcalder";
        if (isset($Page)){
        //extract number from Page field and limit by number.
        $Limit = (int)filter_var($Page, FILTER_SANITIZE_NUMBER_INT);
          //  $Limit = val($Page);
        }else{
            $Limit = null;
        }
        $die = "Sorry no events found ";
        $sort = "Date, Time";
        $GROUP = null;
        
$result = SQL($Select, $From, $die, $Where, $Limit, $GROUP, $sort);
$events = num_rows($result);
?>
<center>

<?php
if ($events > 0){
    echo "<table border=\"0\" width=\"60%\" bgcolor=\"white\" alt=\"Tabulate the events data\">";
}
while ($row = fetch_array($result)){

 //  echo "<div id='loginbox'>";

echo "<tr>";
echo "<td rowspan=\"2\">";

if (isset($row['thumbnail'])){
	if (strlen($row['thumbnail'])!=0){
        echo "<img src=\"" . validate($row['thumbnail'],'hd') . "\" width=\"75px\" alt=\"image - " . validate($row['thumbnail'],'hd') . " Thumbnail\" />";
	}
}else{

	if (isset($_SESSION['security'])){
                    //if(stripos($_SESSION['security'], parameters('Calendar')) !== false || stripos($_SESSION['security'], 'Calendar') !== false){
if(stripos($_SESSION['security'], parameters('CalendarEditor'))){
			echo "<form method=\"post\" name=\"" . $row['UID'] . "\" action=\"?target=Settings&amp;section=chooseimage\">";
			echo "<input type=\"hidden\" name=\"CALID\" value=\"" . $row['UID'] . "\" readonly=\"readonly\" />";
			echo "<input type=\"image\" SRC=\"images/icons/edit.png\" value=\" Edit \" alt=\"Edit\" name=\"Edit\" title=\"Edit\" />";
			echo "</form>";
}}
}

echo "</td>";
//echo "<td valign=\"top\" colspan=\"3\">";
//echo '<a name="';
//echo date('dm', strtotime($row['Date']));
//echo '"></a>';


// echo "</a>";
//echo "</td>";

echo "<td valign=\"top\" colspan=\"3\">";


if (isset($row['target'])){
	if (strlen($row['target'])!=0){
		//echo '<div align="right">';
		echo '<a href="?target=' . validate($row['target'], 'hd');
		if (isset($row['section'])){
                    if (strlen(trim($row['section'])) != 0){
			echo '&amp;section=' . validate($row['section'], 'hd');
                    }
		}
		if (isset($row['subsection'])){
                    if (strlen(trim($row['subsection'])) != 0){
			echo '&amp;subsection=' . validate($row['subsection'], 'hd');
                    }
		}
                echo '">';
}

                    }
        echo  validate($row['Event'], 'hd');
        if (isset($row['target'])){
	echo '</a>';
        echo '</td>';

        	if (isset($_SESSION['security'])){
                    //if(stripos($_SESSION['security'], parameters('Calendar')) !== false || stripos($_SESSION['security'], 'Calendar') !== false){
if(stripos($_SESSION['security'], parameters('CalendarEditor'))){
			echo "<td rowspan=\"2\">";
			echo "<form method=\"post\" name=\"" . $row['UID'] . "\" action=\"?target=calendar&amp;section=update\">";
			echo "<input type=\"hidden\" name=\"CALID\" value=\"" . $row['UID'] . "\" readonly=\"readonly\" />";
			echo "<input type=\"image\" SRC=\"images/icons/edit.png\" value=\" Edit \" alt=\"Edit\" name=\"Edit\" title=\"Edit\" />";
			echo "</form>";
			echo "</td>";
			echo "<td rowspan=\"2\">";
			echo "<form method=\"post\" name=\"" . $row['UID'] . "\" action=\"?target=calendar&amp;section=update\">";
			echo "<input type=\"hidden\" name=\"DUP\" value=\"" . $row['UID'] . "\" readonly >";
			echo "<input type=\"hidden\" name=\"CALID\" value=\"" . $row['UID'] . "\" readonly=\"readonly\" />";
			echo "<input type=\"image\" SRC=\"images/icons/copy.png\" value=\" Copy \" alt=\"Copy\" name=\"Copy\" title=\"Copy\" />";
			echo "</form>";
			echo "</td>";
			echo "<td rowspan=\"2\">";
			echo "<form method=\"post\" name=\"" . $row['UID'] . "\" action=\"?target=calendar&amp;section=delete\">";
			echo "<input type=\"hidden\" name=\"DEL\" value=\"" . $row['UID'] . "\" readonly=\"readonly\" />";
			echo "<input type=\"image\" SRC=\"images/icons/delete.png\" value=\" Copy \" alt=\"Delete\" name=\"Delete\" title=\"Delete\" />";
			echo "</form>";
			echo "</td>";
		}
	}

echo "</tr>\n\r";

        echo '</tr>';
        ?>
<!--<table width="99%" border="1">-->
    <tr>
        <td>
            <?php 
            echo date('l d M', strtotime($row['Date']));
//            echo " ";
//            echo date('d M', strtotime($row['Date']));
            ?>
        </td>
        <td>
            <?php 
            if (($row['Time']) <> "00:00:00"){
	echo date('H:i', strtotime($row['Time']));
        if (($row['ETime']) <> "00:00:00" && $row['ETime'] != NULL){
            echo ' - ' . date('H:i', strtotime($row['ETime']));
        }
}else{
	echo '<a href="?target=contact&amp;section=contact">Contact us</a>';
}
?>
        </td>
        <td>
            <?php
//            echo ": " . parameters('PublicVenues');
  //          Echo ": " . $row['venue'];
            
            if (isset($_SESSION['security'])){
            if(stripos($_SESSION['security'], 'Attendee')){

           if (strlen($row['venue'])!=0){
		echo validate($row['venue'], 'hd');
            }else{
               echo '<a href="?target=contact&amp;section=contact">Contact us</a>';
            }
	}else{
            if(stripos(parameters('PublicVenues'), $row['venue']) !== false){
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
                    if(stripos(parameters('PublicVenues'), $row['venue']) !== false){
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
            ?>
        </td>
    </tr>
<!--</table>-->
<?php
	//echo '</div>';
	}
//}

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
    echo parameters('CalendarRestrictedText');
    echo '</div>';
}
}

echo "</td>";
echo "</tr>";
$events --;
if ($events > 0){
echo "<tr class=\"table2\" padding=\"0\">";
echo "<td colspan=\"7\"  class=\"table2\">";
//echo "<p class=\"table2\">";
echo "<br  />\n\r";
//echo "</p>";
echo "</td>";
echo "</tr>";

}
}
echo "</table>\n\r";
//echo "</div>\n\r";
//echo "<br />\n\r";

if (isset($Page)){
    unset($Page);
}
?>

</center>
