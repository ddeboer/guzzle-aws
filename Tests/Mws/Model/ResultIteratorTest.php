<?php

namespace Guzzle\Aws\Tests\MWs\Model;

use Guzzle\Tests\GuzzleTestCase;
use Guzzle\Aws\Mws\Model\ResultIterator;
use Guzzle\Aws\Mws\MwsBuilder;

/**
 * @covers Guzzle\Aws\Mws\Model\ResultIterator
 */
class ResultIteratorTest extends GuzzleTestCase
{
    protected $client;
    protected $iterator;

    public function getIterator()
    {
        if (!$this->iterator) {

            $client = $this->getServiceBuilder()->get('test.mws');

            $ele = new \SimpleXMLElement('<Results />');
            $ele->addChild('Result');
            $ele->Result->addChild('Foo', 'Bar');

            $this->iterator = new ResultIterator($client, array(
                'next_command'  => 'get_report_list_by_next_token',
                'next_token'    => 'asdf',
                'resources'     => array($ele),
                'result_node'   => 'Results',
                'record_path'   => '/'
            ));
        }

        return $this->iterator;
    }

    public function testSendRequest()
    {
        $iterator = $this->getIterator();
        $client = $this->getServiceBuilder()->get('test.mws');

        $this->setMockResponse($client, 'GetReportListByNextTokenResponse');

        foreach($iterator as $row) {
            $this->assertInstanceOf('\SimpleXMLElement', $row);
        }
    }
}