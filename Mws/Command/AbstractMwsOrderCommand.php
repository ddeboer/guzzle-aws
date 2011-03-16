<?php
/**
 * @package Guzzle PHP <http://www.guzzlephp.org>
 * @license See the LICENSE file that was distributed with this source code.
 */

namespace Guzzle\Service\Aws\Mws\Command;

/**
 * Base class order MWS Order API commands
 *
 * Amazon didn't follow the same standards as the other MWS commands,
 * and this base class addresses that.
 *
 * @author Harold Asbridge <harold @shoebacca.com>
 */
class AbstractMwsOrderCommand extends AbstractMwsCommand
{
    /**
     * Build the HTTP request
     */
    protected function build()
    {
        parent::build();
        // Change path
        $this->getRequest()->setPath('/Orders/2011-01-01');

        // Copy Merchant parameter to SellerId, because Amazon is stupid and can't even follow their own standards
        $this->getRequest()->getQuery()->set('SellerId', $this->getRequest()->getQuery()->get('Merchant'));
    }
}