<?php
/**
 * @package Guzzle PHP <http://www.guzzlephp.org>
 * @license See the LICENSE file that was distributed with this source code.
 */

namespace Guzzle\Aws\Mws\Model\Feed;

use Guzzle\Aws\Mws\MwsClient;
use Guzzle\Common\XmlElement;

/**
 * Abstract feed class
 *
 * This is used to build the basic structure
 * of a feed, to be used with the SubmitFeed command.
 *
 * @author Harold Asbridge <harold@shoebacca.com>
 */
abstract class AbstractFeed
{
    /**
     * @var MwsClient
     */
    protected $client;

    /**
     * @var XmlElement
     */
    protected $xml;

    /**
     * Init feed with shared properties
     *
     * @param MwsClient $client 
     */
    public function __construct(MwsClient $client)
    {
        $this->client = $client;

        $this->xml = new XmlElement('<AmazonEnvelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="amzn-envelope.xsd" />');

        $header = $this->xml->addChild('Header');
        $header->addChild('DocumentVersion', '1.01');
        $header->addChild('MerchantIdentifier', $client->getConfig('merchant_id'));

        $this->xml->addChild('MessageType');
        //$this->xml->addChild('PurgeAndReplace', 'false');
        //$this->xml->addChild('Message');

        $this->init();
    }

    /**
     * Initialize feed
     *
     * @codeCoverageIgnore
     */
    public function init()
    {
    }
    
    /**
     * Set purge and replace value
     *
     * @param <type> $purgeAndReplace
     *
     * @return AbstractFeed
     */
    public function setPurgeAndReplace($purgeAndReplace)
    {
        $this->xml->PurgeAndReplace = $purgeAndReplace;

        return $this;
    }

    /**
     * Get feed as XML string
     *
     * @return string
     */
    public function toString()
    {
        $xml = $this->xml->asXML();
        $doc = new \DOMDocument();
        $doc->formatOutput = true;
        $doc->loadXML($xml);
        
        return $doc->saveXML();
    }

    /**
     * Alias of toString()
     *
     * @return string
     */
    public function __toString()
    {
        return $this->toString();
    }
}