<center><h2>Photo Gallery</h2></center>
<?php
$system = true;

if (isset($_GET['imname'])){
$image = validate($_GET['imname'],'hd');
$dispimage = substr($image,0,-4) . "_std". substr($image,-4,4);

echo "image: " . $image;
echo "<br />";
echo "display image : " . $dispimage;

echo "<center>";
if(is_file("$dispimage")){
echo "<img src=\"" . $dispimage . "\" />\n";
}else{
echo "<img src=\"gallery/image.php?imname=" . $image . "\" />\n";
}
echo "</center>";
}else{

//var_dump(gd_info());

all_files('gallery/');

}

function all_files($dir)
{
    $files = Array();
    $file_tmp = glob($dir.'*',GLOB_MARK | GLOB_NOSORT);
    $c=1;


    foreach($file_tmp as $item){
        if(substr($item,-1)!=DIRECTORY_SEPARATOR){
            if ((!preg_match("./_thm/i",$item)) && (!preg_match("./_std/i",$item))){

            //echo $item;            
            $files[] = $item;
            $dispimage = substr($item,0,-4) . "_thm". substr($item,-4,4);
		echo "<center>";
                echo "<a href=\"?target=gallery&imname=" . $item . "\">";
                    if(is_file("$dispimage")){
    echo "<img src=\"" . $dispimage . "\" />\n";
}else{
echo "<img src=\"gallery/thumb.php?imname=/" . $item . " \" border=\"0\" />";
}
echo "</a>";
echo "</ceneter>\n";

                if ($c == 4){
                    $c = 1;
                    //echo $c;
                    echo "</td></tr><tr><td>\n\r";
                }else{
                    $c++;
                    //echo $c;
                    echo "</td><td>\n\r";
                }
            }
        }else{
            if ($intable){
                echo "</table>\n\r";
                echo "<center></div>";
                $intable = 0;
            }
            //$title = Array();
            $title = explode("/", $item);
            echo "<div class=\"gallery\"><center>";
            echo "<h3><strong><center>";
            echo ucfirst(str_replace('_', ' ', $title[1]));
            echo "</center></strong></h3>";
            echo "<table border=\"1\" padding=\"1\"><tr><td>";
            $c=1;
            $intable = 1;
                //echo $c;
            $files = array_merge($files,all_files($item));
}
    }

    return $files;

}

?>
</table>