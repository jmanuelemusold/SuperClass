<?php

require __DIR__ . '/../vendor/autoload.php';

$arr = new SplArray(1, 2, 3);

///
echo count($arr) . "\n";    // Prints 3

///
foreach ($arr as $key => $value) {
    echo "$key => $value\n";
}