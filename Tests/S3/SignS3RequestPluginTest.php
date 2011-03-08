<?php
/**
 * @package Guzzle PHP <http://www.guzzlephp.org>
 * @license See the LICENSE file that was distributed with this source code.
 */

namespace Guzzle\Service\Aws\Tests\S3;

use Guzzle\Common\Event\EventManager;
use Guzzle\Http\Message\RequestFactory;
use Guzzle\Service\Aws\S3\S3Builder;
use Guzzle\Service\Aws\S3\S3Signature;
use Guzzle\Service\Aws\S3\SignS3RequestPlugin;

/**
 * @author Michael Dowling <michael@guzzlephp.org>
 */
class SignS3RequestPluginTest extends \Guzzle\Tests\GuzzleTestCase
{
    /**
     * @covers Guzzle\Service\Aws\S3\SignS3RequestPlugin
     */
    public function testSignsS3Requests()
    {
        $signature = new S3Signature('a', 'b');
        $plugin = new SignS3RequestPlugin($signature);
        $this->assertSame($signature, $plugin->getSignature());
    }

    /**
     * @covers Guzzle\Service\Aws\S3\SignS3RequestPlugin
     */
    public function testAddsAuthorizationHeaders()
    {
        $this->getServer()->enqueue("HTTP/1.1 200 OK\r\nContent-Length: 0\r\n\r\n");

        $builder = new S3Builder(array(
            'base_url' => $this->getServer()->getUrl(),
            'access_key_id' => 'a',
            'secret_access_key' => 's'
        ));

        $client = $builder->build();

        $request = $client->getRequest('GET');
        $request->send();

        $this->assertTrue($request->hasHeader('Authorization'));
        $this->assertContains('AWS a:', $request->getHeader('Authorization'));
    }
}