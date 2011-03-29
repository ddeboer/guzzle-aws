<?php
/**
 * @package Guzzle PHP <http://www.guzzlephp.org>
 * @license See the LICENSE file that was distributed with this source code.
 */

namespace Guzzle\Service\Aws;

use Guzzle\Common\Event\Observer;
use Guzzle\Common\Event\Subject;
use Guzzle\Http\Message\RequestInterface;
use Guzzle\Service\Aws\Filter\AddRequiredQueryStringFilter;
use Guzzle\Service\Aws\Filter\QueryStringSignatureFilter;

class QueryStringAuthPlugin implements Observer
{
    /**
     * {@inheritdoc}
     */
    protected $priority = -999;

    /**
     * @var Signature\AbstractSignature
     */
    private $signature;

    /**
     * @var string API version of the service
     */
    private $apiVersion;

    /**
     * Construct a new request signing plugin
     *
     * @param Signature\AbstractSignature $signature Signature object used to sign requests
     * @param string $apiVersion API version of the service
     */
    public function __construct(Signature\AbstractSignature $signature, $apiVersion)
    {
        $this->signature = $signature;
        $this->apiVersion = $apiVersion;
    }

    /**
     * Get the signature object used to sign requests
     *
     * @return Signature\AbstractSignature
     */
    public function getSignature()
    {
        return $this->signature;
    }

    /**
     * Get the API version of the service
     *
     * @return string
     */
    public function getApiVersion()
    {
        return $this->apiVersion;
    }

    /**
     * Add required query string fields to a request
     *
     * @param RequestInterface $request Request to modify
     */
    public function addRequiredQueryString(RequestInterface $request)
    {
        $qs = $request->getQuery();
        // Add required parameters to the request
        $qs->set('Timestamp', gmdate('c'));
        $qs->set('Version', $this->apiVersion);
        $qs->set('SignatureVersion', $this->signature->getVersion());
        // Signature V2 and onward functionality
        if ((int) $this->signature->getVersion() > 1) {
            $qs->set('SignatureMethod', $this->signature->getAwsHashingAlgorithm());
        }
        $qs->set('AWSAccessKeyId', $this->signature->getAccessKeyId());
    }

    /**
     * Add a query string signature to a request
     *
     * @param RequestInterface $request Request to modify
     */
    public function addQueryStringSignature(RequestInterface $request)
    {
        $qs = $request->getQuery();

        // Create a string that needs to be signed using the request settings
        $strToSign = $this->signature->calculateStringToSign($qs->getAll(), array(
            'endpoint' => $request->getUrl(),
            'method' => $request->getMethod()
        ));

        // Add the signature to the query string of the request
        $qs->set('Signature', $this->signature->signString($strToSign));

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function update(Subject $subject, $event, $context = null)
    {
        if ($subject instanceof RequestInterface && $event == 'request.before_send') {
            $this->addRequiredQueryString($subject);
            $this->addQueryStringSignature($subject);
        }
    }
}