<?php
/**
 * @package Guzzle PHP <http://www.guzzlephp.org>
 * @license See the LICENSE file that was distributed with this source code.
 */

namespace Guzzle\Aws\Tests\S3\Command\Bucket;

/**
 * @author Michael Dowling <michael@guzzlephp.org>
 */
class DeleteBucketTest extends \Guzzle\Tests\GuzzleTestCase
{
    /**
     * @covers Guzzle\Aws\S3\Command\Bucket\DeleteBucket
     * @covers Guzzle\Aws\S3\Command\AbstractS3BucketCommand
     */
    public function testDeleteBucket()
    {
        $command = new \Guzzle\Aws\S3\Command\Bucket\DeleteBucket();
        $command->setBucket('test');
        $client = $this->getServiceBuilder()->get('test.s3');
        $this->setMockResponse($client, 'DeleteBucketResponse');
        $client->execute($command);

        $this->assertEquals('http://test.s3.amazonaws.com/', $command->getRequest()->getUrl());
        $this->assertEquals('DELETE', $command->getRequest()->getMethod());
    }
}