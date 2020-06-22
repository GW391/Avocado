<?php
//ini_set('display_errors', 1);

$imagename = validate($_GET['imname'],'hd');
$item = '../' . $imagename;
$dispimage = '../' . substr($imagename,0,-4) . "_std". substr($imagename,-4,4);

$im = imagecreatefromjpeg($item);

// Get new sizes
list($width, $height) = getimagesize($item);
$percent = (640/$width);
// echo $percent;
$newwidth = $width * $percent;
$newheight = $height * $percent;

// Load
$thumb = imagecreatetruecolor($newwidth, $newheight);
$source = imagecreatefromjpeg($item);

// Resize
imagecopyresized($thumb, $im, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

// First we create our stamp image manually from GD
$stamp = imagecreatetruecolor(130, 20);
$copyright = parameters('Copyright');

imagestring($stamp, 5, 0, 0, $copyright . date('Y'), 0xFFFFFF);

// Set the margins for the stamp 
$marge_right = 0;
$marge_bottom = 0;
//get the height/width of the stamp image
$sizex = imagesx($stamp);
$sizey = imagesy($stamp);

// Merge the stamp onto our photo with transparency of 25%
imagecopymerge($thumb, $stamp, imagesx($thumb) - $sizex - $marge_right, imagesy($thumb) - $sizey - $marge_bottom, 0, 0, imagesx($stamp), imagesy($stamp), 25);

// Content type
header('Content-type: image/png');
// Output
imagepng($thumb);
imagepng($thumb, $dispimage);
imagedestroy($im);
imagedestroy($thumb);
?>