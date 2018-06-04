<?php

/**
 * @package SuperClass
 */
class SplFloat extends Spl
{
   /**
    * @param float $value
    */
    public function __construct(float $value = null)
    {
        $this->set($value);
    }
}