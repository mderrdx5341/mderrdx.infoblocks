<?php
namespace Mderrdx\Infoblocks;

class PropertyList extends Property
{
    public function value()
    {
        return $this->data['VALUE_ENUM'];
    }

    public function valueXmlId()
    {
        return $this->data['VALUE_XML_ID'];
    }
}