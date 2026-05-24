<?php

class Cat

{
    private $name;
    private string $color;

    public $weight;

    public function __construct(
        string $name,
        string $color
    ) {
        $this->name = $name;
        $this->color = $color;
    }

    public function getColor(): string
    {
        return $this->color;
    }

    public function sayHello()
    {
        echo 'Привет! Меня зовут ' . $this->name . '.' . ' Я ' . $this->color . ' кошка.';
    }

    public function setName(string $name)
    {
        $this->name = $name;

    }

    public function getName(): string
    {
        return $this->name;
    }
}

// Создаём кошек
$cat1 = new Cat('Мурка', 'рыжая');
$cat2 = new Cat('Снежка', 'белая');
$cat3 = new Cat('Уголёк', 'чёрная');

echo $cat1->sayHello() . "\n";
echo $cat2->sayHello() . "\n";
echo $cat3->sayHello() . "\n";

// Геттер
echo "\nЦвет первой кошки: " . $cat1->getColor() . "\n";