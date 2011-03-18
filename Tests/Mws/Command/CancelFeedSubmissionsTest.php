<?php

namespace Guzzle\Service\Aws\Tests\Mws\Command;

use Guzzle\Tests\GuzzleTestCase;
use Guzzle\Service\Aws\Mws\Type;

/**
 * @covers Guzzle\Service\Aws\Mws\Command\CancelFeedSubmissions
 * @author Harold Asbridge <harold@shoebacca.com>
 */
class CancelFeedSubmissionsTest extends GuzzleTestCase
{
    public function testCancelFeedSubmissions()
    {
        $client = $this->getServiceBuilder()->get('test.mws');

        $this->setMockResponse($client, 'CancelFeedSubmissionsResponse');

        $command = $client->getCommand('cancel_feed_submissions')
            ->setFeedSubmissionIdList(array(
                12345
            ))
            ->setFeedTypeList(array(
                Type\FeedType::PRODUCT_FEED
            ))
            ->setSubmittedFromDate(new \DateTime('2011-01-01'))
            ->setSubmittedToDate(new \DateTime());
        $this->assertInstanceOf('Guzzle\Service\Aws\Mws\Command\CancelFeedSubmissions', $command);

        $response = $client->execute($command);
        $this->assertInstanceOf('\SimpleXMLElement', $response);
    }
}