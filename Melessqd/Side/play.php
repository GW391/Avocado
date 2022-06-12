<table width=99% border=0>
<tr>
<td colspan=2 align=center>
<h3>
<?php 
if (isset($_REQUEST["d"]) && strlen($_REQUEST["d"])!=0) {
    $PodCastfile = validate($_REQUEST["d"],'hd');
}else{
    echo "Sorry the selected option is not available";
}
 ?>
<?php
$addpath='';
$addext='';

// get podcast URL
$PodCast = PodCastURL();

?>
</h3>
</td>
</tr>
<tr>
<td>

<object width="300">
<param name="src" value="<?php echo $PodCast?>/<?php echo $addpath; ?><?php echo $PodCastfile; ?><?php echo $addext; ?>.mp3">
<param name="autoplay" value="false">
<param name="controller" value="true">
<param name="bgcolor" value="#FFFFFF">
<embed src="<?php echo $PodCast?>/<?php echo $addpath; ?><?php echo $PodCastfile; ?><?php echo $addext; ?>.mp3" loop="false" width="300" controller="true" bgcolor="#FFFFFF"></embed>
</object>

</td>
<td align=right>
<p>
<?php
if(file_exists($PodCast . "/" . $addpath . $PodCastfile . $addext. ".php")){
//if(file_exists("sermons/" . $PodCastfile . ".php")){
//include("./sermons/" . $PodCastfile . ".php");
include("./" . $PodCast . "/" . $addpath . $PodCastfile . $addext . ".php");
}
?>
</p>
</td>
</tr>
<?php

if (isset($passage)){
?>
<tr>
<td colspan="2">
<iframe src="http://www.biblegateway.com/passage/?search=<?php echo $passage ?>;&amp;version=<?php echo $version ?>" width="100%" height="500" border="0" marginwidth="0" frameborder="0"></iframe>
</tr>
<?php
}
?>
</table>
