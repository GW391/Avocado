<?php

$tmpdate = new DateTime(date('Y-m-d'));
$Month = $tmpdate->format("m");

$num = cal_days_in_month(CAL_GREGORIAN, $Month, date('Y')); // 30


$Month = $tmpdate->format("M");

draw("large", $tmpdate, $num);

echo "<br />";

$tmpdate = new DateTime(date('Y-m-d'));
$tmpdate->modify("+1 month");
$Month = $tmpdate->format("m");

$num = cal_days_in_month(CAL_GREGORIAN, $Month, date('Y')); // 31
$Month = $tmpdate->format("M");
draw("large", $tmpdate, $num);

echo "<br />";

$tmpdate = new DateTime(date('Y-m-d'));
$tmpdate->modify("+2 month");
$Month = $tmpdate->format("m");

$num = cal_days_in_month(CAL_GREGORIAN, $Month, date('Y')); // 31
$Month = $tmpdate->format("M");

draw("small", $tmpdate, $num);
echo "<br />";

function draw($size, $Month, $num){
	$dom=0;
	$dow=0;

	$month = $Month->format("m");

	if ($size == "small") {
		$font = 7;
	}else{
		$font = 12;
	}
	echo "<table border=\"1\">";
	echo "<tr>";
	echo "<td colspan=\"7\">";
	echo "<div class=\"alerts\">";
	echo "<div class=\"top\">";
	echo "<center><strong>" . $Month->format('F') . "</strong></center>";
	echo "</div>";
	echo "</div>";
	echo "</td>";
	echo "</tr>";
	echo "<tr>";
	echo "<td>";
	echo "<strong>S</strong>";
	echo "</td>";
	echo "<td>";
	echo "<strong>M</strong>";
	echo "</td>";
	echo "<td>";
	echo "<strong>T</strong>";
	echo "</td>";
	echo "<td>";
	echo "<strong>W</strong>";
	echo "</td>";
	echo "<td>";
	echo "<strong>T</strong>";
	echo "</td>";
	echo "<td>";
	echo "<strong>F</strong>";
	echo "</td>";
	echo "<td>";
	echo "<strong>S</strong>";
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
		echo "<td>";
		echo "</td>";

		$i++;
	}
	$d=1;
	while ($d<=$num){
		if ($i==7){
			echo "</tr>\n";
			echo "<tr>";
			$i=0;
		}

		echo "<td>";

		$filename = $Month->format('Ym') . str_pad($d, 2, "0", STR_PAD_LEFT); 
		$daydate = date($filename);
$date = date('Ymd');

$Where = "Date = $daydate && Date>=$date AND Deleted!=1";

if (isset($_SESSION['security'])){
if(preg_match("/".'Attendee'."/i", $_SESSION['security'])){
    }else{
        $Where .= " AND Restricted!=1";
    }
}else{
    $Where .= " AND Restricted!=1";
}
$select = "Date, Event, Time";
$from = "Pcalder";
$sort = "Date, Time";
$limit = null;
$Group = null;
$die = null;

$result = SQL($select, $from, $die, $Where, $limit, $Group, $sort);
    

		if (num_rows($result) >= 1) {
			echo "<b><a href=\"#" . str_pad($d, 2, "0", STR_PAD_LEFT);
			echo $Month->format("m");
			echo "\">" . $d . "<span>";
			$r = 1;
			while ($row = fetch_array($result)){
				if (isset($row['Event'])){
					echo  nl2br(htmlspecialchars($row['Event']));
                                        if (($row['Time']) <> "00:00:00"){
                                            echo ": " . (substr($row['Time'],0,5));
                                        }
					if ($r < num_rows($result)){
					echo "<br />";
					echo "<br />";
					}
					$r++;

				}else {
					echo "No event details";
				}
			}
			echo "</span></a></b>";

		}else{
			if ($d < date('d') && ($Month->format('Ym') == date('Ym'))){
				echo '<font color="#999999">' . $d . "</font>";
			}else{
				echo $d;
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