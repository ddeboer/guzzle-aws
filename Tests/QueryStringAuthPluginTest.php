<?php
/**
 * @package Guzzle PHP <http://www.guzzlephp.org>
 * @license See the LICENSE file that was distributed with this source code.
 */

namespace Guzzle\Service\Aws\Tests;

use Guzzle\Common\Event\EventManager;
use Guzzle\Http\Message\RequestFactory;
use Guzzle\Service\Command\CommandSet;
use Guzzle\Service\Aws\Signature\SignatureV2;
use Guzzle\Service\Aws\QueryStringAuthPlugin;

/**
 * @author Michael Dowling <michael@guzzlephp.org>
 */
class QueryStringAuthPluginTest extends \Guzzle\Tests\GuzzleTestCase
{
    /**
     * @covers Guzzle\Service\Aws\QueryStringAuthPlugin
     */
    public function testAddsQueryStringAuth()
    {
        $signature = new SignatureV2('a', 'b');
        
        $plugin = new QueryStringAuthPlugin($signature, '2009-04-15');
        $this->assertSame($signature, $plugin->getSignature());
        $this->assertEquals('2009-04-15', $plugin->getApiVersion());

        $request = RequestFactory::get('http://www.test.com/');
        $request->getEventManager()->attach($plugin);
        
        $request->getEventManager()->notify('request.before_send');
        
        $qs = $request->getQuery();
        $this->assertTrue($qs->hasKey('Timestamp') !== false);
        $this->assertEquals('2009-04-15', $qs->get('Version'));
        $this->assertEquals('2', $qs->get('SignatureVersion'));
        $this->assertEquals('HmacSHA256', $qs->get('SignatureMethod'));
        $this->assertEquals('a', $qs->get('AWSAccessKeyId'));
    }

    /**
     * @covers Guzzle\Service\Aws\QueryStringAuthPlugin
     */
    public function testAddsAuthWhenUsingCommandSets()
    {
        $client = $this->getServiceBuilder()->get('test.simple_db');
        $this->assertTrue($client->getEventManager()->hasObserver('Guzzle\\Service\\Aws\\QueryStringAuthPlugin'));

        $this->setMockResponse($client, array(
            'DeleteDomainResponse',
            'CreateDomainResponse'
        ));

        $set = new CommandSet(array(
            $client->getCommand('delete_domain', array('domain' => '123')),
            $client->getCommand('create_domain', array('domain' => '123')),
        ));

        $client->execute($set);

        foreach ($set as $command) {
            $qs = $command->getRequest()->getQuery();
            $this->assertTrue($qs->hasKey('Timestamp') !== false);
            $this->assertEquals('2009-04-15', $qs->get('Version'));
            $this->assertEquals('2', $qs->get('SignatureVersion'));
            $this->assertEquals('HmacSHA256', $qs->get('SignatureMethod'));
            $this->assertEquals('12345', $qs->get('AWSAccessKeyId'));
        }
    }
}