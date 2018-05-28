<?php

/**
 * @param string|object
 * @return string
 */
function get_source_file($obj)
{
    $class = (is_string($obj)) ? $obj : get_class($obj);

    return (new Classinfo($class))->getFileName();
}