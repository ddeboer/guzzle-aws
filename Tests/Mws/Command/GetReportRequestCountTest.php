<?php

namespace Guzzle\Aws\Tests\Mws\Command;

use Guzzle\Tests\GuzzleTestCase;
use Guzzle\Aws\Mws\Type;

/*
 * @covers Guzzle\Aws\Mws\Command\GetReportRequestCount
 * @author Harold Asbridge <harold@shoebacca.com>
 */
class GetReportRequestCountText extends GuzzleTestCase
{
    public function testGetReportRequestCount()
    {
        $client = $this->getServiceBuilder()->get('test.mws');

        $this->setMockResponse($client, 'GetReportRequestCountResponse');

        $command = $client->getCommand('get_report_request_count')
            ->setReportTypeList(array(
                Type\ReportType::MERCHANT_LISTINGS_REPORT
            ))
            ->setProcessingStatusList(array(
                Type\FeedProcessingStatus::DONE
            ))
            ->setRequestedFromDate(new \DateTime('2011-01-01'))
            ->setRequestedToDate(new \DateTime());

        $this->assertInstanceOf('Guzzle\Aws\Mws\Command\GetReportRequestCount', $command);

        $response = $client->execute($command);
        $this->assertInstanceOf('\SimpleXMLElement', $response);
    }
}