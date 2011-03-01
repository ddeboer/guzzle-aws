<?php

namespace Guzzle\Service\Aws\Tests\Mws\Command;

use Guzzle\Tests\GuzzleTestCase;
use Guzzle\Service\Aws\Mws\Type;

/**
 * @covers Guzzle\Service\Aws\Mws\Command\GetReportListByNextToken
 * @author Harold Asbridge <harold@shoebacca.com>
 */
class GetReportListByNextTokenTest extends GuzzleTestCase
{
    public function testGetReportListByNextToken()
    {
        $client = $this->getServiceBuilder()->getClient('test.mws');

        $this->setMockResponse($client, 'GetReportListByNextTokenResponse');

        $command = $client->getCommand('get_report_list_by_next_token')
            ->setNextToken('asdf');

        $this->assertInstanceOf('Guzzle\Service\Aws\Mws\Command\GetReportListByNextToken', $command);

        $response = $client->execute($command);
        $this->assertInstanceOf('\SimpleXMLElement', $response);
    }
}