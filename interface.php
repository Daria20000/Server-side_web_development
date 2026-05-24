<?php

interface CalculateSquare
{
    public function getSquare(): float;
}

class Circle implements CalculateSquare
{
    public function __construct(private float $radius) {}

    public function getSquare(): float
    {
        return M_PI * $this->radius ** 2;
    }
}

class Rectangle implements CalculateSquare
{
    public function __construct(
        private float $width,
        private float $height
    ) {}

    public function getSquare(): float
    {
        return $this->width * $this->height;
    }
}

class Car
{
    public function __construct(private string $model) {}
}

function printSquare(object $obj): void
{
    $className = get_class($obj);

    if ($obj instanceof CalculateSquare) {
        echo "Объект класса {$className} имеет площадь: " . round($obj->getSquare(), 2) . "\n";
    } else {
        echo "Объект класса {$className} не реализует интерфейс CalculateSquare.\n";
    }
}

$circle    = new Circle(8);
$rectangle = new Rectangle(5, 8);
$car       = new Car('Mercedes');

printSquare($circle);
printSquare($rectangle);
printSquare($car);