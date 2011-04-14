<?php

namespace Guzzle\Aws\Tests\Mws\Command;

use Guzzle\Tests\GuzzleTestCase;
use Guzzle\Aws\Mws\Type;

/**
 * @covers Guzzle\Aws\Mws\Command\CancelReportRequests
 * @author Harold Asbridge <harold@shoebacca.com>
 */
class CancelReportRequestsTest extends GuzzleTestCase
{
    public function testCancelReportRequests()
    {
        // Get client
        $client = $this->getServiceBuilder()->get('test.mws');

        $this->setMockResponse($client, 'CancelReportRequestsResponse');

        $command = $client->getCommand('cancel_report_requests')
            ->setReportRequestIdList(array(
                123
            ))
            ->setReportTypeList(array(
                Type\ReportType::MERCHANT_LISTINGS_REPORT
            ))
            ->setReportProcessingStatusList(array(
                Type\ReportProcessingStatus::DONE
            ))
            ->setRequestedFromDate(new \DateTime('2011-01-01'))
            ->setRequestedToDate(new \DateTime());
        $this->assertInstanceOf('Guzzle\Aws\Mws\Command\CancelReportRequests', $command);

        $response = $client->execute($command);
        $this->assertInstanceOf('\SimpleXMLElement', $response);

    }
}