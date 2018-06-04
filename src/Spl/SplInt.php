<?php

/**
 * @package SuperClass
 */
class SplInt extends Spl
{
   /**
    * @param int $value
    */
    public function __construct(int $value = null)
    {
        $this->set($value);
    }
}