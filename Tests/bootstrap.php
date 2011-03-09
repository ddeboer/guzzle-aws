<?php

require_once $_SERVER['GUZZLE'] . '/library/vendor/Symfony/Component/ClassLoader/UniversalClassLoader.php';

use Symfony\Component\ClassLoader\UniversalClassLoader;

$loader = new UniversalClassLoader();
$loader->registerNamespaces(array(
    'Guzzle' => $_SERVER['GUZZLE'] . '/library',
    'Guzzle\\Tests' => $_SERVER['GUZZLE'] . '/tests'
));
$loader->register();

spl_autoload_register(function($class) {
    if (0 === strpos($class, 'Guzzle\\Service\\Aws\\')) {
        $path = implode('/', array_slice(explode('\\', $class), 3)) . '.php';
        require_once __DIR__ . '/../' . $path;
        return true;
    }
});