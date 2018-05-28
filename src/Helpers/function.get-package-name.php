<?php

/**
 * @param string|object
 * @return string
 */
function get_package_name($obj)
{
    $class = (is_string($obj)) ? $obj : get_class($obj);

    return (new Classinfo($class))->getPackageName();
}