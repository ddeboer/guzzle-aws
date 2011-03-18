<?php

namespace Guzzle\Service\Aws\Tests\Mws\Command;

use Guzzle\Tests\GuzzleTestCase;

/**
 * @covers Guzzle\Service\Aws\Mws\Command\ListOrderItemsByNextToken
 */
class ListOrderItemsByNextTokenText extends GuzzleTestCase
{
    public function testListOrderItems()
    {
        $client = $this->getServiceBuilder()->get('test.mws');

        $this->setMockResponse($client, 'ListOrderItemsByNextTokenResponse');

        $command = $client->getCommand('list_order_items_by_next_token')
            ->setNextToken('9b22V5soX9QD2s1QD6a1Fdz+0b6t4r6aM48r5nOh7ZShnhrZ/iJdthB9cVK4t28tH9zNuAcSbkidKlWBD967pqgp7Sg5ebRGsLO7dcanbD/4ETTVITqzJur6OQDEMHv5hympqnq1M9ISolhZsX/hprCDhtiLmbPVWyNWqpsyNMUn5je6h1OoZe8ULEe1StQY');

        $this->assertInstanceOf('Guzzle\Service\Aws\Mws\Command\ListOrderItemsByNextToken', $command);

        $response = $client->execute($command);
        $this->assertInternalType('array', $response);
        $this->assertInstanceOf('\SimpleXMLElement', $response[0]);
    }
}