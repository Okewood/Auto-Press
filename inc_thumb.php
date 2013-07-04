<?php
$filename = $_GET['filename'];
$maxdimension = (isset($_GET['size']) ? $_GET['size'] : 100);
$spec_height = (isset($_GET['height']) ? $_GET['height'] : 0);
$spec_width = (isset($_GET['width']) ? $_GET['width'] : 0);

$size = getimagesize($filename);
$i_width = $size[0];
$i_height = $size[1];
$ratio = $i_width / $i_height;

if(isset($_GET['height'])) {
	$h = min($_GET['height'],$i_height);
	$w = $h*$ratio;
}
if(isset($_GET['width'])) {
	$w = min($_GET['width'],$i_width);
	$h = $w/$ratio;
}
if(isset($_GET['size'])) {
	$maxdimension = min(max($i_width,$i_height),$maxdimension);
	if($ratio<1) { $h = $maxdimension; $w = $maxdimension*$ratio; }
	elseif($ratio>1) { $w = $maxdimension; $h = $maxdimension/$ratio; }
	elseif($ratio==1) { $w = $maxdimension; $h = $maxdimension; }
}

header("Content-type: ".$size['mime']);
switch($size[2]) {
case 1 :
	$source = imagecreatefromgif($filename);
	$imageX = imagesx($source);
	$imageY = imagesy($source);
	$dest  = imagecreatetruecolor($w, $h);
	imagecopyresampled ($dest, $source, 0, 0, 0, 0, $w, $h, $imageX, $imageY);
	imagegif($dest);
	break;
case 2 :
	$source = imagecreatefromjpeg($filename);
	$imageX = imagesx($source);
	$imageY = imagesy($source);
	$dest  = imagecreatetruecolor($w, $h);
	imagecopyresampled ($dest, $source, 0, 0, 0, 0, $w, $h, $imageX, $imageY);
	imagejpeg($dest);
	break;
case 3 : 
	$source = imagecreatefrompng($filename);
	$imageX = imagesx($source);
	$imageY = imagesy($source);
	$dest  = imagecreatetruecolor($w, $h);
	imagecopyresampled ($dest, $source, 0, 0, 0, 0, $w, $h, $imageX, $imageY);
	imagepng($dest);
	break;
} 
 
imagedestroy($dest);
imagedestroy($source);
?>