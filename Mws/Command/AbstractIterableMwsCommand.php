<?php
/**
 * @package Guzzle PHP <http://www.guzzlephp.org>
 * @license See the LICENSE file that was distributed with this source code.
 */

namespace Guzzle\Aws\Mws\Command;

/**
 * Abstract class for commands with iterable results to extend.
 *
 * @author Harold Asbridge <harold@shoebacca.com>
 * @codeCoverageIgnore
 */
abstract class AbstractIterableMwsCommand extends AbstractMwsCommand
{
    /**
     * @var string Result node name
     */
    protected $resultNode;
}