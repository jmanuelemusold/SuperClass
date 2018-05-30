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
            $path,
            $url
        
        ) = self::config();

        echo $path;
    }
}

$foo = new Foo();   // Prints 'https://github.com/jmanuelemus/SuperClass'