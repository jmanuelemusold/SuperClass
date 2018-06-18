<?php

/**
 * @package SuperClass
 */
class Spl
{
   /**
    * @var mixed
    */ 
    protected $__val;

   /**
    * @return mixed
    */
    protected function get($value)
    {
        return $this->__val;
    } 

   /**
    * @param mixed
    */
    protected function set($value)
    {
        $this->__val = $value;
    } 
}