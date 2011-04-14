<?php
/**
 * @package Guzzle PHP <http://www.guzzlephp.org>
 * @license See the LICENSE file that was distributed with this source code.
 */

namespace Guzzle\Aws\Mws\Command;

/**
 * Returns orders based on the AmazonOrderIds that you specify.
 *
 * @author Harold Asbridge <harold@shoebacca.com>
 *
 * @guzzle amazon_order_id doc="Array of amazon order ids to get" required="true"
 */
class GetOrder extends AbstractMwsOrderCommand
{
    /**
     * {@inheritdoc}
     */
    protected $action = 'GetOrder';

    /**
     * {@inheritdoc}
     */
    protected $recordPath = '//Orders/Order';

    /**
     * Set amazon order ID(s)
     *
     * @param array $amazonOrderIds
     *
     * @return GetOrder
     */
    public function setAmazonOrderId(array $amazonOrderIds)
    {
        return $this->set('amazon_order_id', array(
            'Id' => $amazonOrderIds
        ));
    }
}