<?php

namespace Guzzle\Service\Aws\Tests\Mws\Model\Feed;

use Guzzle\Tests\GuzzleTestCase;
use Guzzle\Service\Aws\Mws\MwsBuilder;

/**
 * @covers Guzzle\Service\Aws\Mws\Model\Feed\OrderFulfillment
 * @covers Guzzle\Service\Aws\Mws\Model\Feed\AbstractFeed
 */
class OrderFulfillmentTest extends GuzzleTestCase
{
    public function testOrderFulfillment()
    {
        $client = $this->getServiceBuilder()->get('test.mws');
        $feed = $client->getFeed('order_fulfillment');

        $this->assertInstanceOf('Guzzle\Service\Aws\Mws\Model\Feed\OrderFulfillment', $feed);

        $feed->setPurgeAndReplace(false);
        $feed->addFulfillment('ASDF', '1234');

        $str = $feed->__toString();
    }
}