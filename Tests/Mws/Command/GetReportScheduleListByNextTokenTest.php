<?php

namespace Guzzle\Service\Aws\Tests\Mws\Command;

use Guzzle\Tests\GuzzleTestCase;

/**
 * @covers Guzzle\Service\Aws\Mws\Command\GetReportScheduleListByNextToken
 * @author Harold Asbridge <harold@shoebacca.com>
 */
class GetReportScheduleListByNextTokenTest extends GuzzleTestCase
{
    public function testGetReportScheduleListByNextToken()
    {
        $client = $this->getServiceBuilder()->getClient('test.mws');

        $this->setMockResponse($client, 'GetReportScheduleListByNextTokenResponse');

        $command = $client->getCommand('get_report_schedule_list_by_next_token')
            ->setNextToken('asdf');

        $this->assertInstanceOf('Guzzle\Service\Aws\Mws\Command\GetReportScheduleListByNextToken', $command);

        $response = $client->execute($command);
        $this->assertInstanceOf('\SimpleXMLElement', $response);
    }
}