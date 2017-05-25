<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Lissajous curves</title>
</head>
<body>
<?php
include_once 'LissajousCurveDrawing.php';
$lissajous = new LissajousCurveDrawing(
    new ImagickPixel('rgb(0, 255, 0)'),
    new ImagickPixel('rgb(127, 127, 127)'),
    new ImagickPixel('rgb(0, 0, 0)'),
    100
);


$lissajous->getDeltaTransformation(80, 80, 4)->writeImages('curve.gif', true);

?>

<h1>Lissajous curves with PHP and Imagick</h1>

<h2>Simple GIF images</h2>
<table>
    <tr>
        <td><b>Line</b><br>&omega;=1, &delta;=0</td>
        <td><b>Ellipse</b><br>&omega;=1, &delta;=&pi;/4</td>
        <td><b>Circle</b><br>&omega;=1, &delta;=&pi;/2</td>
    </tr>
    <tr>
        <td>
            <img src="data:image/gif;base64,<?= base64_encode($lissajous->getCurve(80, 80, 1, 0)) ?>"/>
        </td>
        <td>
            <img src="data:image/gif;base64,<?= base64_encode($lissajous->getCurve(80, 80, 1, M_PI_4)) ?>"/>
        </td>
        <td>
            <img src="data:image/gif;base64,<?= base64_encode($lissajous->getCurve(80, 80, 1, M_PI_2)) ?>"/>
        </td>
    </tr>
    <tr>
        <td><b>Figure with 2 lobes</b><br>&omega;=2, &delta;=0</td>
        <td><b>Figure with 4 lobes</b><br>&omega;=4, &delta;=0</td>
        <td><b>Figure with 6 lobes</b><br>&omega;=6, &delta;=0</td>
    </tr>
    <tr>
        <td>
            <img src="data:image/gif;base64,<?= base64_encode($lissajous->getCurve(80, 80, 2, 0)) ?>"/>
        </td>
        <td>
            <img src="data:image/gif;base64,<?= base64_encode($lissajous->getCurve(80, 80, 4, 0)) ?>"/>
        </td>
        <td>
            <img src="data:image/gif;base64,<?= base64_encode($lissajous->getCurve(80, 80, 6, 0)) ?>"/
        </td>
    </tr>
</table>

<h2>Animated GIF images - phase shift</h2>
<table>
    <tr>
        <td><b>Circle</b><br>&omega;=1, &delta;=<0, 2*pi></td>
        <td><b>Figure with 2 lobes</b><br>&omega;=2, &delta;=<0, 2&pi;></td>
        <td><b>Figure with 4 lobes</b><br>&omega;=4, &delta;=<0, 2&pi;></td>
    </tr>
    <tr>
        <td>
            <img src="data:image/gif;base64,<?= base64_encode($lissajous->getDeltaTransformation(80, 80, 1)->getImagesBlob()) ?>"/>
        </td>
        <td>
            <img src="data:image/gif;base64,<?= base64_encode($lissajous->getDeltaTransformation(80, 80, 2)->getImagesBlob()) ?>"/>
        </td>
        <td>
            <img src="data:image/gif;base64,<?= base64_encode($lissajous->getDeltaTransformation(80, 80, 4)->getImagesBlob()) ?>"/>
        </td>
    </tr>
</table>

<h2>Animated GIF images - lobe transformation</h2>
<img src="data:image/gif;base64,<?= base64_encode($lissajous->getOmegaTransformation(80, 80)->getImagesBlob()) ?>"/>

</body>
</html>
