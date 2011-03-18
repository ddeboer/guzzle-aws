<?php
/**
 * @package Guzzle PHP <http://www.guzzlephp.org>
 * @license See the LICENSE file that was distributed with this source code.
 */

namespace Guzzle\Service\Aws\Sqs;

use Guzzle\Common\Cache\CacheAdapterInterface;
use Guzzle\Service\Builder\DefaultBuilder;
use Guzzle\Service\Aws\AbstractClient;
use Guzzle\Service\Aws\QueryStringAuthPlugin;
use Guzzle\Service\Aws\Signature\SignatureV2;

/**
 * Client for interacting with Amazon SQS
 *
 * @author Michael Dowling <michael@guzzlephp.org>
 */
class SqsClient extends AbstractClient
{
    const REGION_US_EAST_1 = 'sqs.us-east-1.amazonaws.com'; // Endpoint located in the US-East (Northern Virginia) Region
    const REGION_US_WEST_1 = 'sqs.us-west-1.amazonaws.com'; // Endpoint located in the US-West (Northern California) Region
    const REGION_EU_WEST_1 = 'sqs.eu-west-1.amazonaws.com'; // Endpoint located in the EU (Ireland) Region
    const REGION_AP_SOUTHEAST_1 = 'sqs.ap-southeast-1.amazonaws.com'; // Endpoint located in the Asia Pacific (Singapore) Region

    /**
     * Factory method to create a new SQS client
     *
     * @param array|Collection $config Configuration data. Array keys:
     *    base_url - Base URL of web service.  Default: {{scheme}}://{{region}}/
     *    scheme - Set to http or https.  Defaults to http
     *    version - API version.  Defaults to 2009-02-01
     *    region - AWS region.  Defaults to sqs.us-east-1.amazonaws.com
     *  * access_key - AWS access key ID
     *  * secret_key - AWS secret access key
     * @param CacheAdapterInterface $cacheAdapter (optional) Pass a cache
     *      adapter to cache the service configuration settings
     * @param int $cacheTtl (optional) How long to cache data
     *
     * @return CentinelClient
     */
    public static function factory($config, CacheAdapterInterface $cache = null, $ttl = 86400)
    {
        $defaults = array(
            'base_url' => '{{scheme}}://{{region}}/',
            'version' => '2009-02-01',
            'region' => self::REGION_US_EAST_1,
            'scheme' => 'http'
        );
        $required = array('access_key', 'secret_key', 'region', 'version', 'scheme');
        $config = DefaultBuilder::prepareConfig($config, $defaults, $required);

        // Filter our the Timestamp and Signature query string values from cache
        $config->set('cache.key_filter', 'query=Timestamp, Signature');

        $signature = new SignatureV2($config->get('access_key'), $config->get('secret_key'));
        $client = new self(
            $config->get('base_url'),
            $config->get('access_key'),
            $config->get('secret_key'),
            $config->get('version'),
            $signature
        );
        $client->setConfig($config);

        // Sign the request last
        $client->getEventManager()->attach(
            new QueryStringAuthPlugin($signature, $config->get('version')),
            -9999
        );

        return DefaultBuilder::build($client, $cache, $ttl);
    }
}