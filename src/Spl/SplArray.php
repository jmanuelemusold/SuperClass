<?php

/**
 * @package SuperClass
 */
class SplArray extends Spl implements ArrayAccess, Countable, Iterator
{
    use \Spl\Traits\ArrayAccess;
    use \Spl\Traits\Countable;
    use \Spl\Traits\Iterator;
    use \Spl\Traits\Jsonify;

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
    * @param mixed $value
    */
    protected function set($value)
    {
        $this->__val = (array) $value;
        
        $this->updateKeys();
    }
}
