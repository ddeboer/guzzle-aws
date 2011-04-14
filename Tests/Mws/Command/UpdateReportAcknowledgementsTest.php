<?php

namespace Guzzle\Aws\Tests\Mws\Command;

use Guzzle\Tests\GuzzleTestCase;
use Guzzle\Aws\Mws\Type;

/**
 * @covers Guzzle\Aws\Mws\Command\UpdateReportAcknowledgements
 * @author Harold Asbridge <harold@shoebacca.com>
 */
class UpdateReportAcknowledgementsTest extends GuzzleTestCase
{
    public function testUpdateReportAcknowledgements()
    {
        $client = $this->getServiceBuilder()->get('test.mws');

        $this->setMockResponse($client, 'UpdateReportAcknowledgementsResponse');

        $command = $client->getCommand('update_report_acknowledgements')
            ->setReportIdList(array(
                12345
            ))
            ->setAcknowledged(true);
        $this->assertInstanceOf('Guzzle\Aws\Mws\Command\UpdateReportAcknowledgements', $command);

        $response = $client->execute($command);
        $this->assertInstanceOf('\SimpleXMLElement', $response);
    }
}