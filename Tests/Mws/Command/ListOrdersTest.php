<?php

namespace Guzzle\Service\Aws\Tests\Mws\Command;

use Guzzle\Tests\GuzzleTestCase;
use Guzzle\Service\Aws\Mws\Type;

/**
 * @covers Guzzle\Service\Aws\Mws\Command\ListOrders
 */
class ListOrdersTest extends GuzzleTestCase
{
    public function testListOrders()
    {
        $client = $this->getServiceBuilder()->getClient('test.mws');

        $this->setMockResponse($client, 'GetOrderResponse');

        $command = $client->getCommand('list_orders')
            ->setCreatedAfter(new \DateTime('-24 hours'))
            ->setCreatedBefore(new \DateTime('-1 hour'))
            ->setLastUpdatedAfter(new \DateTime('-24 hours'))
            ->setLastUpdatedBefore(new \DateTime())
            ->setOrderStatus(array(
                Type\OrderStatus::UNSHIPPED,
                Type\OrderStatus::PARTIALLY_SHIPPED
            ))
            ->setMarketplaceId(array('ASDF'))
            ->setFulfillmentChannel(array('ASDF'))
            ->setBuyerEmail('user@example.org')
            ->setSellerOrderId(1234)
            ->setMaxResultsPerPage(1);

        $this->assertInstanceOf('Guzzle\Service\Aws\Mws\Command\ListOrders', $command);

        $response = $client->execute($command);
        $this->assertInstanceOf('Guzzle\Service\Aws\Mws\Model\ResultIterator', $response);
    }
}