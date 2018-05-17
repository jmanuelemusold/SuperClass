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

    public function getName()
    {
        return "{$this->name} Rules!";
    }

    public function setUrl($url)
    {
        $this->url = str_replace('http://', 'https://', $url);
    }
}

$obj = new Thing([
   'name' => 'SuperClass',
   'url' => 'http://github.com/jmanuelemus/SuperClass'
]);

echo $obj->name . "\n";   // Must print "SuperClass Rules!"
echo $obj->url . "\n";   // Must print Url with https