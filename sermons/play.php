<table width=99% border=0>
<tr>
<td colspan=2 align=center>
<h3>
<?php
$file = validate($_REQUEST["d"], 'hd');
echo $file;
$addpath='';
$addext='';
?>
</h3>
</td>
</tr>
<tr>
<td>

<?php 
// embed audio player into page with podcast file.
?>
<object width="300">
<param name="src" value="https://www.woodstockbaptistchurch.org.uk/sermons/<?php echo $addpath; ?><?php echo $file; ?><?php echo $addext; ?>.mp3">
<param name="autoplay" value="false">
<param name="controller" value="true">
<param name="bgcolor" value="#FFFFFF">
<embed src="https://www.woodstockbaptistchurch.org.uk/sermons/<?php echo $addpath; ?><?php echo $file; ?><?php echo $addext; ?>.mp3" loop="false" width="300" controller="true" bgcolor="#FFFFFF"></embed>
</object>

</td>
<td align=right>
<p>
<?php
// insert podcast info file
if(file_exists("sermons/" . $file . ".php")){
    include("./sermons/" . $file . ".php");
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
<iframe src="https://www.biblegateway.com/passage/?search=<?php echo $passage ?>;&amp;version=<?php echo $version ?>" width="100%" height="500" border="0" marginwidth="0" frameborder="0"></iframe>
</tr>
<?php
}
?>
</table>
