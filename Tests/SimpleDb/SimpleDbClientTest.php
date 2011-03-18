<?php
/**
 * @package Guzzle PHP <http://www.guzzlephp.org>
 * @license See the LICENSE file that was distributed with this source code.
 */

namespace Guzzle\Service\Aws\Tests\SimpleDb;

use Guzzle\Service\Aws\SimpleDb\SimpleDbClient;

/**
 * @author Michael Dowling <michael@guzzlephp.org>
 */
class SimpleDbClientTest extends \Guzzle\Tests\GuzzleTestCase
{
    /**
     * @covers Guzzle\Service\Aws\SimpleDb\SimpleDbClient
     */
    public function testBuildsClient()
    {
        $client = SimpleDbClient::factory(array(
            'access_key' => 'a',
            'secret_key' => 'b'
        ));
        $this->assertInstanceOf('Guzzle\\Service\\Aws\\SimpleDb\\SimpleDbClient', $client);
        // Make sure the query string auth signing plugin was attached
        $this->assertTrue($client->getEventManager()->hasObserver('Guzzle\\Service\\Aws\\QueryStringAuthPlugin'));
    }
}