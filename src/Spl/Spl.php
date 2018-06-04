<?php

/**
 * @package SuperClass
 */
class Spl
{
   /**
    * @var mixed
    */
    protected $__value;

   /**
    * @return mixed
    */ 
    private function get()
    {
        return $this->__value;
    }

   /**
    * @return mixed $value
    */
    private function set($value)
    {
        $this->__value = $value;
    }
}