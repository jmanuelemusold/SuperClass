<?php

require __DIR__ . '/../vendor/autoload.php';

/**
 * @property string $description
 * @property string(10) $name
 * @property Url|string $url
 */
class Thing
{
    use \SuperClass;

    protected $description;

    protected $name;

    protected $url;
}

print_r(Thing::info());