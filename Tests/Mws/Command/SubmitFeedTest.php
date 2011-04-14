<?php

namespace Guzzle\Aws\Tests\Mws\Command;

use Guzzle\Tests\GuzzleTestCase;
use Guzzle\Aws\Mws\Type;

/**
 * @covers Guzzle\Aws\Mws\Command\SubmitFeed
 * @author Harold Asbridge <harold@shoebacca.com>
 */
class SubmitFeedTest extends GuzzleTestCase
{
    public function testSubmitFeed()
    {
        $client = $this->getServiceBuilder()->get('test.mws');
        $this->setMockResponse($client, 'SubmitFeedResponse');

        $command = $client->getCommand('submit_feed')
            ->setFeedContent('asdf')
            ->setFeedType(Type\FeedType::PRODUCT_FEED)
            ->setPurgeAndReplace(true);
        $this->assertInstanceOf('Guzzle\Aws\Mws\Command\SubmitFeed', $command);

        $response = $client->execute($command);
        $this->assertInstanceOf('\SimpleXMLElement', $response);
    }
}