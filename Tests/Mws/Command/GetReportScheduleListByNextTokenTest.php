<?php

namespace Guzzle\Aws\Tests\Mws\Command;

use Guzzle\Tests\GuzzleTestCase;

/**
 * @covers Guzzle\Aws\Mws\Command\GetReportScheduleListByNextToken
 * @author Harold Asbridge <harold@shoebacca.com>
 */
class GetReportScheduleListByNextTokenTest extends GuzzleTestCase
{
    public function testGetReportScheduleListByNextToken()
    {
        $client = $this->getServiceBuilder()->get('test.mws');

        $this->setMockResponse($client, 'GetReportScheduleListByNextTokenResponse');

        $command = $client->getCommand('get_report_schedule_list_by_next_token')
            ->setNextToken('asdf');

        $this->assertInstanceOf('Guzzle\Aws\Mws\Command\GetReportScheduleListByNextToken', $command);

        $response = $client->execute($command);
        $this->assertInstanceOf('\SimpleXMLElement', $response);
    }
}