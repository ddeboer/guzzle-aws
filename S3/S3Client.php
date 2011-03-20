<?php
/**
 * @package Guzzle PHP <http://www.guzzlephp.org>
 * @license See the LICENSE file that was distributed with this source code.
 */

namespace Guzzle\Service\Aws\S3;

use Guzzle\Guzzle;
use Guzzle\Common\Inspector;
use Guzzle\Http\QueryString;
use Guzzle\Http\Message\RequestInterface;
use Guzzle\Http\Message\Request;
use Guzzle\Http\Plugin\ExponentialBackoffPlugin;
use Guzzle\Service\Aws\AbstractClient;

/**
 * Client for interacting with Amazon S3
 *
 * @author Michael Dowling <michael@guzzlephp.org>
 */
class S3Client extends AbstractClient
{
    const REGION_DEFAULT = 's3.amazonaws.com';
    const REGION_US_WEST_1 = 's3-us-west-1.amazonaws.com';
    const REGION_AP_SOUTHEAST_1 = 's3-ap-southeast-1.amazonaws.com';
    const REGION_EU = 's3-eu-west-1.amazonaws.com';

    const BUCKET_LOCATION_US = 'US';
    const BUCKET_LOCATION_EU = 'EU';
    const BUCKET_LOCATION_US_WEST_1 = 'us-west-1';
    const BUCKET_LOCATION_AP_SOUTHEAST_1 = 'ap-southeast-1';

    const ACL_PRIVATE = 'private';
    const ACL_PUBLIC_READ = 'public-read';
    const ACL_READ_WRITE = 'public-read-write';
    const ACL_AUTH_READ = 'authenticated-read';
    const ACL_OWNER_READ = 'bucket-owner-read';
    const ACL_OWNER_FULL = 'bucket-owner-full-control';

    const PAYER_REQUESTER = 'Requester';
    const PAYER_BUCKET_OWNER = 'BucketOwner';

    const GRANT_TYPE_EMAIL = 'AmazonCustomerByEmail';
    const GRANT_TYPE_USER = 'CanonicalUser';
    const GRANT_TYPE_GROUP = 'Group';

    const GRANT_AUTH = 'http://acs.amazonaws.com/groups/global/AuthenticatedUsers';
    const GRANT_ALL = 'http://acs.amazonaws.com/groups/global/AllUsers';
    const GRANT_LOG = 'http://acs.amazonaws.com/groups/s3/LogDelivery';

    const GRANT_READ = 'READ';
    const GRANT_WRITE = 'WRITE';
    const GRANT_READ_ACP = 'READ_ACP';
    const GRANT_WRITE_ACP = 'WRITE_ACP';
    const GRANT_FULL_CONTROL = 'FULL_CONTROL';

    /**
     * @var bool Force the client reference buckets using path hosting
     */
    protected $forcePathHosting = false;

    /**
     * Factory method to create a new S3 client
     *
     * @param array|Collection $config Configuration data. Array keys:
     *    base_url - Base URL of web service.  Default: {{scheme}}://{{region}}/
     *    scheme - Set to http or https.  Defaults to http
     *    region - AWS region.  Defaults to s3.amazonaws.com
     *    access_key - AWS access key ID.  Set to sign requests.
     *    secret_key - AWS secret access key. Set to sign requests.
     *
     * @return S3Client
     */
    public static function factory($config)
    {
        $defaults = array(
            'base_url' => '{{scheme}}://{{region}}/',
            'region' => self::REGION_DEFAULT,
            'scheme' => 'http'
        );
        $required = array('region', 'scheme');
        $config = Inspector::prepareConfig($config, $defaults, $required);

        // Filter our the Timestamp and Signature query string values from cache
        $config->set('cache.key_filter', 'header=Date, Authorization; query=Timestamp, Signature');

        // If an access key and secret access key were provided, then the client
        // requests will be authenticated
        if ($config->get('access_key') && $config->get('secret_key')) {
            $signature = new S3Signature($config->get('access_key'), $config->get('secret_key'));
        }

        $client = new self(
            $config->get('base_url'),
            $config->get('access_key'),
            $config->get('secret_key'),
            null,
            $signature
        );
        $client->setConfig($config);

        // If signing requests, add the request signing plugin
        if ($signature) {
            $client->getEventManager()->attach(
                new SignS3RequestPlugin($signature), -99999
            );
        }

        // Retry 500 and 503 failures using exponential backoff
        $client->getEventManager()->attach(new ExponentialBackoffPlugin());

        // If Amazon DevPay tokens were provided, then add a DevPay filter
        if ($config->get('devpay_user_token') && $config->get('devpay_product_token')) {
            // Add the devpay plugin pretty soon in the event emissions
            $client->getEventManager()->attach(
                new DevPayPlugin(
                    $config->get('devpay_user_token'),
                    $config->get('devpay_product_token')
                ), 9999
            );
        }

        return $client;
    }

    /**
     * Find out if a string is a valid name for an Amazon S3 bucket.
     *
     * @param string $bucket The name of the bucket to check.
     *
     * @return bool TRUE if the bucket name is valid or FALSE if it is invalid.
     */
    public static function isValidBucketName($bucket)
    {
        $bucketLen = strlen($bucket);
        if ($bucketLen < 3
            // 3 < bucket < 63
            || $bucketLen > 63
            // Cannot start or end with a '.'
            || $bucket[0] == '.'
            || $bucket[$bucketLen - 1] == '.'
            // Cannot look like an IP address
            || preg_match('/^\d+\.\d+\.\d+\.\d+$/', $bucket)
            // Cannot include special characters or _
            || !preg_match('/^[a-z0-9]([a-z0-9\\-.]*[a-z0-9])?$/', $bucket)) {
            return false;
        }

        return true;
    }

    /**
     * Check if the client is forcing path hosting buckets
     *
     * @return bool
     */
    public function isPathHostingBuckets()
    {
        return $this->forcePathHosting;
    }

    /**
     * Set whether or not the client is forcing path hosting buckets
     *
     * @param bool $forcePathHosting Set to TRUE to reference buckets using the
     *      path hosting address
     *
     * @return S3Client
     */
    public function setForcePathHostingBuckets($forcePathHostring)
    {
        $this->forcePathHosting = (bool)$forcePathHostring;
        
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function createRequest($method = RequestInterface::GET, $uri = null, $inject = null)
    {
        $request = parent::createRequest($method, $uri, $inject);
        $request->setHeader('Date', Guzzle::getHttpDate('now'))
                ->setHeader('Host', $request->getHost());

        return $request;
    }

    /**
     * Get an Amazon S3 ready request
     *
     * @param string $method The HTTP method
     * @param string $bucket (optional)
     * @param string $key (optional)
     *
     * @return RequestInterface
     */
    public function getS3Request($method, $bucket = null, $key = null)
    {
        $request = $this->createRequest($method);

        if (!$bucket) {
            return $request;
        }

        $bucket = rawurlencode($bucket);

        if ($this->forcePathHosting) {
            $url = $this->getBaseUrl() . $bucket;
        } else {
            $url = $this->inject('{{scheme}}://' . $bucket . '.{{region}}/');
        }

        if ($key) {
            if (strcmp($url[strlen($url) - 1], '/')) {
                $url .= '/';
            }
            $url .= rawurlencode($key);
        }

        $request->setUrl($url);

        return $request;
    }

    /**
     * Get a signed URL that is valid for a specific amount of time	for a virtual
     * hosted bucket.
     *
     * @param string $bucket The bucket of the object.
     * @param string $key The key of the object.
     * @param int $duration The number of seconds the URL is valid.
     * @param bool $cnamed Whether or not the bucket should be referenced by a
     *      CNAMEd URL.
     * @param bool $torrent Set to true to append ?torrent and retrieve the
     *      torrent of the file.
     *
     * @return string Returns a signed URL.
     *
     * @throws LogicException when $torrent and $requesterPays is passed.
     *
     * @link http://docs.amazonwebservices.com/AmazonS3/2006-03-01/index.html?RESTAuthentication.html
     */
    public function getSignedUrl($bucket, $key, $duration, $cnamed = false, $torrent = false, $requesterPays = false)
    {
        if ($torrent && $requesterPays) {
            throw new \InvalidArgumentException('Cannot use ?requesterPays with ?torrent.');
        }

        $expires = time() + (($duration) ? $duration : 60);
        $plugin = $this->getEventManager()->getAttached('Guzzle\\Service\\Aws\\S3\\SignS3RequestPlugin');
        $plugin = isset($plugin[0]) ? $plugin[0] : false;
        $isSigned = ($plugin != false);
        $xAmzHeaders = $torrentStr = '';
        $url = 'http://' . $bucket . (($cnamed) ? '' : ('.' . $this->getConfig()->get('region')));

        if ($key) {
            $url .= '/' . $key;
        }

        $qs = new QueryString();

        if ($isSigned) {
            $qs->add('AWSAccessKeyId', $this->getAccessKeyId())
               ->add('Expires', $expires);
        }

        if ($torrent) {
            $qs->add('torrent', false);
            $torrentStr = '?torrent';
        } else if ($requesterPays) {
            $qs->add('x-amz-request-payer', 'requester');
            $xAmzHeaders .= 'x-amz-request-payer:requester' . "\n";
        }

        if ($isSigned) {
            $strToSign = sprintf("GET\n\n\n{$expires}\n{$xAmzHeaders}/%s/%s{$torrentStr}", QueryString::rawurlencode($bucket, array('/')), QueryString::rawurlencode($key, array('/')));
            $qs->add('Signature', $plugin->getSignature()->signString($strToSign));
        }

        return $url . $qs;
    }
}