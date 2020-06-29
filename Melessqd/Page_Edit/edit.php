<!-- TinyMCE -->
<script src="https://cdn.tiny.cloud/1/dejmfbux0xqadkp5hbm76xqdhabshh5dvl7zaijc8vg5obrr/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    
   // settings: {plugins:"charmap,colorpicker,hr,lists,media,paste,tabfocus,textcolor,fullscreen,wordpress,wpautoresize,wpeditimage,wpemoji,wpgallery,wplink,wpdialogs,wptextpattern,wpview",
   //     toolbar1:"formatselect,bold,italic,bullist,numlist,blockquote,alignleft,aligncenter,alignright,link,unlink,wp_more,spellchecker,wp_add_media,wp_adv",
   //     toolbar2:"strikethrough,hr,forecolor,pastetext,removeformat,charmap,outdent,indent,undo,redo,wp_help",
   //     toolbar3:"",
   //     toolbar4:"",
   //     external_plugins:[],
   //     classic_block_editor:true},
tinymce.init({
  selector: 'textarea',
  //height: 500,
  menubar: true,
  //{plugins:"charmap,colorpicker,hr,lists,media,paste,tabfocus,textcolor,fullscreen,
  //wordpress,wpautoresize,wpeditimage,wpemoji,wpgallery,wplink,wpdialogs,wptextpattern,wpview",
  //toolbar1:"formatselect,bold,italic,bullist,numlist,blockquote,alignleft,aligncenter,alignright,link,unlink,
  //wp_more,spellchecker,wp_add_media,wp_adv",toolbar2:"strikethrough,hr,forecolor,pastetext,removeformat,
  //charmap,outdent,indent,undo,redo,wp_help",toolbar3:"",toolbar4:"",external_plugins:[],
  //classic_block_editor:true
  plugins: [
    'advlist autolink lists link image charmap print preview anchor textcolor',
    'searchreplace visualblocks code fullscreen',
    'insertdatetime media table paste code help wordcount',
    'code imagetools',
    'charmap colorpicker hr lists media paste tabfocus textcolor fullscreen'
  ],
  //plugins: [],
  toolbar1: "wp_add_media insertfile undo redo | styleselect | strikethrough bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image link,unlink,spellchecker'",
      //toolbar: ['formatselect,bold,italic,bullist,numlist,blockquote,alignleft,aligncenter,alignright,link,unlink,spellchecker'],
        toolbar2: "strikethrough hr forecolor pastetext removeformat charmap fullscreen",
   
        content_css: [
    '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
    '//www.tiny.cloud/css/codepen.min.css'
  ],
  classic_block_editor:true,
    image_list: [
      <?php

$dir = "images/";

// Sort in ascending order - this is default
$files = array_diff(scandir($dir), array('.', '..'));

// Sort in descending order
$b = scandir($dir,1);

foreach ($files as $key => $value) {
    // $arr[3] will be updated with each value from $arr...
    //echo "{$key} => {$value} ";
    echo "{title: '" .$value . "', value: 'images/" . $value . "'},\r\n";
    //print_r($files);
}

?>
  
    //{title: 'CrossLarge', value: 'images/CrossLarge.png'},
    //{title: 'My image 2', value: 'http://www.moxiecode.com/my2.gif'}
  ],
   image_uploadtab: true
});
</script>
<!-- /TinyMCE -->

<center><h2>Edit Article</h2></center>

<?php
if(preg_match("/".$ArticleEditor."/i", $_SESSION['security'])){

$system = true;
    ?>
<div id="editbox">
<form name="updateform" method="post" />
<input type="hidden" name="target" value="Page_Edit" />
<input type="hidden" name="section" value="updateSave" />

<table width="90%" border="1">
    <thead>

</thead>
<tbody>


    <?php

if (isset($_REQUEST['Edit'])){

$UUID = validate(decryptfe($_REQUEST['Edit']),'hd');

// get stock
$select = "UUID, target, section, subsection, security, sdate, fdate, header, page, format, active, System";
$From = "tblcontent";
$Where = "UUID  = '$UUID'";
$die = "Sorry there is a problem on this page please try again later";

$result = SQL($select, $From, $die, $Where, null, null, null);

while ($row = fetch_array($result)){
?>
<input type="hidden" value="<?php echo validate(encryptfe($row['UUID']),'hd') ?>" name="ID" readonly />
    <tr>
        <th>Target </th>
    <td>
        <strong><?php echo validate($row['target'],'hd') ?></strong>
    </td>
    </tr>
    <tr>
        <th>Section </th>
    <td>
        <strong><?php echo validate($row['section'],'hd') ?></strong>
    </td>
    </tr>
        <tr>
    <th>Sub-Section </th>
    <td>
        <strong><?php echo validate($row['subsection'],'hd') ?></strong>
    </td>
    </tr>
    <tr>
        <th>Visible between</th>
    <td>
        <input type="date" name="sdate" value="<?php echo validate($row['sdate'],'hd') ?>" size="10" />
-
        <input type="date" name="fdate" value="<?php echo validate($row['fdate'],'hd') ?>" size="10" />
    </td>
</tr>
            <tr>
    <th>Security</th>

    <td>

        <select name="security">
  <option value=""></option>
        <?php

        // get security parameters
	$Security = nl2br(parameters('Security'));
        $SecurityArray = explode('<br />', trim($Security));
        $num = count($SecurityArray);
        $i = 0;
while ($num > $i) {
    echo "<option value=\"" . trim($SecurityArray[$i]) . "\"";
        if(validate($row['security'],'hd') == trim($SecurityArray[$i])){
            echo "selected";
            }
echo ">" . trim($SecurityArray[$i]) . "</option>\r\n";
    $i++;
}
        ?>
</select>
    </td>
</tr>
        <tr>
    <th>Format </th>
    <td>
        <select name="format">
  <option value=""></option>
  <option value="Text" <?php if(validate($row['format'],'hd') == "Text"){echo "selected";} ?>>Text</option>
  <option value="HTML" <?php if(validate($row['format'],'hd') == "HTML"){echo "selected";} ?>>HTML</option>
  </select>
         </td>
         </tr>
         <tr>
    <th>Active </th>
    <td>
        <select name="active">
  <option value=""></option>
  <option value="0" <?php if(validate($row['active'],'hd') == "0"){echo "selected";} ?>>No</option>
  <option value="1" <?php if(validate($row['active'],'hd') == "1"){echo "selected";} ?>>Yes</option>
  </select>
         </td>
         </tr>
         
            <tr>
    <th>System Page</th>

    <td>

        <select name="System">
  <option value=""></option>
        <?php

        // get security parameters
	$SystemPages = nl2br(parameters('SystemPages'));
        $SystemArray = explode('<br />', trim($SystemPages));
        $Systemnum = count($SystemArray);
        $Systemi = 0;
while ($Systemnum > $Systemi) {
    echo "<option value=\"" . trim($SystemArray[$Systemi]) . "\"";
        if(validate($row['System'],'hd') == trim($SystemArray[$Systemi])){
            echo "selected";
            }
echo ">" . trim($SystemArray[$Systemi]) . "</option>\r\n";
    $Systemi++;
}
        ?>
</select>
    </td>
</tr>

<!php if (isset($row['header'])){
	if (len(trim($row['header']))!=0){ ?>
 <tr>
             <th>Header </th>
    <td>
       <textarea rows="5" cols="85" name="header"><?php echo validate($row['header'],'hd') ?></textarea>
         </td>
         </tr>
<!php }}?>
        <tr>
    <th>Article </th>
    <td>
        <textarea rows="30" cols="85" name="page"><?php echo validate($row['page'],'hd') ?></textarea>
         </td>
    </tr>
<?php
    }
    }else{

    ?>

        <tr>
    <th>Target </th>
    <td>
        <input name="etarget" value="<?php echo validate($_REQUEST['etarget'],'hd') ?>" />
    </td>
    <td>
    </tr>
    <tr>
    <th>Section </th>
    <td>
        <input name="esection" value="<?php if (isset($_REQUEST['esection'])){echo validate($_REQUEST['esection'],'hd');} ?>" /></td>
    <td>
    </tr>
        <tr>
    <th>Sub-Section </th>
    <td>
        <input name="esubsection" value="<?php if (isset($_REQUEST['esubsection'])){echo validate($_REQUEST['esubsection'],'hd');} ?>" /></td>
    <td>
    </tr>
                <tr>
    <th>Security</th>

    <td>

        <select name="security">
  <option value=""></option>
        <?php

        // get security parameters
	$Security = nl2br(parameters('Security'));
        $SecurityArray = explode('<br />', trim($Security));
        $num = count($SecurityArray);
        $i = 0;
while ($num > $i) {
    echo "<option value=\"" . trim($SecurityArray[$i]) . "\"";
 if (isset($row['security'])){
    if(preg_match("/".$row['security']."/i", trim($SecurityArray[$i])))

    {
            echo "selected";
 }
     }
echo ">" . trim($SecurityArray[$i]) . "</option>\r\n";
    $i++;
}
        ?>
</select>
    </td>
</tr>
    <tr>
    <th>Visible between</th>

    <td>
        <input type="date" name="sdate" value="<?php if (isset($row['sdate'])){echo validate($row['sdate'],'hd');} ?>" size="10" />
-
<input type="date" name="fdate" value="<?php if (isset($row['sdate'])){echo validate($row['fdate'],'hd');} ?>" size="10" />
    </td>
</tr>
      <tr>
    <th>Format </th>
    <td>
        <select name="format">
  <option value=""> </option>
  <option value="Text">Text</option>
  <option value="HTML" selected>HTML</option>
  </select>
         </td>
         </tr>
                 <tr>
    <th>System Page</th>

    <td>

        <select name="System">
  <option value=""></option>
        <?php

        // get security parameters
	$SystemPages = nl2br(parameters('SystemPages'));
        $SystemArray = explode('<br />', trim($SystemPages));
        $Systemnum = count($SystemArray);
        $Systemi = 0;
while ($Systemnum > $Systemi) {
    echo "<option value=\"" . trim($SystemArray[$Systemi]) . "\"";
    if (isset($row['System'])){
        if(validate($row['System'],'hd') == trim($SystemArray[$Systemi])){
            echo "selected";
    }}
echo ">" . trim($SystemArray[$Systemi]) . "</option>\r\n";
    $Systemi++;
}
        ?>
</select>
    </td>
</tr>
        <tr>
    <th>Header </th>
    <td>
        <textarea rows="5" cols="100" name="header"><?php if (isset($row['header'])){echo validate($row['header'],'hd');} ?></textarea>
         </td>
         </tr>
        <tr>
    <th>Article </th>
    <td>
        <textarea rows="30" cols="100" name="page"><?php if (isset($row['page'])){echo validate($row['page'],'hd');} ?></textarea>
         </td>
    </tr>

<?php
    }
?>

    
  <tr>
<td><input type="hidden" name="number" value="" /></td>
<td align="righ"><input type="submit" name="Save" value=" Save " /></td>
</tr>
</tbody>

</table>

</form>
</div>
<?php
}else{
echo "Sorry you don't have the permission to edit parameters";
}
?>
