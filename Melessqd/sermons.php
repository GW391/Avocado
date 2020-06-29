<?php
// TODO: Re-write podcast.

$system = true;
?>


<p>
<?php 
// build podcast folder to check through for podcast files.
$PodCast = PodCastURL(); 
//add the xml 
$check_paramater = parameters('Podcast_URL');
if (!isset($check_paramater) || strlen($check_paramater) == 0){
    $PodCast .= '/?format=xml';
}
?>

Podcast URL:  <a href="<?php echo validate($PodCast, 'hd'); ?>"><?php echo validate($PodCast, 'hd'); ?></a><br />
</p>
<?php 
    if (parameters('Podcast_Text')){
        echo validate(parameters('Podcast_Text'),'hd');

}
?>

<?php
//check for podcast files, specified by the filename being a date for the podcast file. 
$today = new DateTime(date('d-m-Y'));
$today->modify("+1 day");
$Adjust = 1;
while ($Adjust < 32) {

$today->modify("-1 day");

$var_sermon = $today->format("d-m-Y");
// dispaly podcast
// todo: get folder name parmaeter
if(file_exists("sermons/" . $var_sermon . ".mp3")){
    include("template/sermonlinks.php");
}

$Adjust++;
}

?>
