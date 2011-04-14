<?php
/**
 * @package Guzzle PHP <http://www.guzzlephp.org>
 * @license See the LICENSE file that was distributed with this source code.
 */

namespace Guzzle\Aws\Mws\Type;

/**
 * Order status values
 *
 * @author Harold Asbridge <harold@shoebacca.com>
 * @codeCoverageIgnore
 */
class OrderStatus
{
    const PENDING = 'Pending';
    const UNSHIPPED = 'Unshipped';
    const PARTIALLY_SHIPPED = 'PartiallyShipped';
    const SHIPPED = 'Shipped';
    const CANCELED = 'Canceled';
    const UNFULFILLABLE = 'Unfulfillable';
}