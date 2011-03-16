<?php

namespace Guzzle\Service\Aws\Tests\Mws\Command;

use Guzzle\Tests\GuzzleTestCase;
use Guzzle\Service\Aws\Mws\Type;

/**
 * @covers Guzzle\Service\Aws\Mws\Command\GetFeedSubmissionList
 * @author Harold Asbridge <harold@shoebacca.com>
 */
class GetFeedSubmissionListTest extends GuzzleTestCase
{
    public function testGetFeedSubmissionList()
    {
        $client = $this->getServiceBuilder()->getClient('test.mws');

        $this->setMockResponse($client, 'GetFeedSubmissionListResponse');

        $command = $client->getCommand('get_feed_submission_list')
            ->setFeedSubmissionIdList(array(
                123
            ))
            ->setMaxCount(10)
            ->setFeedTypeList(array(
                Type\FeedType::PRODUCT_FEED
            ))
            ->setFeedProcessingStatusList(array(
                Type\FeedProcessingStatus::DONE
            ))
            ->setSubmittedFromDate(new \DateTime('2011-01-01'))
            ->setSubmittedToDate(new \DateTime());

        $this->assertInstanceOf('Guzzle\Service\Aws\Mws\Command\GetFeedSubmissionList', $command);

        $response = $client->execute($command);
        $this->assertInstanceOf('Guzzle\Service\Aws\Mws\Model\ResultIterator', $response);
    }
}
