<?php
/**
 * @package Guzzle PHP <http://www.guzzlephp.org>
 * @license See the LICENSE file that was distributed with this source code.
 */

namespace Guzzle\Aws\Mws\Command;

/**
 * The ListOrderItems operation returns order item information for an
 * AmazonOrderId that you specify. The order item information includes
 * Title, ASIN, SellerSKU, ItemPrice, ShippingPrice, as well as tax
 * and promotion information. You can retrieve order item information
 * by first using the ListOrders operation to find orders created or
 * updated during a time frame that you specify. An AmazonOrderId is
 * included with each order that is returned. You can then use these
 * AmazonOrderIds with the ListOrderItems operation to get detailed
 * order item information for each order.
 *
 * @author Harold Asbridge <harold@shoebacca.com>
 *
 * @guzzle amazon_order_id doc="Amazon Order ID" required="true"
 */
class ListOrderItems extends AbstractIterableMwsOrderCommand
{
    /**
     * {@inheritdoc}
     */
    protected $action = 'ListOrderItems';

    /**
     * {@inheritdoc}
     */
    protected $recordPath = '//OrderItems/OrderItem';

    /**
     * Set Amazon Order ID
     *
     * @param string $amazonOrderId
     *
     * @return ListOrderItems
     */
    public function setAmazonOrderId($amazonOrderId)
    {
        return $this->set('amazon_order_id', $amazonOrderId);
    }
}