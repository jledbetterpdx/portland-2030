<?php

function any_in_array($values = array(), $array = array())
{
    // Loop through each value
    foreach ($values as $value)
    {
        // Return true if found
        if (in_array((string)$value, $array, true)) return true;
    }
    // Not found, return false
    return false;
}

function is_god($array = array())
{
    // Check for god mode
    return (in_array((string)GOD_MODE, $array, true));
}

function in_array_or_god($value, $array = array())
{
    // Check for god mode first, then value provided
    if (in_array((string)GOD_MODE, $array, true) || in_array((string)$value, $array, true)) return true;
    // Not found, return false
    return false;
}

function any_in_array_or_god($values = array(), $array = array())
{
    // Check for god mode first
    if (in_array((string)GOD_MODE, $array, true)) return true;
    // Loop through each value
    foreach ($values as $value)
    {
        // Return true if found
        if (in_array((string)$value, $array, true)) return true;
    }
    // Not found, return false
    return false;
}

