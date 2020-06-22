<table class="alerts" border="0" cellspacing="0" cellpadding="0" wclassth="100%">
<tr>
<td class="top"><?php echo $var_rectitle; ?></td>
</tr>
<tr>
<td><div class="txt">
<?php 

if(file_exists("images/covers/" . $var_recISBN . ".jpg")){
	echo "<img src=\"images/covers/" . $var_recISBN . ".jpg\" height=\"90\" />";
}
else {
	if(isset($var_recISBN13)){
		echo "<img src=\"https://www.standrewsbookshop.co.uk/covers/" . $var_recISBN13 . ".jpg\" alt=\"$var_rectitle\"/>";
	}else{
		echo "<img src=\"https://www.standrewsbookshop.co.uk/covers/" . $var_recISBN. ".jpg\" alt=\"$var_rectitle\"/>";
	}
}
?>
<table wclassth="100%">
<tr>

<td align="right"><a href="https://www.amazon.co.uk/gp/product/<?php echo $var_recISBN; ?>?ie=UTF8&tag=woodbaptchur-21&linkCode=as2&camp=1634&creative=6738&creativeASIN=<?php echo $var_recISBN; ?>">Amazon</a>
<img src="https://www.assoc-amazon.co.uk/e/ir?t=woodbaptchur-21&l=as2&o=2&a=<?php echo $var_recISBN; ?>" wclassth="1" height="1" border="0" alt="" style="border:none !important; margin:0px !important;" />
</td>
</tr>
</table>
</div></td>
</tr>
</table>
<?php 
unset($var_recISBN13);
unset($var_recISBN);
?>
