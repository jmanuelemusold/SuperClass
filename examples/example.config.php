<?php

require __DIR__ . '/../vendor/autoload.php';

/**
 * @package Example
 */
class Foo
{
    use \Config;

    public function __construct()
    {
        print_r(self::config());
    }
}

$foo = new Foo();   // Prints 'Array ([foo] => bar)'