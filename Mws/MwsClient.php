<?php
/**
 * @package Guzzle PHP <http://www.guzzlephp.org>
 * @license See the LICENSE file that was distributed with this source code.
 */

namespace Guzzle\Service\Aws\Mws;

use Guzzle\Common\Inflector;
use Guzzle\Common\Cache\CacheAdapterInterface;
use Guzzle\Http\Plugin\ExponentialBackoffPlugin;
use Guzzle\Service\Builder\DefaultBuilder;
use Guzzle\Service\Aws\AbstractClient;
use Guzzle\Service\Aws\QueryStringAuthPlugin;
use Guzzle\Service\Aws\Signature\SignatureV2;

/**
 * Client for Amazon Marketplace Web Service
 *
 * @author Harold Asbridge <harold@shoebacca.com>
 * @author Michael Dowling <michael@guzzlephp.org>
 * @see https://developer.amazonservices.com/
 */
class MwsClient extends AbstractClient
{
    const VERSION = '2009-01-01';

    /**
     * Factory method to create a new MWS client
     *
     * @param array|Collection $config Configuration data. Array keys:
     *    base_url - Base URL of web service.  Default: https://mws.amazonservices.com/
     *    version - API version.  Defaults to 2009-02-01
     *  * access_key - AWS access key ID
     *  * secret_key - AWS secret access key
     *  * merchant_id - AWS merchant ID
     *  * marketplace_id - AWS marketplace ID
     *   application_name - Application name
     *   application_version - Application version
     *
     * @param CacheAdapterInterface $cacheAdapter (optional) Pass a cache
     *      adapter to cache the service configuration settings
     * @param int $cacheTtl (optional) How long to cache data
     *
     * @return MwsClient
     */
    public static function factory($config, CacheAdapterInterface $cache = null, $ttl = 86400)
    {
        $defaults = array(
            'base_url' => 'https://mws.amazonservices.com/',
            'version' => self::VERSION
        );
        $required = array('access_key', 'secret_key', 'merchant_id', 'marketplace_id', 'application_name', 'application_version');
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

        // Retry 500 and 503 failures using exponential backoff
        $client->getEventManager()->attach(new ExponentialBackoffPlugin());

        return DefaultBuilder::build($client, $cache, $ttl);
    }

    /**
     * Get feed class
     * 
     * @param string $feedType The type of feed ot retrieve
     *
     * @return \Guzzle\Service\Aws\Mws\Model\Feed\AbstractFeed
     */
    public function getFeed($feedType)
    {
        $class = 'Guzzle\\Service\\Aws\\Mws\\Model\\Feed\\' 
            . ucfirst(Inflector::camel($feedType));

        return new $class($this);
    }
}