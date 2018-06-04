<?php

/**
 * @package SuperClass
 */
class SplString extends Spl
{
    /**
    * @param string $value
    */
    public function __construct(string $value = null)
    {
        $this->set($value);
    }
}