# Lissajous Curve Drawing

Generate animated GIFs of Lissajous curves using Imagick library.

Run example script:

```
// PHP build in server
php -S localhost:9999 example.php
```

Show image:

```
$lissajous = new LissajousCurveDrawing(
    new ImagickPixel('rgb(0, 255, 0)'),
    new ImagickPixel('rgb(127, 127, 127)'),
    new ImagickPixel('rgb(0, 0, 0)'),
    100
);

header('Content-Type: image/gif');
echo $lissajous->getDeltaTransformation(80, 80, 4)->getImagesBlob();
```

Save image to file:

```
$lissajous = new LissajousCurveDrawing(
    new ImagickPixel('rgb(0, 255, 0)'),
    new ImagickPixel('rgb(127, 127, 127)'),
    new ImagickPixel('rgb(0, 0, 0)'),
    100
);

$lissajous->getDeltaTransformation(80, 80, 4)->writeImages('curve.gif', true);
```

[Lissajous curve](https://github.com/lukashajdu/lissajous-curve-drawing/curve.gif "Curve")
