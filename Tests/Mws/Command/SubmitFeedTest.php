<?php

namespace Guzzle\Service\Aws\Tests\Mws\Command;

use Guzzle\Tests\GuzzleTestCase;
use Guzzle\Service\Aws\Mws\Type;

/**
 * @covers Guzzle\Service\Aws\Mws\Command\SubmitFeed
 * @author Harold Asbridge <harold@shoebacca.com>
 */
class SubmitFeedTest extends GuzzleTestCase
{
    public function testSubmitFeed()
    {
        $client = $this->getServiceBuilder()->getClient('test.mws');
        $this->setMockResponse($client, 'SubmitFeedResponse');

        $command = $client->getCommand('submit_feed')
            ->setFeedContent('asdf')
            ->setFeedType(Type\FeedType::PRODUCT_FEED)
            ->setPurgeAndReplace(true);
        $this->assertInstanceOf('Guzzle\Service\Aws\Mws\Command\SubmitFeed', $command);

        $response = $client->execute($command);
        $this->assertInstanceOf('\SimpleXMLElement', $response);
    }
}