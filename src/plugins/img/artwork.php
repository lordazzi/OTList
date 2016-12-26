<?php
header("Content-type: image/jpg");
$img = imagecreatefromjpeg("http://static.tibia.com/images/global/header/background-artwork.jpg");
 
$wid = imagesX($img);
$hei = imagesY($img);

$newHei = (int) ($hei * 960)/$wid;
 
$img_tmp = ImageCreateTrueColor(960, $newHei);
imagecopyresampled($img_tmp, $img, 0, 0, 0, 0, 960, $newHei, $wid,  $hei);
imagefilter($img_tmp, IMG_FILTER_CONTRAST, -50);
imagejpeg($img_tmp);
 
 
 
?>