<?php

namespace Guzzle\Service\Aws\Tests\Mws\Command;

use Guzzle\Tests\GuzzleTestCase;

/**
 * @covers Guzzle\Service\Aws\Mws\Command\GetFeedSubmissionResult
 * @author Harold Asbridge <harold@shoebacca.com>
 */
class GetFeedSubmissionResult extends GuzzleTestCase
{
    public function testGetFeedSubmissionResult()
    {
        $client = $this->getServiceBuilder()->getClient('test.mws');

        $this->setMockResponse($client, 'GetFeedSubmissionResultResponse');

        $command = $client->getCommand('get_feed_submission_result')
            ->setFeedSubmissionId(12345);
        $this->assertInstanceOf('Guzzle\Service\Aws\Mws\Command\GetFeedSubmissionResult', $command);

        $response = $client->execute($command);
        $this->assertInstanceOf('\SimpleXMLElement', $response);
    }
}