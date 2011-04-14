<?php

namespace Guzzle\Aws\Tests\Mws\Command;

use Guzzle\Tests\GuzzleTestCase;
use Guzzle\Aws\Mws\Type;

/**
 * @covers Guzzle\Aws\Mws\Command\RequestReport
 * @author Harold Asbridge <harold@shoebacca.com>
 */
class RequestReportTest extends GuzzleTestCase
{
    public function testRequestReport()
    {
        $client = $this->getServiceBuilder()->get('test.mws');

        $this->setMockResponse($client, 'RequestReportResponse');
        
        $command = $client->getCommand('request_report')
            ->setReportType(Type\ReportType::MERCHANT_LISTINGS_REPORT)
            ->setStartDate(new \DateTime('2011-01-01'))
            ->setEndDate(new \DateTime());

        $this->assertInstanceOf('Guzzle\Aws\Mws\Command\RequestReport', $command);

        $response = $client->execute($command);
        $this->assertInstanceOf('\SimpleXMLElement', $response);
    }
}