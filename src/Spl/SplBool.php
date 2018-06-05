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

   /**
    * @return bool
    */
    public function isFalse()
    {
        return $this->get() === false;
    }

   /**
    * @return bool
    */ 
    public function isTrue()
    {
        return $this->get() === true;
    }
}