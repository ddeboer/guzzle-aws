<?php
/**
 * @package Guzzle PHP <http://www.guzzlephp.org>
 * @license See the LICENSE file that was distributed with this source code.
 */

namespace Guzzle\Service\Aws\Tests\Sqs;

use Guzzle\Service\Aws\Sqs\SqsClient;

/**
 * @author Michael Dowling <michael@guzzlephp.org>
 */
class SqsClientTest extends \Guzzle\Tests\GuzzleTestCase
{
    /**
     * @covers Guzzle\Service\Aws\Sqs\SqsClient
     */
    public function testBuildsClient()
    {
        $client = SqsClient::factory(array(
            'access_key' => 'a',
            'secret_key' => 'b'
        ));
        $this->assertInstanceOf('Guzzle\\Service\\Aws\\Sqs\\SqsClient', $client);
        // Make sure the query string auth signing plugin was attached
        $this->assertTrue($client->getEventManager()->hasObserver('Guzzle\Service\Aws\QueryStringAuthPlugin'));
    }
}