<?php

/**
 * @package SuperClass
 */
class SplNumber extends Spl
{
   /**
    * @param number $value
    */
    public function __construct($value = null)
    {
        $this->set($value);
    }
}