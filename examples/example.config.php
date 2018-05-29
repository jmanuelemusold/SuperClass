<?php

require __DIR__ . '/../vendor/autoload.php';

class Foo
{
    use \Config;

    public function __construct()
    {
        print_r(self::config('foo'));
    }
}

$foo = new Foo();