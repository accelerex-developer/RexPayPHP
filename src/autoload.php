<?php

/**
 * Rexpay Autoloader
 * For use when library is being used without composer
 */

$rexpay_autoloader = function ($class_name) {
    if (strpos($class_name, 'Pils36\Rexpay')===0) {
        $file = dirname(__FILE__) . DIRECTORY_SEPARATOR;
        $file .= str_replace([ 'Pils36\\', '\\' ], ['', DIRECTORY_SEPARATOR ], $class_name) . '.php';
        include_once $file;
    }
};

spl_autoload_register($rexpay_autoloader);

return $rexpay_autoloader;
