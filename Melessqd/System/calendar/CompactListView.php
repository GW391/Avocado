<!--<center><h1>
Calendar
</h1></center>-->

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

?>
<center>

<?php
while ($row = fetch_array($result)){
 //  echo "<div id='loginbox'>";
    echo "<table border=\"0\" width=\"60%\" bgcolor=\"white\" alt=\"Table for formatting purposes\">";
echo "<tr>";
echo "<td valign=\"top\">";

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
echo "<td valign=\"top\">";
echo '<a name="';
echo date('dm', strtotime($row['Date']));
echo '"></a>';


// echo "</a>";
echo "</td>";

echo "<td valign=\"top\">";


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
        
        ?>
<table width="99%">
    <tr>
        <td>
            <?php 
            echo date('l', strtotime($row['Date']));
            echo " ";
            echo date('d M', strtotime($row['Date'])); 
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
</table>
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
echo "</table>\n\r";
//echo "</div>\n\r";
echo "<br />\n\r";
}
if (isset($Page)){
    unset($Page);
}
?>

</center>
