<?php

use Classinfo\Property;
use Classinfo\PropertyRead;
use Classinfo\PropertyWrite;


class Classinfo
{
   /**
    * @var string
    */
    protected $class;

   /**
    * @var obj
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
    * @return string
    */
    public function getNamespaceName()
    {
        return $this->refl()->getNamespaceName();
    }

   /**
    * @return string
    */ 
    public function getPackageName()
    {
        if ($pkg = $this->getTagByName("package"))
            return $pkg;

        $ns = preg_split("/\\//", $this->getNamespaceName());

        return $ns[0];
    }

   /**
    * @return array
    */
    public function getProperties()
    {
        return $this->getTagByName('property');
    }

   /**
    * @param string $name
    * @return \Classinfo\Property
    */
    public function getProperty(string $name)
    {
        return $this->getProperties()->{$name};
    }

   /**
    * @param string $name
    * @return object
    */ 
    public function getTagByName(string $name)
    {
        if (!$this->tags) 
            $this->parseDocComment();

        return @$this->tags[$name];
    }

   /**
    * @param array $names
    * @return array
    */ 
    public function getTagsByName(...$names)
    {
        foreach ($names as $name)
            $tags[] = $this->getTagByName($name);

        return @$tags;
    }

   /**
    * @param string $class
    */ 
    public function __construct(string $class)
    {
        $this->setClassName($class);
    }

   /**
    * 
    */ 
    protected function parseDocComment()
    {
        $comm = $this->getDocComment();

        foreach ($this->parse($comm) as $match) {
            
            list(
                $raw, 
                $name, 
                $args

            ) = $match;

            switch ($name) {
                case 'property':
                    $tag = new Property($args);
                    break;

                case 'property-read':
                    $tag = new PropertyRead($args);
                    break;

                case 'property-write':
                    $tag = new PropertyWrite($args);
                    break;

                default:
                    $tag = trim($args);
                    break;
            }

            if ($tag instanceof Property)
                $this->addProperty($tag->getName(), $tag);
            else
                $this->addTag($name, $tag);
        }
    }

   /**
    * @param string $comm
    * @return array
    */ 
    protected function parse(string $comm)
    {
        preg_match_all("/@([\w\-]+)\s(.+)/", $comm, $matches, PREG_SET_ORDER);

        return $matches;
    }

   /**
    * @param string $name
    * @param object $prop
    */ 
    protected function addProperty(string $name, $prop)
    {
        @$this->tags['property']->$name = $prop;
    }

   /**
    * @param string $tag
    * @param mixed $obj
    */
    private function addTag(string $name, $obj)
    {
        if ($tag = $this->tags[$name])
            
            if (is_array($tag))
                $tag[] = $obj;
            else
                $tag = array($tag, $obj);
        
        else
            $tag = $obj;

        $this->tags[$name] = $tag;
    } 

   /**
    * @see Classinfo::getProperties
    */ 
    public function properties()
    {
        return $this->getProperties();
    }

   /**
    * @see Classinfo::getProperty
    */
    public function property(string $name)
    {
        return $this->getProperty($name);
    }

   /**
    * @return \ReflectionClass
    */
    private function refl()
    {
        return new ReflectionClass($this->getClassName());
    }

   /**
    * @return \Classinfo
    */
    public function withTags()
    {
        $this->parseDocComment(); 

        return $this;
    }
}