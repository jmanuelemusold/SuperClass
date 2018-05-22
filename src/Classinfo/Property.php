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
    protected $accesor = 'rw';

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
        preg_match("/^([^\$]+)\s\\$(\w+)\s?(.+)?$/", $args, $argv);

        @list($raw, $typeOf, $name, $desc) = $argv;

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
        foreach (self::splitMultipleTypeOf($str) as $i => $xyz)
            $typeOf[$i] = self::parseTypeOf($xyz);

        return (count($typeOf) > 1) ? $typeOf : $typeOf[0];
    }

   /**
    * @param string $typeOf
    * @return array|object
    */
    private static function splitMultipleTypeOf(string $str)
    {
        $args = []; $i = 0;

        foreach ([
            "/\<(.*?)\>/", 
            "/\[(.*?)\]/", 
            "/\((.*?)\)/"

        ] as $re) {

            if (preg_match_all($re, $str, $matches)) {

                foreach ($matches[0] as $xyz) {
                    $args[$i] = $xyz;

                    $str = str_replace($xyz, "{{$i}}", $str); $i++;
                }
            }
        }

        ///

        $var = [];

        foreach (preg_split("/\|/", $str) as $i => $xyz) {

            if (preg_match_all("/\{(\d+)\}/", $xyz, $grp)) {

                foreach ($grp[1] as $d)
                    $xyz = str_replace("{{$d}}", $args[$d], $str);
            }

            $var[$i] = $xyz;
        }

        return $var;
    }

   /**
    * @param string $str
    * @return array
    */ 
    private static function parseTypeOf(string $str)
    {
        foreach ([
            "/\<(.*?)\>/",
            "/\[(.*?)\]/",
            "/\((.*?)\)/"
        
        ] as $subset => $re) {

            if (!preg_match($re, $str, $argv)) continue;

            elseif ($subset == 0)
                list($keyOf, $arrayOf) = self::parseArrayOf($argv[1]);

            elseif ($subset == 1)
                $subTypeOf = self::parse($argv[1]);

            elseif ($subset == 2) {
                $sizeOf = self::parseSizeOf($argv[1]);
            }
        }

        ///

        if (preg_match("/^\[.+\]$/", $str))
            $str = "array$str";

        preg_match("/^([^\<\(\[]+)/", $str, $typeOf);

        switch ($typeOf[0]) {
            case 'array':
                $typeOf = 'SplArray';
            case 'bool':
            case 'boolean':
                $typeOf = 'SplBool';
                break;
            case 'chr':
            case 'char':
                $typeOf = 'SplChar'; 
                break;
            case 'float':
                $typeOf = 'SplFloat';
                break;
            case 'fn':
            case 'func':
                $instanceOf = '\Closure';
                break;
            case 'int':
            case 'integer':
                $typeOf = 'SplInt';
                break;
            case 'mixed':
                break;
            case 'null':
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
            case "re:":
            case "regex:":
                $instanceOf = 'Regex';
                break;
            case 'resource':
            case 'rs':
                $typeOf = 'SplResource';
                break;
            case 'str':
            case 'string':
                $typeOf = 'SplString';
                break;
            
            default:
                if (preg_match("/^\'.+\'$/", $str))
                    $cons = substr($str, 1, -1);

                elseif (is_numeric($str))
                    $cons = $str;
                else
                    $instanceOf = $typeOf[0];

                break;
        }

        ///

        $obj = (object)[];

        if (isset($cons))
            $obj->cons = $cons;

        elseif (isset($instanceOf))
            $obj->instanceOf = $instanceOf;

        elseif (isset($typeOf)) {
            $obj->typeOf = $typeOf;

            if (isset($sizeOf))
                $obj->sizeOf = $sizeOf;

            if (isset($subTypeOf))
                $obj->subTypeOf = $subTypeOf;

            if (isset($keyOf))
                $obj->keyof = $keyOf;

            if (isset($arrayOf))
                $obj->arrayOf = $arrayOf;
        }

        return $obj;
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
    * @return array
    */ 
    private static function parseSizeOf(string $str)
    {
        $re = "/^(\d+|\*)\-?(\d+|\*)?,?(\d+)?$/";

        foreach (preg_split("/\|/", $str) as $xyz) {

            preg_match($re, $xyz, $matches);

            @list(
                $raw,
                $min,
                $max,
                $dec

            ) = $matches;

            $obj = (object)[];

            if ($min == $max && $min != '*')
                $obj->length = $min;

            elseif ($min == '*' && $max)
                $obj->maxLength = $max;
            
            elseif ($min && $max == '*')
                $obj->minLength = $min;

            elseif ($min && !$max)
                $obj->maxLength = $min;

            elseif ($min && $max)
                $obj->range = array($min, $max);

            if ($dec) { 
                $flag = true; $obj->round = $dec;
            }

            $rules[] = $obj;
        }

        if (isset($flag)) 
            return (count($rules) > 1) ? $rules : $rules[0];
        
        else {

            $sizeOf = (object)[];

            foreach ($rules as $i) {

                foreach ($i as $key => $val) {
                    
                    if ($key == 'length' || $key == 'range')
                        $sizeOf->$key[] = $val;

                    elseif ($key == 'minLength' || $key == 'maxLength')
                        $sizeOf->$key = $val;

                }
            }

            if (@count($range = $sizeOf->range) == 1) 
                $sizeOf->range = $range[0];

            return $sizeOf;
        }
    }
}