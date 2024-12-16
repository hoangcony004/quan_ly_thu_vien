<?php

namespace App\Helpers;

class Helper
{
    public static function isActiveRoute($routeName)
    {
        return request()->routeIs($routeName) ? 'active' : '';
    }
    
    public static function isActiveURL($url)
    {
        return request()->is($url) ? 'active' : '';
    }

    public static function isActiveGroup(array $routeNames)
{
    foreach ($routeNames as $routeName) {
        if (request()->routeIs($routeName)) {
            return 'active';
        }
    }
    return '';
}

    
}
