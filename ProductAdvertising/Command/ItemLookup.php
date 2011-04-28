<?php

namespace Guzzle\Aws\ProductAdvertising\Command;

use Guzzle\Aws\ProductAdvertising\Command\AbstractCommand;
use Guzzle\Aws\ProductAdvertising\Model\Item;

/** 
 * @guzzle ItemId required="true"
 * @guzzle SearchIndex type="string" default="All"
 * @guzzle IdType type="enum" values="ASIN,SKU,UPC,EAN,ISBN" required="true" default="ASIN"
 * @guzzle ResponseGroup default="Small" type="string"
 */
class ItemLookup extends AbstractCommand
{
    const CONDITION_NEW         = 'New';
    const CONDITION_USED        = 'Used';
    const CONDITION_COLLECTIBLE = 'Collectible';
    const CONDITION_REFURBISHED = 'Refurbished';
    const CONDITION_ALL         = 'All';
    
    protected function build()
    {
        parent::build();
        
        $query = $this->request->getQuery();
        
        $query->set('Operation', 'ItemLookup')
              ->set('ItemId', $this->get('ItemId'))
              ->set('IdType', $this->get('IdType'))
              ->set('SearchIndex', $this->get('SearchIndex'));
      
        if ($query->get('IdType') == 'ISBN' && !$query->hasKey('SearchIndex')) {
            throw new \InvalidArgumentException('If IdType is ISBN, SearchIndex must be set');
        }
    }

    public function setCondition($condition)
    {
        $this->set('Condition', (string) $condition);
        return $this;
    }

    public function setItemId($id)
    {
        $this->set('ItemId', $id);
        return $this;
    }
    
    public function setIdType($idType)
    {
        $this->set('IdType', (string) $idType);
        return $this;
    }
    
    public function setRelationshipType($type)
    {
        $this->set('RelationshipType', $type);
        return $this;
    }
    
    public function setSearchIndex($index)
    {
        $this->set('SearchIndex', $index);
        return $this;
    }
    
    public function process()
    {
        parent::process();
        
        // ItemLookup response should never contain more than one Item element
        if ($this->result && count($this->result->Items->Item) == 1) {
            $item = new Item($this->result->Items->Item);
            $this->result = $item;
        } else {
            $this->result = null;
        }
    }
}