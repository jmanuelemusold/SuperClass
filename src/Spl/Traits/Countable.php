<?php

namespace Spl\Traits;

/**
 * @package SuperClass
 */
trait Countable
{
   /**
    * @return int
    */
    public function count()
    {
        return count($this->__val);
    } 
}