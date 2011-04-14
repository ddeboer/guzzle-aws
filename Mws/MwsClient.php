<?php
/**
 * @package Guzzle PHP <http://www.guzzlephp.org>
 * @license See the LICENSE file that was distributed with this source code.
 */

namespace Guzzle\Aws\Mws;

use Guzzle\Common\Inspector;
use Guzzle\Common\Inflector;
use Guzzle\Http\Plugin\ExponentialBackoffPlugin;
use Guzzle\Aws\AbstractClient;
use Guzzle\Aws\QueryStringAuthPlugin;
use Guzzle\Aws\Signature\SignatureV2;

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
     * @return MwsClient
     */
    public static function factory($config)
    {
        $defaults = array(
            'base_url' => 'https://mws.amazonservices.com/',
            'version' => self::VERSION
        );
        $required = array('access_key', 'secret_key', 'merchant_id', 'marketplace_id', 'application_name', 'application_version');
        $config = Inspector::prepareConfig($config, $defaults, $required);

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
        $client->getEventManager()->attach(new ExponentialBackoffPlugin(3, null, function($try){
            return 60;
        }));

        return $client;
    }

    /**
     * Get feed class
     *
     * @param string $feedType The type of feed ot retrieve
     *
     * @return \Guzzle\Aws\Mws\Model\Feed\AbstractFeed
     */
    public function getFeed($feedType)
    {
        $class = 'Guzzle\\Aws\\Mws\\Model\\Feed\\'
            . ucfirst(Inflector::camel($feedType));

        return new $class($this);
    }
}