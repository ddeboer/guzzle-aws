<?php

namespace Guzzle\Service\Aws\Tests\Mws\Command;

use Guzzle\Tests\GuzzleTestCase;
use Guzzle\Service\Aws\Mws\Type;

/*
 * @covers Guzzle\Service\Aws\Mws\Command\GetReportCount
 * @author Harold Asbridge <harold@shoebacca.com>
 */
class GetReportCountTest extends GuzzleTestCase
{
    public function testGetReportCount()
    {
        $client = $this->getServiceBuilder()->get('test.mws');

        $this->setMockResponse($client, 'GetReportCountResult');

        $command = $client->getCommand('get_report_count')
            ->setReportTypeList(array(
                Type\ReportType::MERCHANT_LISTINGS_REPORT
            ))
            ->setAcknowledged(true)
            ->setAvailableFromDate(new \DateTime('2011-01-01'))
            ->setAvailableToDate(new \DateTime());

        $this->assertInstanceOf('Guzzle\Service\Aws\Mws\Command\GetReportCount', $command);

        $response = $client->execute($command);
        $this->assertInstanceOf('\SimpleXMLElement', $response);
    }
}