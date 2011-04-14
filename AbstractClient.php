<?php
/**
 * @package Guzzle PHP <http://www.guzzlephp.org>
 * @license See the LICENSE file that was distributed with this source code.
 */

namespace Guzzle\Aws;

use Guzzle\Service\Client;
use Guzzle\Aws\Signature\AbstractSignature;

/**
 * Abstract AWS Client
 *
 * @author Michael Dowling <michael@guzzlephp.org>
 */
abstract class AbstractClient extends Client
{
    /**
     * @var Signature
     */
    protected $signature;

    /**
     * @var string AWS access key ID
     */
    protected $accessKey;

    /**
     * @var string AWS secret key
     */
    protected $secretKey;

    /**
     * @var string Service version
     */
    protected $version;
    
    /**
     * Default AWS client constructor.  Clients must be created using a factory
     *
     * @param string $baseUrl Service base URL
     * @param string $accessKey AWS access key ID
     * @param string $secretKey AWS secret key
     * @param string $version (optional) Service version
     * @param AbstractSignature $signature (optional) AWS signature
     */
    public function __construct($baseUrl, $accessKey, $secretKey, $version = null, AbstractSignature $signature = null)
    {
        parent::__construct($baseUrl);
        $this->accessKey = $accessKey;
        $this->secretKey = $secretKey;
        $this->version = $version;
        $this->signature = $signature;
    }
    
    /**
     * Get the AWS Access Key ID
     *
     * @return string
     */
    public function getAccessKeyId()
    {
        return $this->accessKey;
    }

    /**
     * Get the AWS Secret Access Key
     *
     * @return string
     */
    public function getSecretAccessKey()
    {
        return $this->secretKey;
    }

    /**
     * Get the AWS signature object
     *
     * @return string
     */
    public function getSignature()
    {
        return $this->signature;
    }
}