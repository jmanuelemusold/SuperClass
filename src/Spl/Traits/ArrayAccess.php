<?php

namespace Spl\Traits;

/**
 * @package SuperClass
 */
trait ArrayAccess
{
   /**
    * @param int|string $offset
    * @return bool
    */ 
    public function offsetExists($offset)
    {
        return isset($this->__val[$offset]);
    }

   /**
    * @param int|string $offset
    * @return mixed
    */ 
    public function offsetGet($offset)
    {
        return ($this->offsetExists($offset)) ? $this->__val[$offset] : null;
    }

   /**
    * @param int|string $offset
    * @param mixed $value
    */ 
    public function offsetSet($offset, $value)
    {
        if (!is_array($this->__val))
            $this->__val = [];

        //

        $this->__val[$offset] = $value;

        $this->updateKeys();
    }

   /**
    * @param int|string $offset
    */ 
    public function offsetUnset($offset)
    {
        unset($this->__val[$offset]);

        $this->updateKeys();
    }

   /**
    * 
    */
    protected function updateKeys()
    {
        $this->__keys = array_keys($this->__val);      
    } 
}