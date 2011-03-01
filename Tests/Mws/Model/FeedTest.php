<?php
namespace Guzzle\Service\Aws\Tests\Mws;

use Guzzle\Tests\GuzzleTestCase;
use Guzzle\Service\Aws\Mws\Model\Feed;
use Guzzle\Common\Xml\Element;

/**
 * @covers Guzzle\Service\Aws\Mws\Model\Feed
 * @author Harold Asbridge <harold@shoebacca.com>
 */
class FeedTest extends GuzzleTestCase
{
    public function testFeed()
    {
        $feed = new Feed();

        $feed->setMessage('<Sample />');

        $this->assertInstanceOf('Guzzle\Common\XmlElement', $feed->getMessage());
        $this->assertInstanceOf('Guzzle\Common\XmlElement', $feed->getXml());
        $this->assertContains('<?xml', $feed->toXml());
        $this->assertContains('<?xml', (string)$feed);
    }
}