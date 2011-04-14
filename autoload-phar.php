<?php
/**
 * @package Guzzle PHP <http://www.guzzlephp.org>
 * @license See the LICENSE file that was distributed with this source code.
 */

spl_autoload_register(function($class) {
    if (0 === strpos($class, 'Guzzle\\Service\\Aws')) {
        $path = 'phar://' . __FILE__ . DIRECTORY_SEPARATOR;
        if ('\\' != DIRECTORY_SEPARATOR) {
            $class = str_replace('\\', DIRECTORY_SEPARATOR, $class);
        }
        $path .= $class . '.php';
        if (file_exists($path)) {
            require $path;
        }
    }
});

__HALT_COMPILER();