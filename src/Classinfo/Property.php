<?php

namespace Classinfo;

/**
 * @package SuperClass
 */
class Property
{
   /**
    * @var string
    */
    protected $accessor = 'rw';

   /**
    * @var string
    */
    protected $description;

   /**
    * @var string
    */ 
    protected $name;

   /**
    * @var string
    */
    protected $type;

   /**
    * @return string
    */ 
    public function getDescription()
    {
        return $this->description;
    }

   /**
    * @param string $desc
    */
    private function setDescription($desc)
    {
        $this->description = $desc;
    }

   /**
    * @return string
    */ 
    public function getName($name)
    {
        return $this->name;
    }

   /**
    * @param string $name
    */
    private function setName($name)
    {
        $this->name = $name;
    }

   /**
    * @return array|object
    */
    private function getType()
    {
        return $this->type;
    }

   /**
    * @param array|object $typeOf
    */ 
    private function setType($type)
    {
        $this->type = $type;
    }

   /**
    * @param string $args
    */ 
    public function __construct($args)
    {
        $re = "/^([^\$]+)\s\\$(\w+)\s?(.+)?$/";

        preg_match($re, $args, $argv);

        @list(
            $raw, 
            $typeOf, 
            $name, 
            $desc,

        ) = $argv;

        $this->setName($name);
        $this->setDescription($desc);

        $this->setType(self::parse($typeOf));
    }

   /**
    * @param string $typeOf
    * @return array
    */
    private static function parse(string $str)
    {
        foreach (self::splitTypeOf($str) as $typeOf) {

            foreach ([
                "/\((.*?)\)/",
                "/\[(.*?)\]/",
                "/\<(.*?)\>/",
                "/:(.*)/"

            ] as $grp => $re) {

                if (!preg_match($re, $typeOf, $argv)) continue;

                if ($grp == 0)
                    $sizeOf = self::parseSizeOf($argv[1]);

                elseif ($grp == 1)
                    $subTypeOf = self::parseSubTypeOf($argv[1]);

                elseif ($grp == 2)
                    list($keyOf, $arrayOf) = self::parseArrayOf($argv[1]);

                else
                    $args = $argv[0];
            }
        }

        // return (count($typeOf) > 1) ? $typeOf : $typeOf[0];
    }

   /**
    * @param string $str
    * @return array 
    */ 
    private static function parseArrayOf(string $str)
    {
        // TODO
    } 

   /**
    * @param string $str
    * @return array|object
    */ 
    private static function parseSizeOf(string $str)
    {
        foreach (preg_split("/\|/", $str) as $args) {
            $obj = (object)[];

            if (preg_match("/,(\d+)$/", $args, $match)) {
                $obj->round = $match[1]; $round = true;

                $args = preg_replace("/,(\d+)$/", '', $args); 
            }

            ///
            $has = false;

            foreach ([
                "/^(\d+)$/"       => "maxLength",
                "/^(\d+)-(\1)$/"  => "length",
                "/^(\d+)-(\d+)$/" => "range",
                "/^(\d+)-\*$/"    => "minLength"
            
            ] as $re => $rule) {
                
                if (!$has && preg_match($re, $args, $match)) {
                    $has = true;

                    if ($rule == 'range') {
                        list(
                            $raw,
                            $min, 
                            $max

                        ) = $match;

                        $obj->range = array($min, $max);

                    } else
                        $obj->$rule = $match[1];
                }
            }

            $arr[] = $obj;
        }

        if (@$round)
            $sizeOf = (count($arr) > 1) ? $arr : $arr[0];

        else {
            $sizeOf = (object)[];

            foreach ($arr as $obj) {
                $key = array_keys((array) $obj)[0];
                
                $sizeOf->$key[] = $obj->$key;
            }
        
            foreach ($sizeOf as $key => $obj) {
                
                if (count($obj) == 1) $sizeOf->$key = $obj[0];
            }
        }
        
        return $sizeOf;
    }

   /**
    * @param string $str
    * @return array|object
    */ 
    private static function parseSubTypeOf(string $str)
    {
        // TODO
    } 

   /**
    * @param string $str
    * @return array|object
    */
    private static function splitTypeOf(string $str)
    {
        $args = []; $i = 0;

        foreach ([
            "/\<(.*?)\>/", 
            "/\[(.*?)\]/", 
            "/\((.*?)\)/",

        ] as $re) {

            if (preg_match_all($re, $str, $matches)) {

                foreach ($matches[0] as $x) {
                    $args[$i] = $x;

                    $str = str_replace($x, "{{$i}}", $str); $i++;
                }
            }
        }
        
        /// 

        $var = [];

        foreach (preg_split("/\|/", $str) as $str) {

            for ($i = 0; $i < count($args); $i++)
                $str = str_replace("{{$i}}", $args[$i], $str);

            $var[] = $str;
        }
        
        return $var;
    }
}