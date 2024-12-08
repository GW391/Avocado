<style>
div.gallery {
  margin: 5px;
  border: 1px solid #ccc;
  float: left;
  width: 150px;
  border-radius: 25px;
  text-align: center;
}

div.gallery:hover {
  border: 1px solid #777;
}

div.gallery img {
  width: 95%;
  height: auto;
  align: center;
}

div.desc {
  padding: 0px;
  text-align: center;
  font-weight: bold;
  
}
</style>

<center><h2>Upload Files</h2></center>
<?php

//set to a system page, no add article

$system = true;

//check security
$security = new securityCheck(parameters('EditPodcastSecurity'));
if ($security->output)
{

  if (isset($_REQUEST['edit'])){
 // echo $_REQUEST['edit'];
$UUID = validate(decryptfe($_REQUEST['edit']),'hd');

//  echo $UUID;

// get settings
$select = "UUID, name, Meta_1, Meta_2, Meta_4, Meta_3, Description, Date, Duration";
$From = "tblattachment";
$Where = "UUID  = '$UUID'";
$die = "Sorry there is a problem on this page please try again later";

$result = SQL($select, $From, $die, $Where, null, null, null);
//while(
$row = fetch_array($result); //){
//  echo $UUID;
//  echo $row['name'];
//  echo $row['Date'];
//  }
  }
?>
<div id="editbox">
<p>
Upload a new podcast file (Maximum file size <?php echo floor(parameters('maxfileuploadsize')/1024/1024) ?> MB):
</p>
<form action="?target=<?php echo $target; ?>&amp;section=<?php echo $section; ?>&amp;subsection=savefile" method="post" enctype="multipart/form-data">
<input type="hidden" name="type" value="podcast">
<table>
    <tr>
        <td>
<?php if (isset($UUID)){ ?>
  <input type="hidden" name="UUID" value="<?php echo encryptfe($UUID) ?>" />

<?php }?>
<input type="hidden" name="MAX_FILE_SIZE" value="<?php echo parameters('maxfileuploadsize') ?>" />
<label for="file">Filename:</label>
        </td>
        <td>
<input type="file" name="file" id="file" placeholder="Select a file to upload"> <br />
        </td>
    </tr>
  <tr>
  <td colspan="2" align="center">
  <strong>Meta Data</strong></td>
  </tr>
  <tr>
  <td>Name / Title</td> 
  <td><input type="text" name="name" size="50" placeholder="Enter a Name / Title" value="<?php if(isset($row['name'])){ echo validate($row['name'],'hd');} ?>"></td>
  </tr>
    
  <tr>
  <td>Date</td> 
  <td><input type="date" name="Date" placeholder="Date" value="<?php if(isset($row['Date'])){echo validate($row['Date'],'hd');}else{echo Date('Y-m-d');} ?>"></td>
  </tr>
  <tr>
  <td>Duration</td>
  <td><input type="text" name="Duration" placeholder="Enter a Duration hh:mm:ss" value="<?php if(isset($row['Duration'])){echo validate($row['Duration'],'hd');} ?>"></td>
  </tr>
  

  <?php if (parameters('Podcast_Meta_1')!= NULL) {
    ?>
    <tr>

  <td><?php echo parameters('Podcast_Meta_1')?></td>
  <td><input type="text" name="Meta_1" placeholder="Enter a <?php echo parameters('Podcast_Meta_1')?>" value="<?php if(isset($row['Meta_1'])){ echo validate($row['Meta_1'],'hd');} ?>"></td>
  </tr>
  <?php }
?>
  <?php if (parameters('Podcast_Meta_2')!= NULL) {
    ?>
    <tr>

  <td><?php echo parameters('Podcast_Meta_2')?></td>
  <td><input type="text" name="Meta_2" placeholder="Enter a <?php echo parameters('Podcast_Meta_2')?>" value="<?php if(isset($row['Meta_2'])){ echo validate($row['Meta_2'],'hd');} ?>"></td>
  </tr>
  <?php }
?>
  <?php if (parameters('Podcast_Meta_3')!= NULL) {
    ?>
    <tr>

  <td><?php echo parameters('Podcast_Meta_3')?></td>
  <td><input type="text" name="Meta_3" placeholder="Enter a <?php echo parameters('Podcast_Meta_3')?>" value="<?php if(isset($row['Meta_3'])){ echo validate($row['Meta_3'],'hd');} ?>"></td>
  </tr>
  <?php }
?>

  <?php if (parameters('Podcast_Meta_4')!= NULL) {
    ?>
    <tr>

  <td><?php echo parameters('Podcast_Meta_4')?></td>
  <td><input type="text" name="Meta_4" placeholder="Enter a <?php echo parameters('Podcast_Meta_4')?>" value="<?php if(isset($row['Meta_4'])){ echo validate($row['Meta_4'],'hd');} ?>"></td>
  </tr>
  <?php }
?>

<tr>
  <td>Description</td> 
  <td><input type="Description" name="Description"  placeholder="Enter a Description" value="<?php if(isset($row['Description'])){ echo validate($row['Description'],'hd');} ?>"></td>
  </tr>
    <tr>
        <td></td>
        <td>
<input type="submit" name="submit" value="Submit">
        </td>
    </tr>
</table>
</form>
</div>

<?php

// end security check
}else{

echo parameters('PermissionsMessage');
}
?>
