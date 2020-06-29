<table width="75%" class="sermons">
<tr>
<td colspan="2" align="center">
<strong>
<?php
echo substr($var_sermon,-10,10);
?>

</strong>
</td>
</tr>
<tr>
<td>

- <a href="sermons/mp3.php?d=<?php echo $var_sermon; ?>">Download</a><br />
- <a href="?target=sermons/play&amp;d=<?php echo $var_sermon; ?>">Play</a><br />

</td>
<td align="right">
<?php
if(file_exists("sermons/" . $var_sermon . ".php")){
include("./sermons/" . $var_sermon . ".php");
}


?>
</td>
</tr>
</table>
<hr />
