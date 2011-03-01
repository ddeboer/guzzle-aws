<?php

namespace Guzzle\Service\Aws\Tests\Mws\Command;

use Guzzle\Tests\GuzzleTestCase;

/**
 * @covers Guzzle\Service\Aws\Mws\Command\GetReportRequestListByNextToken
 * @author Harold Asbridge <harold@shoebacca.com>
 */
class GetReportRequestListByNextTokenTest extends GuzzleTestCase
{
    public function testGetReportRequestListByNextToken()
    {
        $client = $this->getServiceBuilder()->getClient('test.mws');

        $this->setMockResponse($client, 'GetReportRequestListByNextTokenResponse');

        $command = $client->getCommand('get_report_request_list_by_next_token')
            ->setNextToken('asdf');

        $this->assertInstanceOf('Guzzle\Service\Aws\Mws\Command\GetReportRequestListByNextToken', $command);

        $response = $client->execute($command);
        $this->assertInstanceOf('\SimpleXMLElement', $response);
    }
}