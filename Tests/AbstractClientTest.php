<?php
/**
 * @package Guzzle PHP <http://www.guzzlephp.org>
 * @license See the LICENSE file that was distributed with this source code.
 */

namespace Guzzle\Aws\Tests\S3;

use Guzzle\Aws;

/**
 * @author Michael Dowling <michael@guzzlephp.org>
 */
class AbstractClientTest extends \Guzzle\Tests\GuzzleTestCase
{
    /**
     * @covers Guzzle\Aws\AbstractClient::getAccessKeyId
     * @covers Guzzle\Aws\AbstractClient::getSecretAccessKey
     */
    public function testHoldsAccessIdentifiers()
    {
        $client = $this->getServiceBuilder()->get('test.s3');
        /* @var $client Guzzle\Aws\S3\S3Client */
        $this->assertNotEmpty($client->getAccessKeyId());
        $this->assertNotEmpty($client->getSecretAccessKey());

        $this->assertInstanceOf('Guzzle\\Aws\\Signature\\AbstractSignature', $client->getSignature());
    }
}