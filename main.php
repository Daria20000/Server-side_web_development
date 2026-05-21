<?php

$equation = "X + 3 = 7";

$equation = str_replace(" ", "", $equation);

list($left, $right) = explode("=", $equation);

if (strpos($left, '+') !== false) {
    $parts = explode('+', $left);
    $operator = '+';
} elseif (strpos($left, '-') !== false) {
    $parts = explode('-', $left);
    $operator = '-';
} elseif (strpos($left, '*') !== false) {
    $parts = explode('*', $left);
    $operator = '*';
} elseif (strpos($left, '/') !== false) {
    $parts = explode('/', $left);
    $operator = '/';
} else {
    die("Оператор не найден");
}

if ($parts[0] == 'X') {
    $number = $parts[1];
    $x_left = true;
} else {
    $number = $parts[0];
    $x_left = false;
}

switch ($operator) {
    case '+':
        $x = $right - $number;
        break;
    case '-':
        $x = $x_left ? $right + $number : $number - $right;
        break;
    case '*':
        $x = $right / $number;
        break;
    case '/':
        $x = $x_left ? $right * $number : $number / $right;
        break;
}

echo "x = " . $x;
