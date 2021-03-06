<?php
/**
 * @package Guzzle PHP <http://www.guzzlephp.org>
 * @license See the LICENSE file that was distributed with this source code.
 */

namespace Guzzle\Aws\Tests\S3\Command\Bucket;

/**
 * @author Michael Dowling <michael@guzzlephp.org>
 */
class GetBucketRequestPaymentTest extends \Guzzle\Tests\GuzzleTestCase
{
    /**
     * @covers Guzzle\Aws\S3\Command\Bucket\GetBucketRequestPayment
     */
    public function testGetBucketRequestPayment()
    {
        $command = new \Guzzle\Aws\S3\Command\Bucket\GetBucketRequestPayment();
        $command->setBucket('test');

        $client = $this->getServiceBuilder()->get('test.s3');
        $this->setMockResponse($client, 'GetBucketRequestPaymentResponse');
        $client->execute($command);

        $this->assertEquals('http://test.s3.amazonaws.com/?requestPayment', $command->getRequest()->getUrl());
        $this->assertEquals('GET', $command->getRequest()->getMethod());

        $this->assertEquals('Requester', $command->getResult());
    }
}