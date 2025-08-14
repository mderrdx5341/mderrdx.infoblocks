<?php
namespace Mderrdx\Infoblocks;

class IBlockElement
{
    use IBlockElementTrait;

    public function __construct($data, $iblock)
    {
        $this->data = $data;
        $this->iblock = $iblock;
        /*
        if (is_numeric($data['DETAIL_PICTURE'])) {
			$this->data['DETAIL_PICTURE'] = \CFile::MakeFileArray($data['DETAIL_PICTURE']);
		}

		if (is_numeric($data['PREVIEW_PICTURE'])) {
			$this->data['PREVIEW_PICTURE'] = \CFile::MakeFileArray($data['PREVIEW_PICTURE']);
		}
        */
    }
}
?>