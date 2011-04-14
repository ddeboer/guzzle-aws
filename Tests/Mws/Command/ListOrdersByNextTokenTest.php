<?php


namespace Guzzle\Aws\Tests\Mws\Command;

use Guzzle\Tests\GuzzleTestCase;

/**
 * @covers Guzzle\Aws\Mws\Command\ListOrdersByNextToken
 */
class ListOrdersByNextTokenTest extends \Guzzle\Tests\GuzzleTest
{
    public function testListOrdersByNextToken()
    {
        $client = $this->getServiceBuilder()->get('test.mws');

        $this->setMockResponse($client, 'ListOrdersByNextTokenResponse');

        $command = $client->getCommand('list_orders_by_next_token')
                ->setNextToken('ASDF');

        $this->assertInstanceOf('Guzzle\Aws\Mws\Command\ListOrdersByNextToken', $command);

        $response = $client->execute($command);

        $this->assertInstanceOf('\SimpleXMLElement', $response);
    }
}