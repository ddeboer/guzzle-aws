<?php
/**
 * @package Guzzle PHP <http://www.guzzlephp.org>
 * @license See the LICENSE file that was distributed with this source code.
 */

namespace Guzzle\Aws\Mws\Command;

/**
 * The GetServiceStatus operation returns the operational status of the
 * Orders API section of Amazon Marketplace Web Service. Status values
 * are GREEN, GREEN_I, YELLOW, and RED.
 *
 * @author Harold Asbridge <harold@shoebacca.com>
 * @codeCoverageIgnore
 */
class GetServiceStatus extends AbstractMwsOrderCommand
{
    /**
     * {@inheritdoc}
     */
    protected $action = 'GetServiceStatus';
}