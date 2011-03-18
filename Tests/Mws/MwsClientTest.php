<?php

namespace Guzzle\Service\Aws\Tests\Mws;

use Guzzle\Tests\GuzzleTestCase;
use Guzzle\Service\Aws\Mws\MwsClient;

/**
 * @covers Guzzle\Service\Aws\Mws\MwsClient
 * @covers Guzzle\Service\Aws\AbstractClient
 *
 * @author Harold Asbridge <harold@shoebacca.com>
 * @author Michael Dowling <michael@guzzlephp.org>
 */
class MwsClientTest extends GuzzleTestCase
{
    public function testMwsClient()
    {
        $client = MwsClient::factory(array(
            'merchant_id' => 'ASDF',
            'marketplace_id' => 'ASDF',
            'access_key' => 'ASDF',
            'secret_key' => 'ASDF',
            'application_name' => 'GuzzleTest',
            'application_version' => '0.1'
        ));

        $feed = $client->getFeed('order_fulfillment');
        $this->assertInstanceOf('Guzzle\Service\Aws\Mws\Model\Feed\OrderFulfillment', $feed);
    }
}