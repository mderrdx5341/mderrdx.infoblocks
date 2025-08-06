<?php
namespace Mderrdx\Infoblocks;

class PropertySection extends Property
{
    public function value()
    {
        $iblock = IBlockContainer::getById($this->data['LINK_IBLOCK_ID']);
        if($this->isMultiple()) {
            return $iblock->getSections([
                'filter' => ['ID' => $this->data['VALUE']]
            ]);
        } else {
            return $iblock->getSectionById($this->data['VALUE']);
        }
    }
}