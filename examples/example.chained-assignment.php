<?php

require __DIR__ . '/../vendor/autoload.php';

/**
 * @property string $name
 * @property string $url
 */
class Thing
{
    use \SuperClass;

    protected $name;

    protected $url;
}

$obj = new Thing();
$obj->name('SuperClass')->url('https://github.com/jmanuelemus/SuperClass');

print_r($obj);      // Must return ["name" => "SuperClass", "url" => "https://github.com/jmanuelemus/SuperClass"]