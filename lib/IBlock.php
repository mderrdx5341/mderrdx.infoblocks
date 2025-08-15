<?php
namespace Mderrdx\Infoblocks;

use \Bitrix\Main\Loader;
use CIBlockElement;
use CIBlockSection;

Loader::includeModule('iblock');

class IBlock
{
    private $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function id()
    {
        return $this->data['ID'];
    }

    public function code()
    {
        return $this->data['CODE'];
    }

    public function description()
    {
        return $this->data['DESCRIPTION'];
    }

    public function name()
    {
        return $this->data['NAME'];
    }

    public function getSections($args, $className = '')
    {
        $className = ($className === '' ? IBlockContainer::getClassSection($this->id()) : $className);

        $res = CIBlockSection::getList(
            [],
            array_merge(['IBLOCK_ID' => $this->id()], $args['filter']),
            false,
            []
        );
        $sections = [];
        while($section = $res->getNext()) {
            $sections[] = ($className !== '' ? new $className($section, $this) : new IBlockSection($section, $this));
        }

        return $sections;
    }

    public function getSectionById($id, $className = '')
    {
        
        $res = CIBlockSection::getList(
            [],
            ['IBLOCK_ID' => $this->id(), 'ID' => $id],
            false,
            []
        );
        $section = null;
        while($sectionData = $res->getNext()) {
            $className = ($className === '' ? IBlockContainer::getClassSection($this->id()) : $className);
            $section = $className ? new $className($sectionData, $this) : new IBlockSection($sectionData, $this);
        }

        return $section;
    }

    public function getSectionByCode($code, $className = '')
    {
       
        $res = CIBlockSection::getList(
            [],
            ['IBLOCK_ID' => $this->id(), 'CODE' => $code],
            false,
            []
        );
        $section = null;
        while($sectionData = $res->getNext()) {
            $className = ($className === '' ? IBlockContainer::getClassSection($this->id()) : $className);
            $section = $className ? new $className($sectionData, $this) : new IBlockSection($sectionData, $this);
        }

        return $section;
    }

    public function getElements($args, $className ='')
    {
        $res = CIBlockElement::getList(
            [],
            array_merge(['IBLOCK_ID' => $this->id()], $args['filter']),
            false,
            false,
            []
        );

        $items = [];
        $className = ($className === '' ? IBlockContainer::getClassElement($this->id()) : $className);
        while ($item = $res->getNext())
        {
            $items[] = $className ? new $className($item, $this) : new IBlockElement($item, $this);
        }

        return $items;
    }

    public function getElementById($id, $className = '')
    {
        $res = CIBlockElement::getList(
            [],
            ['IBLOCK_ID' => $this->id(), 'ID' => $id],
            false,
            false,
            []
        );

        $element = null;
        while ($item = $res->getNext())
        {
            $className = ($className === '' ? IBlockContainer::getClassElement($this->id()) : $className);
            $element = $className ? new $className($item, $this) : new IBlockElement($item, $this);
        }

        return $element;
    }

    public function getElementByCode($code, $className = '')
    {
        $res = CIBlockElement::getList(
            [],
            ['IBLOCK_ID' => $this->id(), 'CODE' => $code],
            false,
            false,
            []
        );

        $element = null;
        while ($item = $res->getNext())
        {
            $className = ($className === '' ? IBlockContainer::getClassElement($this->id()) : $className);
            $element = $className ? new $className($item, $this) : new IBlockElement($item, $this);
        }

        return $element;
    }

    public function editAreaId()
    {
        global $APPLICATION;
        $code = $this->code();
        $editAreaId = "bx_mderrdx_iblock_{$code}_".microtime(true);
        $buttons = \CIBlock::GetPanelButtons($this->Id(), 0, 0, array("SECTION_BUTTONS" => false, "SESSID" => false));
		$addUrl = $buttons["edit"]["add_element"]["ACTION_URL"];
        $addPopup = $APPLICATION->getPopupLink(['URL' => $addUrl, "PARAMS" => ['width' => 780, 'height' => 500]]);
        $btn = array(
			'URL' => "javascript:{$addPopup}",
			'TITLE' => 'Добавить элемент',
			'ICON' => 'bx-context-toolbar-add-icon',
		);

		$APPLICATION->SetEditArea($editAreaId, array($btn));

		return $editAreaId;
    }
}