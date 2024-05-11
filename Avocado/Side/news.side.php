<div class="alerts">
<div class="top">
Historical
</div>
<div class="txt">
<?php
//todo: make this a loop
//leave until news is provided by databse.

// display links to historical news files.
if (isset($_REQUEST["news"])){

$date = new DateTime(date('Y-m-d'));
$date->modify("+1 month");
$news = $date->format("My") . "w.pdf";
if(file_exists("news/" . $news)){

$news = $date->format("My") . "w.pdf";
echo "<a href=\"?target=news&amp;news=$news\">" , $date->format("M y") , "</a>";
echo "<br />";
}else{
$date->modify("-1 month");
$news = $date->format("My") . "w.pdf";
echo "<a href=\"?target=news&amp;news=$news\">" , $date->format("M y") , "</a>";
echo "<br />";

}
}
?>


<?php
$date = new DateTime(date('Y-m-d'));
$date->modify("+1 month");
$news = $date->format("My") . "w.pdf";
if(file_exists("news/" . $news)){

$date->modify("-1 month");
$news = $date->format("My") . "w.pdf";
echo "<a href=\"?target=news&amp;news=$news\">" , $date->format("M y") , "</a>";
echo "<br />";
}else{
$date->modify("-1 month");

}
?>


<?php
$date = new DateTime(date('Y-m-d'));
$Adjust = 1;
while ($Adjust <= 3) {
$date->modify("-1 month");
$news = $date->format("My") . "w.pdf";
echo "<a href=\"?target=news&amp;news=$news\">" , $date->format("M y") , "</a><br />";

$Adjust++;

}

?>

</div>
</div>