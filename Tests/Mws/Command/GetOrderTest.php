<?php

namespace Guzzle\Aws\Tests\Mws\Command;

use Guzzle\Tests\GuzzleTestCase;

/**
 * @covers Guzzle\Aws\Mws\Command\GetOrder
 * @covers Guzzle\Aws\Mws\Command\AbstractMwsOrderCommand
 */
class GetOrderTest extends GuzzleTestCase
{
    public function testGetOrder()
    {
        $client = $this->getServiceBuilder()->get('test.mws');

        $this->setMockResponse($client, 'GetOrderResponse');

        $command = $client->getCommand('get_order')
            ->setAmazonOrderId(array(
                'ASDF'
            ));

        $this->assertInstanceOf('Guzzle\Aws\Mws\Command\GetOrder', $command);

        $response = $client->execute($command);

        $this->assertInternalType('array', $response);
        $this->assertInstanceOf('\SimpleXMLELEment', $response[0]);

    }
}