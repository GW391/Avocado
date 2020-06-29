<?php
$system = true;
?>

<table border="0" cellpadding="0" width="100%" summary="Table for formatting purposes only">
      <tr>
	
        <td valign="bottom" width="100%" align="center" colspan="3">
<h1>
<?php
    if (parameters('Organisation')){
        echo validate(parameters('Organisation'),'hd');
}
?>
 Book shop</h1>
</td>
</tr>
      <tr>
<td>

        <map name="boxmap">
        <area shape="rect" coords="13,58,87,70" href="https://rcm-uk.amazon.co.uk/e/cm/privacy-policy.html?o=2" target="_child" alt="Amazon privicy statment" title="Amazon privicy statment" >
        <area coords="0,0,10000,10000" href="https://www.amazon.co.uk/?&tag=<?php echo parameters('Bookshop_Affiliate_Tag'); ?>&camp=1790&creative=6962&linkCode=ur1&adid=1V0YDYS3261VPKBZVDNC&" target="_child" alt="Amazon" title="Amazon" > </map>
        <img src="https://images-na.ssl-images-amazon.com/images/G/02/associates/maitri/banner/uk_banner_logo_w_100x70.gif" width="100" height="70" border="0" usemap="#boxmap" alt="Amazon" title="Amazon" />

      </tr>
    </table>
<?php
    $Select = "UUID, ISBN, ISBN13, title, CDate";
    $From = "tblbooklist";
    $Limit = null;
    $die = "Sorry no Books ";
    $sort = "CDate";
    $GROUP = null;
    $Where = null;
    $result = SQL($Select, $From, $die, $Where, $Limit, $GROUP, $sort);
?>

<table width="100%" border="0" class="alerts">
<tr>
<td class="top">
Suggested Reading
</td>
</tr>
</table>

<table width="100%" border="0" class="alerts">
<tr valign="top">
<?php
$var_row=1;

while ($row = fetch_array($result)){

?>

<?php

echo "<td>";
$var_rectitle = validate($row['title'], 'hd');
$var_recISBN = validate($row['ISBN'], 'hd');
$var_recISBN13 = validate($row['ISBN13'], 'hd');
include("System/bookshop/bookshoprec.php");
echo "</td>";
$var_row++;

if ($var_row == 4) {
 echo "</tr>";
 echo "<tr valign='top'>";
}
}
?>
</tr>
</table>