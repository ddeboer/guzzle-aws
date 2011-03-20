<?php
/**
 * @package Guzzle PHP <http://www.guzzlephp.org>
 * @license See the LICENSE file that was distributed with this source code.
 */

namespace Guzzle\Service\Aws\SimpleDb;

use Guzzle\Common\Inspector;
use Guzzle\Http\QueryString;
use Guzzle\Http\Plugin\ExponentialBackoffPlugin;
use Guzzle\Service\Aws\AbstractClient;
use Guzzle\Service\Aws\QueryStringAuthPlugin;
use Guzzle\Service\Aws\Signature\SignatureV2;

/**
 * Client for interacting with Amazon SimpleDb
 *
 * @author Michael Dowling <michael@guzzlephp.org>
 *
 * @guzzle access_key_id required="true" doc="AWS Access Key ID"
 * @guzzle secret_access_key required="true" doc="AWS Secret Access Key"
 * @guzzle protocol required="true" default="http" doc="Protocol to use with requests (http or https)"
 * @guzzle region required="true" default="sdb.amazonaws.com" doc="Amazon SimpleDB Region endpoint"
 * @guzzle base_url required="true" default="{{ protocol }}://{{ region }}/" doc="SimpleDB service base URL"
 *
 * @guzzle cache.key_filter static="query=Timestamp, Signature"
 */
class SimpleDbClient extends AbstractClient
{
    const REGION_DEFAULT = 'sdb.amazonaws.com'; // Endpoint located in the US-East (Northern Virginia) Region
    const REGION_US_WEST_1 = 'sdb.us-west-1.amazonaws.com'; // Endpoint located in the US-West (Northern California) Region
    const REGION_EU_WEST_1 = 'sdb.eu-west-1.amazonaws.com'; // Endpoint located in the EU (Ireland) Region
    const REGION_AP_SOUTHEAST_1 = 'sdb.ap-southeast-1.amazonaws.com'; // Endpoint located in the Asia Pacific (Singapore) Region

    /**
     * Factory method to create a new SimpleDB client
     *
     * @param array|Collection $config Configuration data. Array keys:
     *    base_url - Base URL of web service.  Default: {{scheme}}://{{region}}/
     *    scheme - Set to http or https.  Defaults to http
     *    version - API version.  Defaults to 2009-04-15
     *    region - AWS region.  Defaults to sdb.amazonaws.com
     *  * access_key - AWS access key ID
     *  * secret_key - AWS secret access key
     *
     * @return CentinelClient
     */
    public static function factory($config)
    {
        // Passed config, default config, and required configs
        $config = Inspector::getInstance()->prepareConfig($config, array(
            'base_url' => '{{scheme}}://{{region}}/',
            'version' => '2009-04-15',
            'region' => self::REGION_DEFAULT,
            'scheme' => 'http'
        ), array('access_key', 'secret_key', 'region', 'version', 'scheme'));

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

        return $client;
    }
}