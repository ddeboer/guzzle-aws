<?php
/**
 * @package Guzzle PHP <http://www.guzzlephp.org>
 * @license See the LICENSE file that was distributed with this source code.
 */

namespace Guzzle\Aws\Tests\S3\Command\Bucket;

use Guzzle\Aws\S3\Command\Bucket\ClearBucket;

/**
 * @author Michael Dowling <michael@guzzlephp.org>
 */
class ClearBucketTest extends \Guzzle\Tests\GuzzleTestCase
{
    /**
     * @covers Guzzle\Aws\S3\Command\Bucket\ClearBucket
     * @covers Guzzle\Aws\S3\Model\BucketIterator
     */
    public function testClearBucket()
    {
        $command = new ClearBucket();
        $command->setBucket('test');
        $client = $this->getServiceBuilder()->get('test.s3');
        $this->setMockResponse($client, array(
            'ListBucketNextMarkerPrefixMarkerResponse',
            'ListBucketResponse',
            'DeleteObjectResponse',
            'DeleteObjectResponse',
            'DeleteObjectResponse',
            'DeleteObjectResponse'
        ));

        $client->execute($command);

        $requests = $this->getMockedRequests();

        // Two list buckets followed by deletes for each key found in the results
        $this->assertEquals('GET', $requests[0]->getMethod());
        $this->assertEquals('GET', $requests[1]->getMethod());
        
        $this->assertEquals('DELETE', $requests[2]->getMethod());
        $this->assertEquals('/Nelson', $requests[2]->getPath());
        
        $this->assertEquals('DELETE', $requests[3]->getMethod());
        $this->assertEquals('/Neo', $requests[3]->getPath());
        
        $this->assertEquals('DELETE', $requests[4]->getMethod());
        $this->assertEquals('/my-image.jpg', $requests[4]->getPath());
        
        $this->assertEquals('DELETE', $requests[5]->getMethod());
        $this->assertEquals('/my-third-image.jpg', $requests[5]->getPath());

        $this->assertEquals(4, $command->getResult()->getIteratedCount());
        $this->assertEquals(1, $command->getResult()->getBatchCount());
    }

    /**
     * @covers Guzzle\Aws\S3\Command\Bucket\ClearBucket
     * @covers Guzzle\Aws\S3\Model\BucketIterator
     */
    public function testClearBucketUsesLimit()
    {
        $command = new ClearBucket();
        $command->setBucket('test');
        $client = $this->getServiceBuilder()->get('test.s3');
        $command->setPerBatch(2);

        $this->setMockResponse($client, array(
            'ListBucketNextMarkerPrefixMarkerResponse',
            'DeleteObjectResponse',
            'DeleteObjectResponse',
            'ListBucketResponse',
            'DeleteObjectResponse',
            'DeleteObjectResponse'
        ));

        $client->execute($command);

        $this->assertEquals(4, $command->getResult()->getIteratedCount());
        $this->assertEquals(2, $command->getResult()->getBatchCount());
    }
}