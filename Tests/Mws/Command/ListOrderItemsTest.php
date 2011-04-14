<?php

namespace Guzzle\Aws\Test\Mws\Command;

use Guzzle\Tests\GuzzleTestCase;

/**
 * @covers Guzzle\Aws\Mws\Command\ListOrderItems
 */
class ListOrderItemsTest extends GuzzleTestCase
{
    public function testListOrderItems()
    {
        $client = $this->getServiceBuilder()->get('test.mws');

        $this->setMockResponse($client, 'ListOrderItemsResponse');

        $command = $client->getCommand('list_order_items')
            ->setAmazonOrderId('104-1917270-6910603');


        $this->assertInstanceOf('Guzzle\Aws\Mws\Command\ListOrderItems', $command);

        $response = $client->execute($command);
        $this->assertInstanceOf('Guzzle\Aws\Mws\Model\ResultIterator', $response);
    }
}