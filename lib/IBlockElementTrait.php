<?php
namespace Mderrdx\Infoblocks;

trait IBlockElementTrait
{
    protected $data;
    protected $iblock;
    protected $properties = [];

    public function iblock()
    {
        return $this->iblock;
    }
    
    public function editAreaId()
    {
        global $APPLICATION;
        $editAreaId = "bx_mderrdx_iblockelement_{$this->iblock->id()}_{$this->id()}_".microtime(true);
        $buttons = \CIBlock::GetPanelButtons(
            $this->iblock->id(),
            $this->id()
        );
        $editUrl = $buttons["edit"]["edit_element"]["ACTION_URL"];
        $deleteUrl = $buttons["edit"]["delete_element"]["ACTION_URL"] . '&' . bitrix_sessid_get();
        $editPopup = $APPLICATION->getPopupLink(['URL' => $editUrl, "PARAMS" => ['width' => 780, 'height' => 500]]);

        $btn = array(
			'URL' => "javascript:{$editPopup}",
			'TITLE' => 'Редактировать',
			'ICON' => 'bx-context-toolbar-edit-icon',
		);

        $APPLICATION->SetEditArea($editAreaId, array($btn));

        $btn = array(
			'URL' => 'javascript:if(confirm(\'' . \CUtil::JSEscape("Удалить?") . '\')) jsUtils.Redirect([], \'' . \CUtil::JSEscape($deleteUrl) . '\');',
			'TITLE' => 'Удалить',
			'ICON' => 'bx-context-toolbar-delete-icon',
		);

        $APPLICATION->SetEditArea($editAreaId, array($btn));

        return $editAreaId;
    }

    public function id()
    {
        return $this->data['ID'];
    }

    public function name(): string
    {
        return $this->data['NAME'];
    }

    public function createdDate(): \DateTime
    {
        $dateTime = new \DateTime(
            ConvertDateTime(
                $this->data['CREATED_DATE'],
                'YYYY.MM.DD'
            )
        );
        return $dateTime;
    }

    public function previewText()
    {
        return $this->data['PREVIEW_TEXT'];
    }

    public function detailText()
    {
        return $this->data['DETAIL_TEXT'];
    }

    public function url()
    {
        return $this->data['DETAIL_PAGE_URL'];
    }

    public function previewImg()
    {
        return \CFile::GetById($this->data['PREVIEW_PICTURE'])->getNext();
    }

    public function property($name)
    {
        if($this->properties[$name]) {
            return $this->properties[$name];
        }

        $props = \CIBlockElement::getProperty($this->iblock->id(), $this->id());

        while($prop = $props->getNext()) {     
            if (empty($this->properties[$prop['CODE']])) {
                if ($prop['PROPERTY_TYPE'] == 'E') {
                    $this->properties[$prop['CODE']] = new PropertyElement($prop, $this); 
                } else if ($prop['PROPERTY_TYPE'] == 'G') {
                    $this->properties[$prop['CODE']] = new PropertySection($prop, $this); 
                } else if ($prop['PROPERTY_TYPE'] == 'L') {
                    $this->properties[$prop['CODE']] = new PropertyList($prop, $this);                 
                } else {               
                    $this->properties[$prop['CODE']] = new Property($prop, $this);

                }
            }

            if ($prop['MULTIPLE'] == 'Y') {
                if (!in_array($prop['VALUE'], $this->properties[$prop['CODE']]->valueRaw())) {
                    $this->properties[$prop['CODE']]->addValue($prop['VALUE']);
                    $this->properties[$prop['CODE']]->addValueEnum($prop['VALUE_ENUM']);
                    $this->properties[$prop['CODE']]->addValueXmlId($prop['VALUE_XML_ID']);               
                }
            }
        }

        return $this->properties[$name];
    }
}