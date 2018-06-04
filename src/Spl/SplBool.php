<?php

/**
 * @package SuperClass
 */
class SplBool extends Spl
{
   /**
    * @param bool $value
    */
    public function __construct(bool $value = null)
    {
        $this->set($value);
    }
}