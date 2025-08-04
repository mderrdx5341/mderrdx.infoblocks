<?php
namespace Mderrdx\Infoblocks;

class Property
{
    protected $data;
    protected $element;

    public function __construct($data, $element)
    {
        $this->data = $data;
        $this->element = $element;

        if ($this->data['MULTIPLE'] === 'Y')
        {

            $this->data['VALUE'] = [];
            $this->data['VALUE'][] = $data['VALUE'];
            $this->data['VALUE_ENUM'] = [];
            $this->data['VALUE_ENUM'][] = $data['VALUE_ENUM'];
            $this->data['VALUE_XML_ID'] = [];
            $this->data['VALUE_XML_ID'][] = $data['VALUE_XML_ID'];
        }
    }

    public function isMultiple()
    {
        return $this->data['MULTIPLE'] === 'Y';
    }

    public function value()
    {
        return $this->data['VALUE'];
    }

    public function valueRaw()
    {
        return $this->data['VALUE'];
    }

    public function addValue($value)
    {
        if ($this->data['MULTIPLE'] === 'Y') {
            $this->data['VALUE'][] = $value;
        } else {
            $this->setValue($value);
        }
    }

    public function setValue($value)
    {
        $this->data['VALUE'] = $value;
    }

    public function addValueEnum($value)
    {
        if ($this->data['MULTIPLE'] === 'Y')
        {
            $this->data['VALUE_ENUM'][] = $value;
        } else {
            $this->setValueEnum($value);
        }
    }

    public function setValueEnum($value)
    {
        $this->data['VALUE_ENUM'] = $value;
    }

    public function addValueXmlId($value)
    {
        if ($this->data['MULTIPLE'] === 'Y')
        {
            $this->data['VALUE_XML_ID'][] = $value;
        } else {
            $this->setValueXmlId($value);
        }
    }

    public function setValueXmlId($value)
    {
        $this->data['VALUE_XML_ID'] = $value;
    }

}