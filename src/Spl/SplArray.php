<?php

/**
 * @package SuperClass
 */
class SplArray implements ArrayAccess, Countable, Iterator
{   
   /**
    * @var mixed
    */ 
    protected $__arr;

   /**
    * @var array
    */
    protected $__keys;

   /**
    * @var int
    */
    protected $__pos = 0; 

   /**
    * @param mixed $value
    */  
    public function __construct(...$vars)
    {
        if (count($vars) == 1)
            $vars = $vars[0];

        ///

        $this->set($vars);
    }

   /**
    * @return int
    */
    public function count()
    {
        return count($this->__arr);
    }

   /**
    * @return mixed
    */
    public function current()
    {
        return $this->__arr[$this->key()];
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
    * @param int|string $offset
    * @return bool
    */ 
    public function offsetExists($offset)
    {
        return isset($this->__arr[$offset]);
    }

   /**
    * @param int|string $offset
    * @return mixed
    */ 
    public function offsetGet($offset)
    {
        return ($this->offsetExists($offset)) ? $this->__arr[$offset] : null;
    }

   /**
    * @param int|string $offset
    * @param mixed $value
    */ 
    public function offsetSet($offset, $value)
    {
        if (!is_array($this->__arr))
            $this->__arr = [];

        //

        $this->__arr[$offset] = $value;

        $this->updateKeys();
    }

   /**
    * @param int|string $offset
    */ 
    public function offsetUnset($offset)
    {
        unset($this->__arr[$offset]);

        $this->updateKeys();
    }

   /**
    * 
    */ 
    public function rewind()
    {
        $this->__pos = 0;
    }

   /**
    * @param mixed $value
    */
    protected function set($value)
    {
        $this->__arr = (array) $value;
        
        $this->updateKeys();
    }

   /**
    * @return array
    */ 
    public function toArray()
    {
        return $this->__arr;
    }

   /**
    * @return string
    */
    public function toJson()
    {
        return json_encode($this->__arr);
    }

   /**
    * 
    */
    protected function updateKeys()
    {
        $this->__keys = array_keys($this->__arr);      
    }

   /**
    * @return bool
    */ 
    public function valid()
    {
        return isset($this->__arr[$this->key()]);
    }
}
