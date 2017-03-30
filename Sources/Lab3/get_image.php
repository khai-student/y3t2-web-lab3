<?php
/**
 * Created by PhpStorm.
 * User: SIE
 * Date: 3/17/2017
 * Time: 12:22
 */

// Resize to 300x240
header('Content-Type: image/png');

$dest_width = 300;
$dest_height = 240;
$file = './img/file';
$image = NULL;

if (!file_exists($file)) {
    exit("Can't open file ".$file);
}

switch (exif_imagetype($file)) {
    case IMAGETYPE_JPEG:
        $image = imagecreatefromjpeg($file);
        break;
    case IMAGETYPE_GIF:
        $image = imagecreatefromgif($file);
        break;
    case IMAGETYPE_PNG:
        $image = imagecreatefrompng($file);
        break;
    default:
        header('Content-Type: image/png');
        $image = imagecreatefrompng('./img/close.png');
        imagepng($image);
        exit();
        break;
}

$dst_x = 0;
$dst_y = 0;
$dst_w = imagesx($image);
$dst_h = imagesy($image);

if (imagesx($image) > imagesy($image)) {
    $dst_w = $dest_width;
    $dst_h = floor(imagesy($image)*$dest_width/imagesx($image));
    $dst_y += floor(($dest_height - $dst_h) / 2);
}
else {
    $dst_w = floor(imagesx($image)*$dest_height/imagesy($image));
    $dst_h = $dest_height;
    $dst_x += floor(($dest_width - $dst_w) / 2);
}
$dst_image = imagecreatetruecolor($dest_width, $dest_height);
// set background to white
$white = imagecolorallocate($dst_image, 255, 255, 255);
imagefill($dst_image, 0, 0, $white);

imagecopyresampled($dst_image, $image, $dst_x, $dst_y, 0, 0, $dst_w, $dst_h, imagesx($image), imagesy($image));

$text_size = imagettfbbox(15, 0, "ubuntu.ttf", "Власов Юрий");
imagettftext($dst_image, 15, 0, floor(($dest_width-$text_size[2])/2), $text_size[5]*-1, imagecolorallocate($dst_image, 255, 0, 0), "ubuntu.ttf", "Власов Юрий");

imagepng($dst_image);
imagedestroy($dst_image);

?>