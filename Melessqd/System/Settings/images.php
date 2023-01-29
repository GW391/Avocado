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

<center><h2>Images</h2></center>
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
<form action="?target=<?php echo $target; ?>&amp;section=<?php echo $section; ?>&amp;subsection=saveimage" method="post" enctype="multipart/form-data">
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
<label for="file">File Location:</label>
    </td>
    <td>
<select name="location">
  <option value="images" selected>images</option>
  <option value="images/icons">icons</option>
  <option value="images/bookcovers">book covers</option>
  </select>
</td>
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

$tinyMCEImage = "

// This list may be created by a server logic page PHP/ASP/ASPX/JSP in some backend system.
// There images will be displayed as a dropdown in all image dialogs if the \"external_link_image_url\"
// option is defined in TinyMCE init.

var tinyMCEImageList = new Array(
	// Name, URL
";



if (isset($_GET['imname'])){
$image = validate($_GET['imname'],'hd');

echo "<center>";
echo "<H2> $image </H2>";
echo "<img src=$image />\n";
echo "</center>";
echo "<a href=\"?target=$target&amp;section=$section&amp;subsection=images\">Back to list";
}else{


all_files('images/');

echo "</table>";

$tinyMCEImage .= ");";

//echo $tinyMCEImage; 

echo file_put_contents("lists/image_list.js", $tinyMCEImage);

}

// end security check
}else{
?>

Sorry you do not have the permission to view this page.

<?php
}

function all_files($dir) {
    $files = Array();
    $file_tmp1 = glob($dir."*.{jpg,png,gif,bmp,PNG,JPG,GIF,BMP}", GLOB_BRACE | GLOB_MARK | GLOB_NOSORT);
    $file_tmp2 = glob($dir."*/*.{jpg,png,gif,bmp,BMP,PNG,JPG,GIF}", GLOB_BRACE | GLOB_MARK | GLOB_NOSORT);
 
$file_tmp = array_merge($file_tmp1, $file_tmp2);
 
    //$c=1;
    global $tinyMCEImage;
    //$intable=0;
    $comma = 0;
/*    $intable = 0;
    
      //      $title = explode("/", $item);
            echo "<div class=\"gallery\"><center>";
            echo "<h3><strong><center>";
      //      echo ucfirst(str_replace('_', ' ', $title[1]));
            echo "</center></strong></h3>";
            echo "<table border=\"1\" padding=\"1\"><tr><td>";
            $c=1;
            $intable = 1;
*/
            // look for and display each image in the file_tmp array
    foreach($file_tmp as $item){
                        if($comma !=0){
                    $tinyMCEImage .= ",";
                }
                

        
        if(substr($item,-1)!=DIRECTORY_SEPARATOR){

                    echo "<div class=\"gallery\">\n\r";
            echo "<div class=\"desc\">" . $item . "</div>\n\r";
        //    echo $item;
            
            $files[] = $item;
            //$dispimage = substr($item,0,-4) . "_thm". substr($item,-4,4);
		echo "<center>";
        $tinyMCEImage .= "\r";
	$tinyMCEImage .= "[\"" . $item . "\", \"" . $item . "\"]"; 
            $comma++;
            //echo $comma;
	// echo $tinyMCEImage;
            global $target;
            global $section;
        
            echo "<a href=\"?target=$target&amp;section=$section&amp;subsection=images&amp;imname=$item\">";
 //           echo "<img src=\"" . $item . "\" width='100' />\n";
           echo "<img src=\"" . $item . "\" width='100%' />\n";
echo "</a>";
echo "</div>";
/*echo "</ceneter>\n";

                if ($c == 4){
                    $c = 1;
                    //echo $c;
                    echo "</td></tr><tr><td>\n\r";
                }else{
                    $c++;
                    //echo $c;
                    echo "</td><td>\n\r";
                }
           */
        }else{
       /*     if ($intable){
                echo "</table>\n\r";
                echo "<center></div>";
                $intable = 0;
            }*/
            //$title = Array();
            $title = explode("/", $item);
            echo "<div class=\"gallery\">";
            echo "<h3><strong><center>";
            echo ucfirst(str_replace('_', ' ', $title[1]));
            echo "</center></strong></h3>";
          //  echo "<table border=\"1\" padding=\"1\"><tr><td>";
          //  $c=1;
          //  $intable = 1;
                //echo $c;
            $files = array_merge($files,all_files($item));
}
    }

    return $files;

}
?>

