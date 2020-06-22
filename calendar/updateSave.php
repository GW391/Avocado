<?php
$system = true;
if (isset($_SESSION['security']) || parameters('CalendarPublicPost')){
    if(stripos($_SESSION['security'], 'editor') !== false || stripos($_SESSION['security'], 'Calendar') !== false  || parameters('CalendarPublicPost')){

$pos = strpos($_POST['Date'], '/');

if ($pos === false) {
	$Date = date('Ymd', strtotime($_POST['Date']));
}elseif ($pos === 4) { 
	$Date = date('Ymd', strtotime($_POST['Date']));
}elseif ($pos === 2) {
	$TDateDay = substr($_POST['Date'],0,2); 
	$TDateMonth = substr($_POST['Date'],3,2); 
	$TDateYear = substr($_POST['Date'],6,4);
	$Date = date('Ymd', strtotime($TDateYear . $TDateMonth . $TDateDay));
}

// $Date = date('Ymd', strtotime($_POST['Date']));

if (strlen($_POST['Time']) != 0){
       $Time = $_POST['Time'];
}else{
    $Time = '00:00:00';
}
if (strlen($_POST['ETime']) != 0){
       $ETime = $_POST['ETime'];
}else{
    $ETime = '00:00:00';
}
$Event = validate($_POST['Event'], 'h');
$venue = validate($_POST['venue'], 'h');
$DateCreate = Date('Ymd');
$WhoCreate = validate($_SESSION['user'], 'h');
$DateUpdate = Date('Ymd');
$WhoUpdate = validate($_SESSION['user'], 'h');
$target = validate($_POST['ltarget'], 'h');
$section = validate($_POST['lsection'], 'h');
$flyer = validate($_POST['lflyer'], 'h');


if ($_POST['restrict']){
    $Restricted = 1;
}else{
    $Restricted = 0;
}

if (isset($_POST['UUID'])){

// Update

$UUID = $_POST['UUID'];
// echo $UUID;

$update = "Pcalder";
$set = "Date = '$Date', Time = '$Time', ETime = '$ETime', Event = '$Event', venue = '$venue', dateupdated = '$DateUpdate', whoupdated = '$WhoUpdate', target = '$target', section = '$section', Restricted = '$Restricted', Flyers = '$flyer'";
        $where = "UID = '$UUID'";
        $limit = '1';
        $die = 'Sorry there has been a problem please try again';

$result = SQLU($update, $set, $where, $limit, $die);

echo parameters('CalendarUpdateRecordText');

}else{

    $db = 'Pcalder';
    $cols = 'Date, Time, ETime, Event, venue, datecreted, whocreated, target, section, Restricted, Flyers';
    $vals = "'$Date','$Time','$ETime','$Event','$venue','$DateCreate','$WhoCreate','$target','$section','$Restricted','$flyer'";
    $die = 'Sorry there has been a problem please try again';
    
    $result = SQLI($db, $cols, $vals, $die);

echo parameters('CalendarCreateRecordText');



// check if recurrence is set
if (isset($_POST['rectimes']) && $_POST['rectimes'] != "" ){
    
    
    $i=1;

    $Months = [January, February, March, April, May, June, July, August, September, October, November, December];
    $Weeks = [First, Second, Third, Fourth, Fifth];

   // echo strtoupper($_POST['frequency']);
    
    $newDate = new DateTime ($Date);
    $MonthNumber = $newDate->format('m');
    if (strtoupper($_POST['frequency']) == 'LAST' ){
        $Frequency = 'Last';
        //echo 'Last';
    }else{
    $Frequency = validate($_POST['frequency'], 'n');
    }
    
    while ($i <> validate($_POST['rectimes'],'n')){
        echo 'in while' . $i;
        $ModifiedMonthNumber = $MonthNumber + $i -1;
        
        if ($_POST['frequencytype'] == 'Days' or $_POST['frequencytype'] == 'Weeks'){
            $newDate = $newDate -> modify('+' . validate($_POST['frequency'], n) . $_POST['frequencytype']);
        }else if ($Frequency == 'Last') {
            echo '- in Last';
            $num = cal_days_in_month(CAL_GREGORIAN, $ModifiedMonthNumber, date('Y')); // 30
            
            //make month array
            $MonthArray = array();
            
            for ($x = 1; $x <= $num; $x++)
            {
                echo '-in for' . $x;
                $NewDay = new DateTime(date('Y')-$ModifiedMonthNumber-$x);
                $MonthArray[] = $NewDay->format('l');
            }
print_r($MonthArray);
            //Calculate Date of last Day
            $arraynum = $num-1;
            $Day = '';
       while ($Day != $_POST['frequencytype']){
           $Day = $MonthArray[$arraynum];
           echo $Day;
       }
       
       echo 'Resulting Day ' . $Day . '</br>';
       $calculatedDate = $Day . '-' . $ModifiedMonthNumber . '-' . Date('Y');
       echo 'resulting date ' . $calculatedDate;

            $newDate = new DateTime($calculatedDate);
        }else{
            $FrequencyArray = $Frequency -1;
            $newDate = new DateTime($Weeks[$FrequencyArray] . ' ' . $_POST['frequencytype'] . ' of ' . $Months[$ModifiedMonthNumber]);
        }
        
        echo $newDate->format('d-m-y');
        $newDate = $newDate->format('Ymd');
        
    $db = 'Pcalder';
    $cols = 'Date, Time, ETime, Event, venue, datecreted, whocreated, target, section, Restricted, Flyers';
    $vals = "'$newDate','$Time','$ETime','$Event','$venue','$DateCreate','$WhoCreate','$target','$section','$Restricted','$flyer'";
    $die = 'Sorry there has been a problem please try again';
    
    $result = SQLI($db, $cols, $vals, $die);

echo "Event Created";
        
   $i++;
    }
    
}

}
}else{
echo "Sorry you do not have the permission to use this facility";
}
}else{
echo "Sorry you need to login to use this page";
}

require ("./calendar.php");

?>