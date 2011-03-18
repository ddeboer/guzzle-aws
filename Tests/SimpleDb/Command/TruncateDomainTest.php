<?php
/**
 * @package Guzzle PHP <http://www.guzzlephp.org>
 * @license See the LICENSE file that was distributed with this source code.
 */

namespace Guzzle\Service\Aws\Tests\SimpleDb\Command;

/**
 * @author Michael Dowling <michael@guzzlephp.org>
 */
class TruncateDomainTest extends \Guzzle\Tests\GuzzleTestCase
{
    /**
     * @covers Guzzle\Service\Aws\SimpleDb\Command\TruncateDomain
     */
    public function testTruncateDomain()
    {
        $this->getServer()->flush();
        $client = $this->getServiceBuilder()->get('test.simple_db', true);
        $client->setBaseUrl($this->getServer()->getUrl());
        $this->setMockResponse($client, array(
            'DeleteDomainResponse',
            'CreateDomainResponse'
        ));

        $command = new \Guzzle\Service\Aws\SimpleDb\Command\TruncateDomain();
        $this->assertSame($command, $command->setDomain('test'));
        $client->execute($command);

        $this->assertContains(
            $this->getServer()->getUrl() . '?Action=DeleteDomain&DomainName=test&Timestamp=',
            $command->getRequest()->getUrl()
        );

        $this->assertInstanceOf('SimpleXMLElement', $command->getResult());

        $requests = $this->getMockedRequests();
        $this->assertEquals('DeleteDomain', $requests[0]->getQuery()->get('Action'));
        $this->assertEquals('test', $requests[0]->getQuery()->get('DomainName'));
        $this->assertEquals('CreateDomain', $requests[1]->getQuery()->get('Action'));
        $this->assertEquals('test', $requests[1]->getQuery()->get('DomainName'));
    }
}