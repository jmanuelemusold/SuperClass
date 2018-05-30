<?php

/**
 * @return string
 */
function get_callback()
{
    foreach (debug_backtrace()[1] as $name => $value)
        $$name = $value;

    ///

    $src = join("\n", 

        array_chunk(

            preg_split("/\n\r?/", 

                file_get_contents($file)), $line)[0]);


    $src = strrev(

        substr($src, 0, 

            strpos($src, ';', 

                strrpos($src, "$function(") )));

    ///

    preg_match("/\{|\;/", $src, $pos, PREG_OFFSET_CAPTURE);

    return trim( strrev( substr($src, 0, $pos[0][1] )));
}
