<?php
ini_set('display_errors', 1);
//var_dump(gd_info());

$item = '../' . $_GET['imname'];
//$item = $_GET['imname'];
// echo $item;
$dispimage = '../' . substr($_GET['imname'],0,-4) . "_thm". substr($_GET['imname'],-4,4);

$im = imagecreatefromjpeg($item);

//$filename = 'test.jpg';
//$percent = 0.05;

// Get new sizes
list($width, $height) = getimagesize($item);
$percent = (120/$height);
$newwidth = $width * $percent;
$newheight = $height * $percent;

// Load
$thumb = imagecreatetruecolor($newwidth, $newheight);
$source = imagecreatefromjpeg($item);

// Resize
imagecopyresized($thumb, $im, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

// First we create our stamp image manually from GD
$stamp = imagecreatetruecolor(60, 10);

$copyright = parameters('Copyright');

imagestring($stamp, 1, 0, 0, $copyright . date('Y'), 0xFFFFFF);
// imagestring($stamp, 2, 50, 70, '(c) ' . date('Y'), 0xFFFFFF);

// Set the margins for the stamp and get the height/width of the stamp image
$marge_right = 0;
$marge_bottom = 0;
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