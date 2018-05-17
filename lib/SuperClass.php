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
    * @see SuperClass::__superclass__get
    */
    public function __get(string $name)
    {
        return $this->__superclass__get($name);
    }

   /**
    * @see SuperClass::__superclass__set
    */
    public function __set(string $name, $value)
    {
        return $this->__superclass__set($name, $value);
    } 

   /**
    * @param array|null $args
    */
    private function __superclass__construct(array $args = null)
    {
        foreach ((array) $args as $name => $value)
            $this->__set($name, $value);
    }

   /**
    * @param string $name
    * @return mixed
    */
    private function __superclass__get(string $name)
    {
        if (method_exists($this, $getter = 'get' . ucfirst($name)))
            return $this->{$getter}();
        else
            return $this->{$name};
    }

   /**
    * @param string $name
    * @param mixed $value
    * @return mixed
    */
    private function __superclass__set(string $name, $value)
    {
        if (method_exists($this, $setter = 'set' . ucfirst($name)))
            return $this->{$setter}($value);
        else
            return $this->{$name} = $value;
    } 
}