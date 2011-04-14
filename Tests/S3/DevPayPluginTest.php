<?php
/**
 * @package Guzzle PHP <http://www.guzzlephp.org>
 * @license See the LICENSE file that was distributed with this source code.
 */

namespace Guzzle\Aws\Tests\S3;

use Guzzle\Aws\S3\S3Client;

/**
 * @author Michael Dowling <michael@guzzlephp.org>
 */
class DevPayPluginTest extends \Guzzle\Tests\GuzzleTestCase
{
    /**
     * @covers Guzzle\Aws\S3\DevPayPlugin
     */
    public function testAddsDevPayTokens()
    {
        $this->getServer()->enqueue("HTTP/1.1 200 OK\r\nContent-Length: 0\r\n\r\n");

        $client = S3Client::factory(array(
            'base_url' => $this->getServer()->getUrl(),
            'access_key' => 'a',
            'secret_key' => 's',
            'devpay_user_token' => 'user',
            'devpay_product_token' => 'product'
        ));

        $request = $client->createRequest('GET');
        $request->send();
        $this->assertTrue($request->hasHeader('x-amz-security-token') !== false);
        $this->assertEquals('user, product', $request->getHeader('x-amz-security-token'));
    }
}