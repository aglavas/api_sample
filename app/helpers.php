<?php

/**
 * Recursive multidimensional array filtering
 *
 * @param array $array
 * @param callable|null $callback
 * @return array
 */
function array_filter_recursive(array $array, callable $callback = null)
{
    $array = is_callable($callback) ? array_filter($array, $callback) : array_filter($array);
    foreach ($array as &$value) {
        if (is_array($value)) {
            $value = call_user_func(__FUNCTION__, $value, $callback);
        }
    }

    return $array;
}
