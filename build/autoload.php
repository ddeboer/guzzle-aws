<?php
/**
 * @package Guzzle PHP <http://www.guzzlephp.org>
 * @license See the LICENSE file that was distributed with this source code.
 */

spl_autoload_register(function($class) {
    if (0 === strpos($class, 'Guzzle\\Service\\Aws\\')) {
        $class = str_replace('Guzzle\\Service\\Aws\\', '', $class);
        if ('\\' != DIRECTORY_SEPARATOR) {
            $class = 'phar://' . __FILE__ . DIRECTORY_SEPARATOR . str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.php';
        } else {
            $class = 'phar://' . __FILE__ . DIRECTORY_SEPARATOR . $class . '.php';
        }
        if (file_exists($class)) {
            require $class;
        }
    }
});

__HALT_COMPILER();