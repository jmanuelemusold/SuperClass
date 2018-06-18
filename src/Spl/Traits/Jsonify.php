<?php

namespace Spl\Traits;

/**
 * @package SuperClass
 */
trait Jsonify
{
   /**
    * @return string
    */
    public function toJson()
    {
        return json_encode($this->__val);
    } 
}