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
        list(
            $foo,
            $bar

        ) = self::config();
    }
}

$foo = new Foo();   // Prints 'Array ([foo] => bar)'