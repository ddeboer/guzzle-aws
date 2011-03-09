<?php
/**
 * @package Guzzle PHP <http://www.guzzlephp.org>
 * @license See the LICENSE file that was distributed with this source code.
 */

namespace Guzzle\Service\Aws\Tests\Sqs;

/**
 * @author Michael Dowling <michael@guzzlephp.org>
 */
class SqsBuilderTest extends \Guzzle\Tests\GuzzleTestCase
{
    /**
     * @covers Guzzle\Service\Aws\Sqs\SqsBuilder::build
     * @covers Guzzle\Service\Aws\Sqs\SqsBuilder::getClass
     */
    public function testBuild()
    {
        $builder = $this->getServiceBuilder()->getBuilder('test.sqs');

        $this->assertInstanceOf('Guzzle\Service\Aws\Sqs\SqsBuilder', $builder);
        $this->assertEquals('Guzzle\\Service\\Aws\\Sqs\\SqsClient', $builder->getClass());
        $this->assertEquals('test.sqs', $builder->getName());

        // Make sure the builder creates a valid client objects
        $client = $builder->build();
        $this->assertInstanceOf('Guzzle\\Service\\Aws\\Sqs\\SqsClient', $client);

        // Make sure the query string auth signing plugin was attached
        $this->assertTrue($client->getEventManager()->hasObserver('Guzzle\Service\Aws\QueryStringAuthPlugin'));
    }
}