<?php

namespace Guzzle\Aws\Tests\Mws\Model\Feed;

use Guzzle\Tests\GuzzleTestCase;
use Guzzle\Aws\Mws\MwsBuilder;

/**
 * @covers Guzzle\Aws\Mws\Model\Feed\OrderFulfillment
 * @covers Guzzle\Aws\Mws\Model\Feed\AbstractFeed
 */
class OrderFulfillmentTest extends GuzzleTestCase
{
    public function testOrderFulfillment()
    {
        $client = $this->getServiceBuilder()->get('test.mws');
        $feed = $client->getFeed('order_fulfillment');

        $this->assertInstanceOf('Guzzle\Aws\Mws\Model\Feed\OrderFulfillment', $feed);

        $feed->setPurgeAndReplace(false);
        $feed->addFulfillment('ASDF', '1234');

        $str = $feed->__toString();
    }
}