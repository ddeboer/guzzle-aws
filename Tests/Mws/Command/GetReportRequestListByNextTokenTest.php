<?php

namespace Guzzle\Aws\Tests\Mws\Command;

use Guzzle\Tests\GuzzleTestCase;

/**
 * @covers Guzzle\Aws\Mws\Command\GetReportRequestListByNextToken
 * @author Harold Asbridge <harold@shoebacca.com>
 */
class GetReportRequestListByNextTokenTest extends GuzzleTestCase
{
    public function testGetReportRequestListByNextToken()
    {
        $client = $this->getServiceBuilder()->get('test.mws');

        $this->setMockResponse($client, 'GetReportRequestListByNextTokenResponse');

        $command = $client->getCommand('get_report_request_list_by_next_token')
            ->setNextToken('asdf');

        $this->assertInstanceOf('Guzzle\Aws\Mws\Command\GetReportRequestListByNextToken', $command);

        $response = $client->execute($command);
        $this->assertInstanceOf('\SimpleXMLElement', $response);
    }
}