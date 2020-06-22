<div class="alerts">
<div class="top">
Archives
</div>
<div class="txt">

<?php
$date = new DateTime(date('Y-m-d'));
$Adjust = 1;
while ($Adjust <= 12) {

$date->modify("-1 month");
$Month = $date->format("M");
if (is_dir("sermons/Archive/" . $Month)){
	echo "<a href=\"?target=sermonsarchive&amp;Month=$Month\">" , $date->format("M") , "</a><br />";
}
$Adjust++;

}

?>

</div>
</div>
