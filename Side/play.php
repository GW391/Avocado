<table width=99% border=0>
<tr>
<td colspan=2 align=center>
<h3>
<?php echo $_REQUEST["d"]; ?>
<?php
$addpath='';
$addext='';
?>
</h3>
</td>
</tr>
<tr>
<td>

<object width="300">
<param name="src" value="http://www.woodstockbaptistchurch.org.uk/sermons/<?php echo $addpath; ?><?php echo $_REQUEST["d"]; ?><?php echo $addext; ?>.mp3">
<param name="autoplay" value="false">
<param name="controller" value="true">
<param name="bgcolor" value="#FFFFFF">
<embed src="http://www.woodstockbaptistchurch.org.uk/sermons/<?php echo $addpath; ?><?php echo $_REQUEST["d"]; ?><?php echo $addext; ?>.mp3" loop="false" width="300" controller="true" bgcolor="#FFFFFF"></embed>
</object>

</td>
<td align=right>
<p>
<?php
if(file_exists("sermons/" . $_REQUEST["d"] . ".php")){
include("./sermons/" . $_REQUEST["d"] . ".php");


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
