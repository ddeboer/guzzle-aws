<?php

namespace Guzzle\Service\Aws\Tests\Mws\Command;

use Guzzle\Tests\GuzzleTestCase;

/**
 * @covers Guzzle\Service\Aws\Mws\Command\GetReport
 * @covers Guzzle\Service\Aws\Mws\command\AbstractMwsCommand
 * @author Harold Asbridge <harold@shoebacca.com>
 */
class GetReportTest extends GuzzleTestCase
{
    public function testGetReport()
    {
        // Get client
        $client = $this->getServiceBuilder()->get('test.mws');

        // Get command
        $command = $client->getCommand('get_report')
            ->setReportId(12345);
        $this->assertInstanceOf('Guzzle\Service\Aws\Mws\Command\GetReport', $command);

        // Get mock response
        $this->setMockResponse($client, 'GetReportResponse');
        $report = $client->execute($command);
        $this->assertInstanceOf('Guzzle\Service\Aws\Mws\Model\CsvReport', $report);

        // Should have 3 rows in report
        $this->assertEquals(3, $report->count());

        // Report should have valid rows
        foreach($report as $row) {
            $this->assertArrayHasKey('item-name', $row);
        }
    }
}