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
if(preg_match("/".'editor'."/i", $_SESSION['security'])){

?>
<div id="editbox">
<p>
Upload a new image (Maximum file size <?php echo floor(parameters('maxfileuploadsize')/1024/1024) ?> MB): 
</p>
<form action="?target=<?php echo $target; ?>&amp;section=<?php echo $section; ?>&amp;subsection=savefile" method="post" enctype="multipart/form-data">
<table>
    <tr>
        <td>
<input type="hidden" name="MAX_FILE_SIZE" value="<?php echo parameters('maxfileuploadsize') ?>" />
<label for="file">Filename:</label>
        </td>
        <td>
<input type="file" name="file" id="file"> <br />
        </td>
    </tr>
    <tr>
        <td>
<label for="type">File Type:</label>
    </td>
    <td>
<select name="type">
  <option value="podcast" selected>podcast</option>
  <option value="news">news</option>
  <option value="images">images</option>
  <option value="icons">icons</option>
  <option value="bookcovers">book covers</option>
</select>
</td>
    </tr>
  
  <tr>
  <td colspan="2">Meta Data</td>
  </tr>
  <tr>
  <td>Name / Title</td> 
  <td><input type="text" name="name" size="50"></td>
  </tr>
    
  <tr>
  <td>Date</td> 
  <td><input type="date" name="Date" value="<?php echo Date('Y-m-d') ?>"></td>
  </tr>
  
    <tr>
  <td>Meta_1</td> 
  <td><input type="text" name="Meta_1"></td>
  </tr>
      <tr>
  <td>Meta_2</td> 
  <td><input type="text" name="Meta_2"></td>
  </tr>
      <tr>
  <td>Meta_3</td> 
  <td><input type="text" name="Meta_3"></td>
  </tr>
      <tr>
  <td>Meta_4</td> 
  <td><input type="text" name="Meta_4"></td>
  </tr>
      <tr>
  <td>Description</td> 
  <td><input type="Description" name="Description"></td>
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
