<?php
abstract class Shape {
    abstract public function calculateArea();
    abstract public function draw($img, $x0, $y0, $color);
}

class Circle extends Shape {
    private $radius;

    public function __construct($radius) {
        $this->radius = $radius;
    }

    public function calculateArea() {
        return pi() * pow($this->radius, 2);
    }

    public function draw($img, $x0, $y0, $color) {
        imageellipse($img, $x0, $y0, $this->radius * 2, $this->radius * 2, $color); 
    }
}

class Rectangle extends Shape {
    private $width;
    private $height;

    public function __construct($width, $height) {
        $this->width = $width;
        $this->height = $height;
    }

    public function calculateArea() {
        return $this->width * $this->height;
    }

    public function draw($img, $x0, $y0, $color) {
        imagerectangle($img, $x0, $y0, $x0 + $this->width, $y0 + $this->height, $color);
    }
}

$canvas = imagecreatetruecolor(400, 300);
$red = imagecolorallocate($canvas, 255, 0, 0);
$blue = imagecolorallocate($canvas, 0, 0, 255);

$rectangle = new Rectangle(200, 100);
$rectangle->draw($canvas, 50, 50, $red);

$circle = new Circle(50);
$circle->draw($canvas, 100, 210, $blue); 

ob_start();
imagepng($canvas);
$image_data = ob_get_contents();
ob_end_clean();
imagedestroy($canvas);

$circle_area = $circle->calculateArea();
$rectangle_area = $rectangle->calculateArea();
?>

    <img src="data:image/png;base64,<?php echo base64_encode($image_data); ?>" alt="Shapes Image" />

    <div style="margin-top: 20px;">
        <p style="color:red;">Circle Area: <?php echo number_format($circle_area, 2); ?></p>
        <p style="color:green;">Rectangle Area: <?php echo number_format($rectangle_area, 2); ?></p>
    </div>
