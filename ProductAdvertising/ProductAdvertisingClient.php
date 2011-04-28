<?php

namespace Guzzle\Aws\ProductAdvertising;

use Guzzle\Common\Inspector;
use Guzzle\Aws\AbstractClient;
use Guzzle\Aws\Signature\SignatureV2;
use Guzzle\Aws\QueryStringAuthPlugin;

class ProductAdvertisingClient extends AbstractClient
{
    const AMAZON_US = 'com';
    const AMAZON_UK = 'co.uk';
    const AMAZON_DE = 'de';
    const AMAZON_JP = 'co.jp';
    const AMAZON_FR = 'fr';
    const AMAZON_CA = 'ca';
    
    public static function factory($config)
    {
        $defaults = array(
            'base_url'  => 'http://ecs.amazonaws.{{region}}/onca/xml',
            'version'   => '2010-11-01',
            'region'    => self::AMAZON_US
        );
        
        $config = Inspector::prepareConfig($config, $defaults);
        
        $signature = new SignatureV2($config->get('access_key'), $config->get('secret_key'));
        $client = new self(
            $config->get('base_url'),
            $config->get('access_key'),
            $config->get('secret_key'),
            $config->get('version'),
            $signature
        );
        $client->setConfig($config);
        
        $client->getEventManager()->attach(
            new QueryStringAuthPlugin($signature, $config->get('version')),
            -9999
        );
        
        return $client;
    }
}