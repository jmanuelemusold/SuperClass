<?php

require __DIR__ . '/../vendor/autoload.php';

/**
 * @property bool $a
 * @property boolean $b
 * @property int $c
 * @property integer $d
 * @property int(2) $e
 * @property integer(2-3) $f
 * @property int(2-*) $g
 * @property integer(2-3|5) $h
 * @property int(2-3|5-6) $i
 * @property float $j
 * @property float(2) $k
 * @property float(2,2) $l
 * @property float(2-3,3) $m
 * @property float(2-*) $n
 * @property float(2-*,2) $o
 * @property float(*,1) $p
 * @property float(2-3|5) $q
 * @property float(2-3|5-6) $r
 * @property float(2-3,2|5-*,1) $s
 * @property str $t
 * @property string $u
 * @property string(2) $v
 * @property str(2-3) $w
 * @property string(2-3|5) $x
 * @property str(2-3|4-5) $y
 * @property chr $z
 * @property char $aa
 * @property array $ab
 * @property array(2) $ac
 * @property array(2-3) $ad
 * @property array(2-3|4) $ae
 * @property array(2-3|4-5) $af
 * @property array[bool] $ag
 * @property [boolean|int] $ah
 * @property array(2-3)[bool|integer(2)] $ai
 * @property array(2-3|4)[boolean|int(2-3)] $aj
 * @property array<bool, integer> $ak
 * @property array<boolean, int, str(2)> $al
 * @property obj $am
 * @property object $an
 * @property \StdClass $ao
 * @property resource $ap
 * @property null $aq
 * @property mixed $ar
 * @property num $as
 * @property number $at
 * @property num(2) $au
 * @property number(2-*) $av
 * @property num(2-3) $aw
 * @property number(2-3|5) $ax
 * @property fn $ay
 * @property func $az
 * @property \Closure $ba
 * @property \Foo $bb
 * @property 'A'|'B' $bc
 * @property 1|2|4|8 $bd
 * @property regex:(ab?c?) $be
 */
class Foo
{
    use \SuperClass;
}

print_r(Foo::info());