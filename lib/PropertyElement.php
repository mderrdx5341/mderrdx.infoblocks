<?php
namespace Mderrdx\Infoblocks;

class PropertyElement extends Property
{
    public function value()
    {
        $iblock = IBlockContainer::getById($this->data['LINK_IBLOCK_ID']);
        if($this->isMultiple()) {
            return $iblock->getElements([
                'filter' => ['ID' => $this->data['VALUE']]
            ]);
        } else {
            return $iblock->getElementById($this->data['VALUE']);
        }
    }
}