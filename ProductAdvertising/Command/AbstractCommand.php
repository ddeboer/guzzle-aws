<?php

namespace Guzzle\Aws\ProductAdvertising\Command;

use Guzzle\Service\Command\AbstractCommand as BaseAbstractCommand;

/**
 * @guzzle ResponseGroup default="Small" type="enum:Accessoires,BrowseNodes,EditorialReview,Images,ItemAttributes,ItemIds"
 */
class AbstractCommand extends BaseAbstractCommand
{
    protected function build()
    {
        $this->request = $this->client->get();
        
        $query = $this->request->getQuery();
        $query->set('Service', 'AWSECommerceService');
        $query->set('ResponseGroup', $this->get('ResponseGroup'));
    }

    /**
     * Set response group
     * 
     * @param string $responseGroup
     * @return AbstractCommand 
     */
    public function setResponseGroup($responseGroup)
    {
        $this->set('ResponseGroup', $responseGroup);
        return $this;
    }
}