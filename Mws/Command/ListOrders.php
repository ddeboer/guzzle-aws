<?php
/**
 * @package Guzzle PHP <http://www.guzzlephp.org>
 * @license See the LICENSE file that was distributed with this source code.
 */

namespace Guzzle\Aws\Mws\Command;

/**
 * The ListOrders operation returns a list of orders created or updated during a time frame that you specify. You
 * define that time frame using the CreatedAfter parameter or the LastUpdatedAfter parameter. You must use one
 * of these parameters, but not both. You can also apply a range of filtering criteria to narrow the list of orders that
 * is returned. The ListOrders operation includes order information for each order returned, including
 * AmazonOrderId, OrderStatus, FulfillmentChannel, and LastUpdateDate.
 *
 * Note:
 * The shipping address is returned with an order in the following cases:
 * - The order status is Shipped
 * - The order status is PartiallyShipped, and the order is fulfilled by Amazon
 * - The order status is Unshipped, and the order is fulfilled by the seller
 * In all other cases the shipping address is not returned with an order.
 *
 * @author Harold Asbridge <harold@shoebacca.com>
 *
 * @guzzle created_after doc="Created after date"
 * @guzzle created_before doc="Created before date"
 * @guzzle last_updated_after doc="Last updated after"
 * @guzzle last_updated_before doc="Last updated before"
 * @guzzle order_status doc="Order status"
 * @guzzle marketplace_id doc="A list of marketplace ids"
 * @guzzle fulfillment_channel doc="Fulfillemnt channel"
 * @guzzle buyer_email doc="Buyer email address"
 * @guzzle seller_order_id doc="Seller order ID"
 * @guzzle max_results_per_page doc="Maximum number of results per page"
 */
class ListOrders extends AbstractIterableMwsOrderCommand
{
    /**
     * {@inheritdoc}
     */
    protected $action = 'ListOrders';

    /**
     * {@inheritdoc}
     */
    protected $recordPath = '//Orders/Order';

    /**
     * Prepare request
     */
    protected function build()
    {
        // Default to the current marketplace
        parent::build();
        $marketplace = $this->getRequest()->getQuery()->get('Marketplace');
        $this->setMarketplaceId(array($marketplace));
        parent::build();
    }

    /**
     * Set created after date
     *
     * @param \DateTime $createdAfter
     *
     * @return ListOrders
     */
    public function setCreatedAfter(\DateTime $createdAfter)
    {
        return $this->set('created_after', $createdAfter);
    }

    /**
     * Set created before date
     *
     * @param \DateTime $createdBefore
     *
     * @return ListOrders
     */
    public function setCreatedBefore(\DateTime $createdBefore)
    {
        return $this->set('created_before', $createdBefore);
    }

    /**
     * Set last updated after date
     *
     * @param \DateTime $lastUpdatedAfter
     *
     * @return ListOrders
     */
    public function setLastUpdatedAfter(\DateTime $lastUpdatedAfter)
    {
        return $this->set('last_updated_after', $lastUpdatedAfter);
    }

    /**
     * Set last updated before date
     *
     * @param \DateTime $lastUpdatedBefore
     *
     * @return ListOrders
     */
    public function setLastUpdatedBefore(\DateTime $lastUpdatedBefore)
    {
        return $this->set('last_updated_before', $lastUpdatedBefore);
    }

    /**
     * Set order status filter
     *
     * @param string $orderStatuses
     *
     * @return ListOrders
     */
    public function setOrderStatus(array $orderStatuses)
    {
        return $this->set('order_status', array(
            'Status' => $orderStatuses
        ));
    }

    /**
     * Set marketplace IDs
     *
     * @param array $marketplaceIds
     *
     * @return ListOrders
     */
    public function setMarketplaceId(array $marketplaceIds)
    {
        return $this->set('marketplace_id', array(
            'Id' => $marketplaceIds
        ));
    }

    /**
     * Set fulfillment channels
     *
     * @param array $fulfillmentChannels
     *
     * @return ListOrders
     */
    public function SetFulfillmentChannel(array $fulfillmentChannels)
    {
        return $this->set('fulfillment_channel', array(
            'Channel' => $fulfillmentChannels
        ));
    }

    /**
     * Set buyer email address
     *
     * @param string $buyerEmail
     *
     * @return ListOrders
     */
    public function setBuyerEmail($buyerEmail)
    {
        return $this->set('buyer_email', $buyerEmail);
    }

    /**
     * Set seller order ID
     *
     * @param string $sellerOrderId
     *
     * @return ListOrders
     */
    public function setSellerOrderId($sellerOrderId)
    {
        return $this->set('seller_order_id', $sellerOrderId);
    }

    /**
     * Set max results per page (1-100)
     *
     * @param int $maxResultsPerPage
     *
     * @return ListOrders
     */
    public function setMaxResultsPerPage($maxResultsPerPage)
    {
        return $this->set('max_results_per_page', $maxResultsPerPage);
    }
}