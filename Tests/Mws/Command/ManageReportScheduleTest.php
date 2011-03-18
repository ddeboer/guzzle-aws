<?php

namespace Guzzle\Service\Aws\Tests\Mws\Command;

use Guzzle\Tests\GuzzleTestCase;
use Guzzle\Service\Aws\Mws\Type;

/**
 * @covers Guzzle\Service\Aws\Mws\Command\ManageReportSchedule
 * @author Harold Asbridge <harold@shoebacca.com>
 */
class ManageReportScheduleTest extends GuzzleTestCase
{
    public function testManageReportSchedule()
    {
        $client = $this->getServiceBuilder()->get('test.mws');

        $this->setMockResponse($client, 'ManageReportScheduleResponse');
        
        $command = $client->getCommand('manage_report_schedule')
            ->setReportType(Type\ReportType::MERCHANT_LISTINGS_REPORT)
            ->setSchedule(Type\Schedule::EVERY_HOUR)
            ->setScheduledDate(new \DateTime());
        $this->assertInstanceOf('Guzzle\Service\Aws\Mws\Command\ManageReportSchedule', $command);

        $response = $client->execute($command);
        $this->assertInstanceOf('\SimpleXMLElement', $response);
    }
}
