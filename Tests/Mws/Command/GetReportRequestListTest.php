<?php

namespace Guzzle\Service\Aws\Tests\Mws\Command;

use Guzzle\Tests\GuzzleTestCase;
use Guzzle\Service\Aws\Mws\Type;

/**
 * @covers Guzzle\Service\Aws\Mws\Command\GetReportRequestList
 * @author Harold Asbridge <harold@shoebacca.com>
 */
class GetReportRequestListText extends GuzzleTestCase
{
    public function testGetReportRequestList()
    {
        $client = $this->getServiceBuilder()->get('test.mws');

        $this->setMockResponse($client, 'GetReportRequestListResponse');

        $command = $client->getCommand('get_report_request_list')
            ->setReportRequestIdList(array(
                12345
            ))
            ->setReportTypeList(array(
                Type\ReportType::MERCHANT_LISTINGS_REPORT
            ))
            ->setReportProcessingStatusList(array(
                Type\FeedProcessingStatus::DONE
            ))
            ->setMaxCount(10)
            ->setRequestedFromDate(new \DateTime('2011-01-01'))
            ->setRequestedToDate(new \DateTime());

        $this->assertInstanceOf('Guzzle\Service\Aws\Mws\Command\GetReportRequestList', $command);

        $response = $client->execute($command);
        $this->assertInstanceOf('Guzzle\Service\Aws\Mws\Model\ResultIterator', $response);
    }
}
