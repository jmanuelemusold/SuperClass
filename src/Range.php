<?php

/**
 * @package SuperClass
 */
class Range
{
   /**
    * @var int
    */ 
    protected $maxLength;

   /**
    * @var int
    */ 
    protected $minLength;

   /**
    * @return int
    */ 
    public function getMaxLength()
    {
        return $this->maxLength;
    }

   /**
    * @param int $maxLength
    */ 
    public function setMaxLength(int $maxLength)
    {
        $this->maxLength = $maxLength;
    }

   /**
    * @return int
    */ 
    public function getMinLength()
    {
        return $this->minLength;
    }

   /**
    * @param int $minLength
    */ 
    public function setMinLength(int $minLength)
    {
        $this->minLength = $minLength;
    }

   /**
    * @param int $minLength
    * @param int $maxLength
    */
    public function __construct(int $minLength = null, int $maxLength = null)
    {
        if ($minLength && $maxLength) 
            $this->setRange($minLength, $maxLength);
    }

   /**
    * @param int $minLength
    * @param int $maxLength
    */
    public function setRange(int $minLength, int $maxLength)
    {
        $this->setMinLength($minLength);

        $this->setMaxLength($maxLength);
    }
}