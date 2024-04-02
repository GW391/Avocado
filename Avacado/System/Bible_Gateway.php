<?php

// use Meta_2 in Podcast as Bible passage and it will be desispaled when this system page is added to the Podcast Play page

if (isset($Meta_2)){
?>
<tr>
<td colspan="2">
<iframe src="https://www.biblegateway.com/passage/?search=<?php echo $Meta_2 ?>;&amp;version="NIV" width="100%" height="500" border="0" marginwidth="0" frameborder="0"></iframe>
</tr>
<?php
}

