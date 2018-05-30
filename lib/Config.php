<?php

/**
 * @package SuperClass
 */
trait Config
{
   /**
    * @var array<string, mixed>
    */ 
    private static $__config;

   /**
    * @return mixed
    */
    protected static function config(...$args)
    {
        $cfg = self::$__config;

        if (!$cfg) {

            $PATH = get_source_file(__CLASS__);

            do {
                $PATH = dirname($PATH);

                if (in_array(basename($PATH), [
                    'app',
                    'examples',
                    'lib',
                    'src',
                    'vendor'

                ])) break;

            } while ($PATH != dirname($PATH));

            $PKG = strtolower(get_package_name(__CLASS__));

            foreach([
                "{$PATH}/../config/{$PKG}.php",
                "{$PATH}/../config/app.php",
                "{$PATH}/../config/database.php",
                "{$PATH}/../config.php",
                "{$PATH}/../config.example.php"

            ] as $__FILE__) 

                if (file_exists($__FILE__)) {
                    $cfg = require $__FILE__;

                    break;
                }
            
            if (!$cfg) throw new FileNotFoundException();

            self::$__config = $cfg;
        }

        if (!$args) return $cfg;

        ///

        foreach ($args as $key)
            eval('$vars[] = @$cfg' . preg_replace("/(\w+)(\.|$)/", "[$1]", $key) . ';');

        return (@count($vars) == 1) ? $vars[0] : $vars;
    }
}