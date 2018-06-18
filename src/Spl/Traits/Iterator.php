<?php

namespace Spl\Traits;

/**
 * @package SuperClass
 */
trait Iterator
{
   /**
    * @var array
    */
    protected $__keys;

   /**
    * @var int
    */
    protected $__pos = 0;

   /**
    * @return mixed
    */
    public function current()
    {
        return $this->__val[$this->key()];
    }
    
   /**
    * @return int
    */ 
    public function key()
    {
        return @$this->__keys[$this->__pos];
    }
    
   /**
    * 
    */ 
    public function next()
    {
        $this->__pos++;
    }

   /**
    * 
    */ 
    public function rewind()
    {
        $this->__pos = 0;
    }

   /**
    * @return bool
    */ 
    public function valid()
    {
        return isset($this->__val[$this->key()]);
    } 
}