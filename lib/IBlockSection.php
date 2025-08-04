<?php
namespace Mderrdx\Infoblocks;

class IBlockSection 
{
    protected $data;
    protected $iblock;

    public function __construct($data, $iblock)
    {
        $this->data = $data;
        $this->iblock = $iblock;
    }

    public function subsections()
    {
        $subSections = $this->iblock->getSections([
            'filter' => [
                'SECTION_ID' => $this->id()
            ]
        ]);

        return $subSections;
    }

    public function elements()
    {
        return $this->iblock->getElements([
            'filter' => ['SECTION_ID' => $this->id()]
        ]);
    }

    public function id()
    {
        return $this->data['ID'];
    }

    public function title()
    {
        return $this->data['NAME'];
    }

    public function url()
    {
        return $this->data['SECTION_PAGE_URL'];
    }

    public function editAreaId()
    {
        global $APPLICATION;
        $editAreaId = "bx_mderrdx_section_{$this->iblock->code()}_{$this->id()}_".microtime(true);
        $buttons = \CIBlock::GetPanelButtons($this->iblock->id(), 0, $this->id());
        $editUrl = $buttons["edit"]["edit_section"]["ACTION_URL"];
		$deleteUrl = $buttons["edit"]["delete_section"]["ACTION_URL"] . '&' . bitrix_sessid_get();
        $editPopup = $APPLICATION->getPopupLink(['URL' => $editUrl, "PARAMS" => ['width' => 780, 'height' => 500]]);
    
        $btn = [
			'URL' => "javascript:{$editPopup}",
			'TITLE' => 'Редактировать',
			'ICON' => 'bx-context-toolbar-edit-icon',
        ];

		$APPLICATION->SetEditArea($editAreaId, array($btn));
		$btn = [
			'URL' => 'javascript:if(confirm(\'' . \CUtil::JSEscape("Удалить?") . '\')) jsUtils.Redirect([], \'' . \CUtil::JSEscape($deleteUrl) . '\');',
			'TITLE' => 'Удалить',
			'ICON' => 'bx-context-toolbar-delete-icon',
        ];
		$APPLICATION->SetEditArea($editAreaId, array($btn));
        
        return $editAreaId;
    }
}
?>