<?php

namespace Guzzle\Service\Aws\Tests\Mws\Command;

use Guzzle\Tests\GuzzleTestCase;
use Guzzle\Service\Aws\Mws\Type;

/**
 * @covers Guzzle\Service\Aws\Mws\Command\GetFeedSubmissionListByNextToken
 * @author Harold Asbridge <harold@shoebacca.com>
 */
class GetFeedSubmissionListByNextTokenTest extends GuzzleTestCase
{
    public function testGetFeedSubmissionListByNextToken()
    {
        $client = $this->getServiceBuilder()->get('test.mws');

        $this->setMockResponse($client, 'GetFeedSubmissionListByNextTokenResponse');
        $command = $client->getCommand('get_feed_submission_list_by_next_token')
            ->setNextToken('asdf');

        $this->assertInstanceOf('Guzzle\Service\Aws\Mws\Command\GetFeedSubmissionListByNextToken', $command);

        $response = $client->execute($command);
        $this->assertInstanceOf('\SimpleXMLElement', $response);
    }
}