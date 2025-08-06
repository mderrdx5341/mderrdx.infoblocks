<?php
namespace Mderrdx\Infoblocks;

class IBlockElement
{
    use IBlockElementTrait;

    public function __construct($data, $iblock)
    {
        $this->data = $data;
        $this->iblock = $iblock;
    }
}
?>