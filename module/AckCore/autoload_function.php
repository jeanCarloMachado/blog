<?php
//should return a PHP callback that can be passed to spl_autoload_register()
return function ($class) {
    static $map;
    if (!$map) {
        $map = include __DIR__ . '/autoload_classmap.php';
    }

    if (!isset($map[$class])) {
        return false;
    }
    return include $map[$class];
};
