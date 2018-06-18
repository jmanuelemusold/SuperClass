<?php

namespace Spl\Traits;

/**
 * @package SuperClass
 */
trait Fixable
{
   /**
    * @var int
    */ 
    protected $__length;

   /**
    * @var int
    */ 
    protected $__maxLength;

   /**
    * @var int
    */ 
    protected $__minLength;

   /**
    * @var Range
    */
    protected $__range;
    
   /**
    * @see SplArray::getSize
    */ 
    public function getLength()
    {
        return $this->getSize();
    }

   /**
    * @return array|int
    */ 
    public function getMaxLength()
    {
        return $this->__maxLength;
    }

   /**
    * @return array|int
    */
    public function getMinLength()
    {
        return $this->__minLength;
    }

   /**
    * @return Range
    */
    public function getRange()
    {
        return $this->__range;
    }

   /**
    * @return array|int
    */ 
    public function getSize()
    {
        return ($this->__length) ? $this->__length : $this->count();
    }

   /**
    * @see SplArray::setSize
    */ 
    public function setLength(int $size)
    {
        return $this->setSize($size);
    }

   /**
    * @param array|int $maxLength
    */ 
    public function setMaxLength(int $maxLength)
    {
        $this->__maxLength = $maxLength;
    }

   /**
    * @param array|int $minLength
    */ 
    public function setMinLength(int $minLength)
    {
        $this->__minLength = $minLength;
    }

   /**
    * @param Range
    */
    public function setRange(...$args)
    {
        if (count($args) == 2) {

            list(
                $minLength, 
                $maxLength

            ) = $args;

            $range = new Range($minLength, $maxLength);

        } elseif ($args[0] instanceof Range)
            $range = $args[0];

        //

        $this->__range = $range;
    }

   /**
    * @param array|int $size
    * @return bool
    */ 
    public function setSize($size)
    {
        return ($this->__length = $size);
    }

   /**
    * @see SplArray::unsetSize
    */
    public function unsetLength()
    {
        $this->unsetSize();
    }

   /**
    * 
    */
    public function unsetMaxLength()
    {
        $this->__maxLength = null;
    }

   /**
    * 
    */
    public function unsetMinLength()
    {
        $this->__minLength = null;
    }

   /**
    * 
    */
    public function unsetRange()
    {
        $this->__range = null;
    } 

   /**
    * 
    */ 
    public function unsetSize()
    {
        $this->__length = null;
    }
    
   /**
    * @see SplArray::validateSize
    */
    protected function validateLength(int $size)
    {
        return $this->validateSize($size);
    }

   /**
    * @param int $length
    * @return bool
    */ 
    protected function validateMaxLength(int $length)
    {
        return ($this->__maxLength) ? $this->__maxLength >= $length : true;
    }

   /**
    * @param int $length
    * @return bool
    */ 
    protected function validateMinLength(int $length)
    {
        return ($this->__minLength) ? $this->__minLength <= $length : true;
    }

   /**
    * @param Range $range
    * @return bool
    */ 
    protected function validateRange(Range $range)
    {
        // TODO
    }

   /**
    * @param int $size
    * @return bool
    */ 
    protected function validateSize(int $size)
    {
        return ($this->__length) ? $this->__length >= $size : true;
    }     
}