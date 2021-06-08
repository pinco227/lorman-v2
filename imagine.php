<?php
function showimage($text)
{
    header("Content-type: image/png");
    $string = $text;
    $im = imagecreate(589, 44);
    $bc = imagecolorallocate($im, 0, 0, 0);
    $white = imagecolorallocate($im, 178, 174, 136);
    $font = 'Rusted.ttf';
    $px = (imagesx($im) - 12 * strlen($string)) / 2;
    $py = imagesy($im) - ((imagesy($im) - 26) / 2);
    imagecolortransparent($im, $bc);
    imagettftext($im, 18, 0, $px, $py, $white, $font, $string);
    imagepng($im);
    imagedestroy($im);
}

showimage($_GET['text']);
