
<?php

    $Header = parameters('Header');
    $find = array(":Organisation", ":IncYear");
    $replace = array(parameters('Organisation'), parameters('IncYear'));
    $UpdatedHeaderValue = str_ireplace($find, $replace, $Header);

    echo $UpdatedHeaderValue;
?>


<?php if (parameters('GoogleSearch')=='Header') { ?>
<!-- Search Google -->
<div id="editbox">
<form method="get" action="http://www.google.co.uk/custom" target="google_window" title="Search results are provided by Google. <?php echo parameters('ExternalSiteDisclaimer');?>">
<br />
<div class="small">
Search results are provided by Google.
</div>
<!--#c8c8ff -->
<td nowrap="nowrap" valign="top" align="left" height="32">
<label for="sbi" style="display: none">Enter your search terms</label>
<input type="text" name="q" size="15" maxlength="255" value="" id="sbi"  />
<td valign="top" align="left">
<label for="sbb" style="display: none">Submit search form</label>
<input type="submit" name="sa" value="Search" id="sbb" />
<input type="hidden" name="client" value="pub-3212454800273765" />
<input type="hidden" name="forid" value="1" />
<input type="hidden" name="ie" value="ISO-8859-1" />
<input type="hidden" name="oe" value="ISO-8859-1" />
<input type="hidden" name="cof" value="GALT:#008000;GL:1;DIV:#336699;VLC:663399;AH:center;BGC:FFFFFF;LBGC:336699;ALC:0000FF;LC:0000FF;T:000000;GFNT:0000FF;GIMP:0000FF;FORID:1" />
<input type="hidden" name="hl" value="en" />
<br />
<div class="small">
<?php echo parameters('ExternalSiteDisclaimer');?>
</div>
</div>
<?php }?>

</form>
<!-- Search Google -->

