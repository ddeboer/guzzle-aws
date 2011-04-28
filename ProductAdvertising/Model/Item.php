<?php

namespace Guzzle\Aws\ProductAdvertising\Model;

class Item 
{
    protected $xml;
    
    const BINDING_PAPERBACK = 'paperback';
    const BINDING_HARDCOVER = 'hardcover';
    
    protected $binding = array(
        'Broché'            => self::BINDING_PAPERBACK,
        'Broschiert'        => self::BINDING_PAPERBACK,
        'Gebundene Ausgabe' => self::BINDING_HARDCOVER,
        'Hardcover'         => self::BINDING_HARDCOVER,        
        'Mass Market Paperback' => self::BINDING_PAPERBACK, // pocket?
        'Paperback'         => self::BINDING_PAPERBACK,
        'Poche'             => self::BINDING_PAPERBACK,           // pocket?
        'Relié'             => self::BINDING_HARDCOVER,
        'Taschenbuch'       => self::BINDING_PAPERBACK
    );
    
    public function __construct(\SimpleXMLElement $xml)
    {
        $this->xml = $xml;
    }
    
    public function __get($name)
    {
        return $this->xml->$name;
    }
    
    public function getBinding()
    {
        return $this->binding[(string) $this->xml->ItemAttributes->Binding];
    }
}