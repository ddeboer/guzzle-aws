<?php
/**
 * @package Guzzle PHP <http://www.guzzlephp.org>
 * @license See the LICENSE file that was distributed with this source code.
 */

namespace Guzzle\Aws\Mws\Command;

/**
 * Iterable order command base class
 *
 * @author Harold Asbridge <harold@shoebacca.com>
 * @codeCoverageIgnore
 */
class AbstractIterableMwsOrderCommand extends AbstractMwsOrderCommand
{
    /**
     * @var string Result node name
     */
    protected $resultNode;
}