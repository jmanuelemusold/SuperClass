<?php

/**
 * @package SuperClass
 */
trait SuperClass
{
   /**
    * @var \Classinfo
    */
    private static $__classinfo;

   /**
    * @see SuperClass::__superclass__call
    */
    public function __call(string $name, array $args)
    {
        return $this->__superclass__call($name, $args);
    }

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
    * @param string $name
    * @param array $args
    * @return self::class
    */
    private function __superclass__call(string $name, array $args)
    {
        $this->__set($name, $args[0]);

        return $this;
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

   /**
    * @return \Classinfo
    */
    private static function classinfo()
    {
        $info = self::$__classinfo;

        if (!$info) {
            $info = new Classinfo(self::class);

            self::$__classinfo = $info;
        }

        return $info;
    }

   /**
    * @see SuperClass::classinfo
    */
    public static function info()
    {
        return self::classinfo()->withTags();
    }

   /**
    * @param array|null $args
    * @return self::class
    */
    public static function newInstance(array $args = null)
    {
        return (new self($args));
    }

   /**
    * @see SuperClass::property
    */
    public static function prop($name)
    {
        return self::property($name);
    }

   /**
    * @param string $name
    * @return \Classinfo\Property
    */ 
    public static function property($name)
    {
        return self::classinfo()->getProperty($name);
    }
}