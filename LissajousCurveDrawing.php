<?php

/**
 * Draw Lissajous
 *
 * Generate animated GIFs of Lissajous curves using Imagick library
 *
 * **Example usage**
 *
 * Create object:
 * ```
 * $lissajous = new LissajousCurveDrawing(
 *     new ImagickPixel('rgb(0, 255, 0)'),
 *     new ImagickPixel('rgb(127, 127, 127)'),
 *     new ImagickPixel('rgb(0, 0, 0)'),
 *     100
 * );
 * ```
 *
 * Draw simple curve:
 *
 * ```
 * header('Content-Type: image/gif');
 * echo $lissajous->getCurve(80, 80, 1, 0);
 * ```
 *
 * Draw animation:
 *
 * ```
 * header('Content-Type: image/gif');
 * echo $lissajous->getDeltaTransformation(80, 80, 1);
 * ```
 */
class LissajousCurveDrawing
{
    /**
     * Color of a curve
     *
     * @var ImagickPixel
     */
    private $primaryColor;

    /**
     * Color of axes
     *
     * @var ImagickPixel
     */
    private $secondaryColor;

    /**
     * Canvas size
     *
     * Image canvas covers [-size..+size]
     *
     * @var int
     */
    private $canvasSize;

    /**
     * Background color
     *
     * @var ImagickPixel
     */
    private $backgroundColor;

    const GIF = 'gif';

    /**
     * Constructor
     *
     * @param ImagickPixel $primaryColor
     * @param ImagickPixel $secondaryColor
     * @param ImagickPixel $backgroundColor
     * @param int $canvasSize
     */
    public function __construct(
        ImagickPixel $primaryColor,
        ImagickPixel $secondaryColor,
        ImagickPixel $backgroundColor,
        $canvasSize
    )
    {
        $this->primaryColor = $primaryColor;
        $this->secondaryColor = $secondaryColor;
        $this->backgroundColor = $backgroundColor;
        $this->canvasSize = $canvasSize;
    }

    /**
     * Get blank canvas
     *
     * @return Imagick
     */
    private function getBlankCanvas()
    {
        $gif = new Imagick();
        $gif->setFormat('gif');

        return $gif;
    }

    /**
     * Get a draw of Lissajous curve and axes
     *
     * @param int $amp1
     * @param int $amp2
     * @param float $omega
     * @param float $delta
     *
     * @return ImagickDraw
     */
    private function getDraw($amp1, $amp2, $omega, $delta)
    {
        $draw = new ImagickDraw();

        $draw->setFillColor($this->secondaryColor);
        $draw->line(0, $this->canvasSize, 2 * $this->canvasSize, $this->canvasSize);
        $draw->line($this->canvasSize, 0, $this->canvasSize, 2 * $this->canvasSize);
        $draw->annotation(
            10,
            (2 * $this->canvasSize) - 0.05 * 2 * $this->canvasSize,
            sprintf('ω = %.2f, δ = %.2f', $omega, $delta)
        );

        $draw->setFillColor($this->primaryColor);
        for ($angular = 0; $angular < 2 * M_PI; $angular += 0.001) {
            list($x, $y) = $this->lissajous($angular, $amp1, $amp2, $omega, $delta);
            $draw->point($x + $this->canvasSize, $y + $this->canvasSize);
        }

        return $draw;
    }

    /**
     * Get frame for canvas
     *
     * @param ImagickDraw $draw
     *
     * @return Imagick
     */
    private function getFrame(ImagickDraw $draw)
    {
        $frame = new Imagick();
        $frame->newImage(
            2 * $this->canvasSize,
            2 * $this->canvasSize,
            $this->backgroundColor
        );
        $frame->setImageFormat(self::GIF);
        $frame->drawImage($draw);
        $frame->setImageDelay(1 / 5);

        return $frame;
    }

    /**
     * Compute values of point on a curve
     *
     * @param float $timeT
     * @param int $amp1
     * @param int $amp2
     * @param float $omega
     * @param float $delta
     *
     * @return array
     */
    private function lissajous($timeT, $amp1, $amp2, $omega = 1.0, $delta = 0.0)
    {
        return [
            $amp1 * sin($timeT + $delta),
            $amp2 * sin($omega * $timeT),
        ];
    }

    /**
     * Get delta transformation
     *
     * @param int $amp1
     * @param int $amp2
     * @param float $omega
     *
     * @return Imagick
     */
    public function getDeltaTransformation($amp1, $amp2, $omega)
    {
        $gif = $this->getBlankCanvas();
        for ($delta = 0; $delta < 2 * M_PI; $delta += 0.5) {
            $frame = $this->getFrame($this->getDraw($amp1, $amp2, $omega, $delta));
            $gif->addImage($frame);
        }

        return $gif;
    }

    /**
     * Get omega transformation
     *
     * @param int $amp1
     * @param int $amp2
     *
     * @return Imagick
     */
    public function getOmegaTransformation($amp1, $amp2)
    {
        $gif = $this->getBlankCanvas();
        for ($omega = 0; $omega < 5 * M_PI; $omega += 0.1) {
            $frame = $this->getFrame($this->getDraw($amp1, $amp2, $omega, 0));
            $gif->addImage($frame);
        }

        return $gif;
    }

    /**
     * Get curve
     *
     * @param int $amp1
     * @param int $amp2
     * @param float $omega
     * @param float $delta
     *
     * @return Imagick
     */
    public function getCurve($amp1, $amp2, $omega = 1.0, $delta = 0.0)
    {
        $gif = $this->getBlankCanvas();
        $frame = $this->getFrame($this->getDraw($amp1, $amp2, $omega, $delta));
        $gif->addImage($frame);

        return $gif;
    }
}
