<?php
header('Content-type: image/png');

$result = json_decode(file_get_contents('https://kodaktor.ru/j/rates'));
$rates = [];
$height = 300;
$column = 100;
$font = __DIR__ . '/arial.ttf';

foreach ($result as $value) {
  $rates[(string) $value->name] = (float) $value->sell;
}
asort($rates);
$width = $column * count($rates);

$normal = end($rates);

$im = imagecreatetruecolor($width, $height);
$bg = imagecolorallocate($im, 255, 255, 255);
imagefilledrectangle($im, 0, 0, $width - 1, $height - 1, $bg);
$green = imagecolorallocatealpha($im, 170, 204, 119, 75);
$purple = imagecolorallocate($im, 60, 40, 40);
$i = 0;
foreach ($rates as $name => $value) {
  imagettftext($im, 10, 0, $column * $i + 5, 290, $purple, $font, $name);
  imagefilledrectangle($im, $column * $i++, (int) $height - $value / $normal * 300, $column * $i, 300, $green);
}

imagettftext($im, 10, 0, 2, 15, $purple, $font, 'by Moseev Evgeny');

imagepng($im);
imagedestroy($im);