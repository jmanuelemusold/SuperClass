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
        $str = trim($str);

        foreach (self::splitTypeOf($str) as $str) {
            $obj = (object)[];

            foreach ([
                "/\((.*?)\)/",
                "/\[(.*?)\]/",
                "/\<(.*?)\>/",
                "/:(.*)/"

            ] as $grp => $re) {

                if (!preg_match($re, $str, $argv)) continue;

                if ($grp == 0)
                    $sizeOf = self::parseSizeOf($argv[1]);

                elseif ($grp == 1)
                    $subTypeOf = self::parse($argv[1]);

                elseif ($grp == 2)
                    list($arrayOf, $keyOf) = self::parseArrayOf($argv[1]);

                else
                    $args = $argv[0];
            }

            if (preg_match("/^\[/", $str)) 
                $str = "arr$str";
            
            ///

            preg_match("/^([^\<\(\[\:]+)/", $str, $is);

            switch ($is[1]) {
                case 'arr':
                case 'array':
                    $typeOf = 'SplArray';
                    break;
                case 'bool':
                case 'boolean':
                    $typeOf = 'SplBool';
                    break;
                case 'chr':
                case 'char':
                    $typeOf = 'SplChar';
                    break;
                case 'enum':
                    $typeOf = 'SplEnum';
                    break;
                case 'float':
                    $typeOf = 'SplFloat';
                    break;
                case 'fn':
                case 'func':
                case 'function':
                    $instanceOf = '\Closure';
                    break;
                case 'int':
                case 'integer':
                    $typeOf = 'SplInt';
                    break;
                case 'mixed':
                    $typeOf = '*';
                case 'NULL':
                    $typeOf = 'SplNull';
                    break;
                case 'num':
                case 'number':
                    $typeOf = 'SplNumber';
                    break;
                case 'obj':
                case 'object':
                    $typeOf = 'SplObject';
                    break;
                case 're':
                case 'regex':
                    $instanceOf = 'Regex';
                    break;
                case 'rs':
                case 'resource':
                    $typeOf = 'SplResource';
                    break;
                case 'str':
                case 'string':
                    $typeOf = 'SplString';
                    break;

                default:
                    
                    if (preg_match("/^[\'|\"](.+)[\'|\"]$/", $is[1], $str))
                        $cons[] = $str[1];

                    elseif (is_numeric($is[1]))
                        $cons[] = $is[1];

                    else
                        $instanceOf = $is[1];

                    break;
            }

            foreach([
                'args',
                'arrayOf', 
                'instanceOf', 
                'keyOf',
                'sizeOf',
                'subTypeOf',
                'typeOf'
            
            ] as $key) {

                if (isset($$key)) {
                    $obj->$key = $$key;

                    unset($$key);
                }
            }

            if (array_keys((array) $obj))
                $arr[] = $obj;
        }

        if (@$cons) $arr[]->cons = $cons;

        return (count($arr) > 1) ? $arr : $arr[0];
    }

   /**
    * @param string $str
    * @return array 
    */ 
    private static function parseArrayOf(string $str)
    {
        foreach (self::splitTypeOf($str) as $typeOf)
            $keyOf[] = self::parse($typeOf);

        return array(array_pop($keyOf), (count($keyOf) > 1) ? $keyOf : $keyOf[0]);
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
                "/^(\d+)$/"       => 'maxLength',
                "/^(\d+)-(\1)$/"  => 'length',
                "/^(\d+)-(\d+)$/" => 'range',
                "/^(\d+)-\*$/"    => 'minLength'
            
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

        foreach (preg_split("/\||\,/", $str) as $str) {

            for ($i = 0; $i < count($args); $i++)
                $str = str_replace("{{$i}}", $args[$i], $str);

            $var[] = $str;
        }
        
        return $var;
    }
}