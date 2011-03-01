<?php

namespace Guzzle\Service\Aws\Tests\Mws\Command;

use Guzzle\Tests\GuzzleTestCase;
use Guzzle\Service\Aws\Mws\Type;

/**
 * @covers Guzzle\Service\Aws\Mws\Command\GetFeedSubmissionCount
 * @author Harold Asbridge <harold@shoebacca.com>
 */
class GetFeedSubmissionCountTest extends GuzzleTestCase
{
    public function testGetFeedSubmissionCount()
    {
        // Get client
        $client = $this->getServiceBuilder()->getClient('test.mws');

        $this->setMockResponse($client, 'GetFeedSubmissionCountResponse');

        $command = $client->getCommand('get_feed_submission_count')
            ->setFeedTypeList(array(
                Type\FeedType::PRODUCT_FEED
            ))
            ->setFeedProcessingStatusList(array(
                Type\FeedProcessingStatus::DONE
            ))
            ->setSubmittedFromDate(new \DateTime('2011-01-01'))
            ->setSubmittedToDate(new \DateTime());
        $this->assertInstanceOf('Guzzle\Service\Aws\Mws\Command\GetFeedSubmissionCount', $command);

        $response = $client->execute($command);
        $this->assertInstanceOf('\SimpleXMLElement', $response);
    }
}
