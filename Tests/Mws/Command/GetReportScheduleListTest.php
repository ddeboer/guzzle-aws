<?php

namespace Guzzle\Service\Aws\Tests\Mws\Command;

use Guzzle\Tests\GuzzleTestCase;
use Guzzle\Service\Aws\Mws\Type;

/**
 * @covers Guzzle\Service\Aws\Mws\Command\GetReportScheduleList
 * @author Harold Asbridge <harold@shoebacca.com>
 */
class GetReportScheduleListTest extends GuzzleTestCase
{
    public function testGetReportScheduleList()
    {
        $client = $this->getServiceBuilder()->get('test.mws');

        $this->setMockResponse($client, 'GetReportScheduleListResponse');

        $command = $client->getCommand('get_report_schedule_list')
            ->setReportTypeList(array(
                Type\ReportType::MERCHANT_LISTINGS_REPORT
            ));

        $this->assertInstanceOf('Guzzle\Service\Aws\Mws\Command\GetReportScheduleList', $command);

        $response = $client->execute($command);
        $this->assertInstanceOf('Guzzle\Service\Aws\Mws\Model\ResultIterator', $response);
    }
}