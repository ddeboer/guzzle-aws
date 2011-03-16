<?php
/**
 * @package Guzzle PHP <http://www.guzzlephp.org>
 * @license See the LICENSE file that was distributed with this source code.
 */

namespace Guzzle\Service\Aws\Mws\Model\Feed;

use Guzzle\Common\XmlElement;

/**
 * Order fulfillment feed
 *
 * @author Harold Asbridge <harold@shoebacca.com>
 */
class OrderFulfillment extends AbstractFeed
{
    protected $messageCount = 1;

    /**
     * Initialize feed
     */
    public function init()
    {
        $this->xml->MessageType = 'OrderFulfillment';
    }

    /**
     * Add fulfillment to feed
     *
     * @param string $amazonOrderId
     * @param string $trackingNumber
     *
     * @return OrderFulfillment
     */
    public function addFulfillment($amazonOrderId, $trackingNumber)
    {
        $message = new XmlElement('<Message />');
        $message->addChild('MessageID', $this->messageCount);
        $message->addChild('OperationType', 'Update');

        $message->addChild('OrderFulfillment');
        $message->OrderFulfillment->addChild('AmazonOrderID', $amazonOrderId);
        $message->OrderFulfillment->addChild('FulfillmentDate', date('Y-m-d\TH:i:s'));
        $message->OrderFulfillment->addChild('FulfillmentData');
        $message->OrderFulfillment->FulfillmentData->addChild('CarrierCode', 'UPS');
        $message->OrderFulfillment->FulfillmentData->addChild('ShipperTrackingNumber', $trackingNumber);

        $this->xml->addChild($message);

        $this->messageCount++;

        return $this;
    }
}