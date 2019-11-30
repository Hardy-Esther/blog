<?php

function route_class()
{
    return str_replace('.', '-', Route::currentRouteName());
}

function category_nav_active($category_id)
{
    return active_class((if_route('categories.show') && if_route_param('category', $category_id)));
}

function tag_class($num)
{
    $class = ['primary', 'info', 'success', 'danger', 'warning', 'info', 'dark'];
    return $class[$num % count($class)];
}