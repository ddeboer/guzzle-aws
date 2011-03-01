<?php

namespace Guzzle\Service\Aws\Tests\Mws\Command;

use Guzzle\Tests\GuzzleTestCase;
use Guzzle\Service\Aws\Mws\Type;

/**
 * @covers Guzzle\Service\Aws\Mws\Command\GetReportScheduleCount
 * @author Harold Asbridge <harold@shoebacca.com>
 */
class GetReportScheduleCountTest extends GuzzleTestCase
{
    public function testGetReportScheduleCountTest()
    {
        $client = $this->getServiceBuilder()->getClient('test.mws');

        $this->setMockResponse($client, 'GetReportScheduleCountResponse');

        $command = $client->getCommand('get_report_schedule_count')
            ->setReportTypeList(array(
                Type\ReportType::MERCHANT_LISTINGS_REPORT
            ));
        $this->assertInstanceOf('Guzzle\Service\Aws\Mws\Command\GetReportScheduleCount', $command);

        $response = $client->execute($command);
        $this->assertInstanceOf('\SimpleXMLElement', $response);
    }
}