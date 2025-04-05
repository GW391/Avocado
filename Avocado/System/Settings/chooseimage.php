<center><h2>Choose Image</h2></center>


<style>
div.gallery {
  margin: 5px;
  border: 1px solid #ccc;
  float: left;
  width: 110px;
  border-radius: 25px;
  text-align: center;
}

div.gallery:hover {
  border: 1px solid #777;
}

div.gallery img {
  width: 100%;
  height: auto;
  align: center;
}

div.desc {
  padding: 0px;
  text-align: center;
  font-weight: bold;
  
}
</style>

<?php

//set to a system page, no add article

$system = true;

//check security
if(preg_match("/".'editor'."/i", $_SESSION['security'])){

?>
<?php

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


}

// end security check
}else{
?>

Sorry you do not have the permission to view this page.

<?php
}

function all_files($dir) {
    $files = Array();
    $file_tmp1 = glob($dir."*.{jpg,png,gif,svg,bmp,PNG,JPG,GIF,BMP,SVG}", GLOB_BRACE | GLOB_MARK | GLOB_NOSORT);
    $file_tmp2 = glob($dir."*/*.{jpg,png,gif,svg,bmp,BMP,PNG,JPG,GIF,SVG}", GLOB_BRACE | GLOB_MARK | GLOB_NOSORT);
 
$file_tmp = array_merge($file_tmp1, $file_tmp2);
 
    $intable = 0;
   ?> 

    <?php
            // look for and display each image in the file_tmp array
    foreach($file_tmp as $item){
        
        if(substr($item,-1)!=DIRECTORY_SEPARATOR){
            echo "<div class=\"gallery\">\n\r";
            echo "<div class=\"desc\">" . $item . "</div>\n\r";
            $files[] = $item;
            //$dispimage = substr($item,0,-4) . "_thm". substr($item,-4,4);
            global $target;
            global $section;
            echo "<form name=\"$item\" action=\"?target=Settings&amp;section=insertimage\" method=\"post\">\n\r";
            echo "<input type=\"hidden\" name=\"image\" value=\"$item\" />\n\r";
            echo "<input type=\"hidden\" name=\"CALID\" value=\"" . validate($_POST['CALID'],'hd') . "\" />\n\r";
            echo "<input type=\"image\" src=\"$item\" alt=\"Submit\" width=\"48\" height=\"48\" value=\"$item\" name=\"image\" >\n\r";
            echo "</form>\n\r";
            echo "</div>\n\r";
           
        }else{
            //$title = Array();
            $title = explode("/", $item);
            echo "<div class=\"gallery\">";
            echo "<h3>";
            echo ucfirst(str_replace('_', ' ', $title[1]));
            echo "</h3>";
            $files = array_merge($files,all_files($item));
}
    }

    return $files;

}
?>
