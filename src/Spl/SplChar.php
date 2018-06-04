<?php

/**
 * @package SuperClass
 */
class SplChar extends Spl
{
   /**
    * @param char $value
    */
    public function __construct($value = null)
    {
        $this->set($value);
    }
}