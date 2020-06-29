<?php 
if((isset($_GET['type'])) && (strlen(trim($_GET['type'])) != 0)){
$Content=validate($_GET['type'],'hd') ;
}else{
$Content = "target";
}
?>
<script type="text/javascript" src="jscripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">
	tinyMCE.init({
		mode : "textareas",
		theme : "simple"
	});
</script>

<center><h2>Post <?php echo $Content ?></h2></center>

<?php
$system = true;
    ?>

<form name="updateform" method="post" />
<input type="hidden" readonly name="target" value="Post" />
<input type="hidden" readonly name="section" value="updateSave" />
<input type="hidden" readonly readonly name="etarget" value="<?php echo validate($_GET['etarget'],'hd') ?>" />
<input type="hidden" readonly name="esection" value="<?php echo validate($_GET['esection'],'hd') ?>" />
<input type="hidden" readonly name="esubsection" value="<?php echo validate($_GET['esubsection'],'hd') ?>" />
<input type="hidden" readonly name="Content" value="<?php echo $Content ?>" />

<table width="98%" border="1">
    <thead>

</thead>
<tbody>
<?php /*
   <tr>
    <th>Visible between</th>

    <td>
        <input type="text" name="sdate" value="<?php echo validate($row['sdate'],'hd') ?>" size="10" />
-
        <input type="text" name="fdate" value="<?php echo validate($row['fdate'],'hd') ?>" size="10" />
    </td>
</tr>
*/ ?>

        <tr>
    <td>
        <textarea rows="30" cols="98" name="page"><?php echo validate($row['page'],'hd') ?></textarea>
         </td>
    </tr>
<tr>
<td valign="top">
Email:
<input name='email' type='text' size='30' /><br />
Note: The email address will not appear in the posting, and is only used for refernce.
</td>
</tr>
 <tr>
<td align="right">
    <input type="hidden" name="number" value="" />
    <input type="submit" name="Save" value=" Post " />
</td>
</tr>
</tbody>

</table>

</form>