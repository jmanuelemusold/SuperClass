<?php

/**
 * @package SuperClass
 */
class Classinfo
{
   /**
    * @var string
    */
    protected $class;

   /**
    * @var array
    */
    protected $tags;

   /**
    * @return string
    */ 
    public function getClassName()
    {
        return $this->class;
    }

   /**
    * @param string $class
    */
    private function setClassName(string $class)
    {
        $this->class = $class;
    }

   /**
    * @return string
    */
    public function getDocComment()
    {
        return $this->refl()->getDocComment();
    }

   /**
    * @return string
    */ 
    public function getFileName()
    {
        return $this->refl()->getFileName();
    }

   /**
    * @return \ReflectionClass
    */
    private function refl()
    {
        return new ReflectionClass($this->getClassName());
    }

   /**
    * @param string $class
    */ 
    public function __construct(string $class)
    {
        $this->setClassName($class);

        preg_match_all("/@([\w\-]+)\s(.+)/", $this->getDocComment(), $matches, PREG_SET_ORDER);

        foreach ($matches as $tag) {
            list($raw, $tag, $args) = $tag;

            switch ($tag) {
                case 'property':
                    $obj = new Classinfo\Property($args); break;

                case 'property-read':
                    $obj = new Classinfo\PropertyRead($args); break;

                case 'property-write':
                    $obj = new Classinfo\PropertyWrite($args); break;

                default:
                    $obj = $args;
            }

            $this->addTag($obj);
        }
    }

   /**
    * @param mixed $tag
    */
    private function addTag($tag)
    {
        $this->tags[] = $tag;
    }
}