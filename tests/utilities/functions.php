<?php

function create()
{
    $args = func_get_args();

    return factory_maker('create', $args);
}

function make()
{
    $args = func_get_args();

    return factory_maker('make', $args);
}

function factory_maker($name, $args)
{
    $opts = array_filter($args, function ($item) {
        return !is_array($item);
    });

    $attrs = array_filter($args, function ($item) {
        return is_array($item);
    });

    $factory = call_user_func_array('factory', $opts);

    $attributes = count($attrs) ? array_shift($attrs) : [];

    return call_user_func_array([$factory, $name], [$attributes]);
}
