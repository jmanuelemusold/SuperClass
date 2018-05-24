<?php

require __DIR__ . '/../vendor/autoload.php';

/**
 * @property array $arr
 * @property arr(2) $arr_a
 * @property array(2-3) $arr_b
 * @property arr(2-3|5) $arr_c
 * @property array(2-3|5-6) $arr_d
 * @property arr(2-3|5-6|8) $arr_e
 * @property array[bool] $arr_f
 * @property arr[boolean|chr] $arr_g
 * @property [bool|char|float] $arr_h
 * @property arr(2)[boolean|chr|float(2)] $arr_i
 * @property array(2-3)[bool|char|float(2-3)] $arr_j
 * @property arr<bool, char> $arr_k
 * @property array(2-3|5)<boolean, chr> $arr_l
 * @property arr(2-3|5-6)<bool, chr, float> $arr_m
 * @property bool $bool_a
 * @property boolean $bool_b
 * @property float $float_a
 * @property float(2) $float_b
 * @property float(2,3) $float_c
 * @property float(2-3,4) $float_d
 * @property float(2-3|5,6) $float_e
 * @property float(2-3,4|5-6) $float_f
 * @property float(2-3|5-6,7) $float_g
 */
class Foo
{
    use \SuperClass;
}

Foo::info();