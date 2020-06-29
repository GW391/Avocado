<?php

//todo : update news to list from Database rather than hard coded file name format.
$system = true;
if (isset($_REQUEST["news"])){
$news = validate($_REQUEST["news"],'hd');

}else{
$date = new DateTime(date('Y-m-d'));
$date->modify("+1 month");
	$news = $date->format("My") . "w.pdf";

	if(file_exists("news/" . $news)){

	}else{
$date->modify("-1 month");
$news = $date->format("My") . "w.pdf";
if(file_exists("news/" . $news)){

	}else{
$date->modify("-1 month");
$news = $date->format("My") . "w.pdf";
	}
	}

}

?>
<embed src="news/<?php echo $news ?>" width="98%" height="600" scrolling="auto" border="0" marginwidth="0"  src="news/<?php echo $news ?>" style="border:none;" frameborder="0" type="application/pdf"></embed>