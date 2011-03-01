<?php

namespace Guzzle\Service\Aws\Tests\Mws;

use Guzzle\Tests\GuzzleTestCase;
use Guzzle\Service\Aws\Mws\MwsBuilder;

/**
 * @covers Guzzle\Service\Aws\Mws\MwsBuilder
 *
 * @author Harold Asbridge <harold@shoebacca.com>
 */
class MwsBuilderTest extends GuzzleTestCase
{
    public function testBuild()
    {
        $builder = new MwsBuilder(array(
            'merchant_id'           => 'ASDF',
            'marketplace_id'        => 'ASDF',
            'access_key_id'         => 'ASDF',
            'secret_access_key'     => 'ASDF',
            'application_name'      => 'GuzzleTest',
            'application_version'   => '0.1'
        ));

        $client = $builder->build();
    }
}