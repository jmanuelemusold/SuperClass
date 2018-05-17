<?php

trait SuperClass
{
   /**
    * @see SuperClass::__superclass__construct
    */
    public function __construct(array $args = null)
    {
        $this->__superclass__construct($args);
    }

   /**
    * @param  array|null $args
    */
    private function __superclass__construct(array $args = null)
    {
        foreach ((array) $args as $key => $val)
            $this->$key = $val;
    } 
}