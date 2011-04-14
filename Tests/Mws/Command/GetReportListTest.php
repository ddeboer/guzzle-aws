<?php

namespace Guzzle\Aws\Tests\Mws\Command;

use Guzzle\Tests\GuzzleTestCase;
use Guzzle\Aws\Mws\Type;

/**
 * @covers Guzzle\Aws\Mws\Command\GetReportList
 * @covers Guzzle\Aws\Mws\Command\AbstractMwsCommand
 * @covers Guzzle\Aws\Mws\Command\IterableInterface
 * 
 * @author Harold Asbridge <harold@shoebacca.com>
 */
class GetReportListTest extends GuzzleTestCase
{
    public function testGetReportList()
    {
        // Get client
        $client = $this->getServiceBuilder()->get('test.mws');

        $this->setMockResponse($client, 'GetReportListResponse');

        // Test command
        $command = $client->getCommand('get_report_list')
            ->setMaxCount(10)
            ->setReportTypeList(array(
                Type\ReportType::MERCHANT_LISTINGS_REPORT
            ))
            ->setReportRequestIdList(array(
                12345
            ))
            ->setAcknowledged(true)
            ->setAvailableFromDate(new \DateTime('2011-01-01'))
            ->setAvailableToDate(new \DateTime());
        
        $this->assertInstanceOf('Guzzle\Aws\Mws\Command\GetReportList', $command);

        // Response should be a SimpleXMLElement
        $response = $client->execute($command);
        $this->assertInstanceOf('Guzzle\Aws\Mws\Model\ResultIterator', $response);

    }
}